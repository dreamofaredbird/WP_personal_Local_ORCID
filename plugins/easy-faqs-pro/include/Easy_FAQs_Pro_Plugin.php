<?php
include('Easy_FAQs_Pro_Settings.php');
include('Easy_FAQs_Pro_Factory.php');

class Easy_FAQs_Pro_Plugin
{
	function __construct($base_file)
	{
		$this->base_file = $base_file;
		$this->Factory = new Easy_FAQs_Pro_Factory($base_file);
		$this->Settings = new Easy_FAQs_Pro_Settings( $this->Factory );
		$this->SearchFAQs = new EasyFAQs_SearchFAQs($this);
		$this->add_hooks();
		$this->add_shortcodes();
				
		// initialize automatic updates
		$this->init_updater();		

		// initialize Galahad so it can add its hooks
		$this->init_galahad();		
	}
	
	function add_hooks()
	{
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_css'), 10, 1 );
		
		// add Pro widgets
		add_action( 'easy_faqs_register_widgets', array($this, 'register_widgets'), 10, 1 );

		// add Pro themes
		add_filter( 'easy_faqs_themes', array($this, 'add_pro_themes'), 10, 1 );
		add_action( 'easy_faqs_enqueue_styles', array($this, 'enqueue_pro_styles'), 10, 1 );
				
		// add Conversions menu FAQs menu
		add_action( 'easy_faqs_add_menus', array($this, 'add_menus'), 10, 1 );

		// add Pro menus to the Easy FAQs Settings menu
		add_filter( 'easy_faqs_admin_submenu_pages', array($this, 'add_submenu_pages'), 10, 2 );

		// add Pro settings tabs
		add_filter( 'easy_faqs_admin_settings_tabs', array($this, 'add_settings_tabs'), 10, 1 );
		
		// add Pro Admin Contact Form tab
		add_filter( 'easy_faqs_admin_help_tabs', array($this, 'add_help_tab'), 10, 1 );
		
		// add support for the accordion
		add_filter( 'easy_faqs_display_faqs_wrapper_classes', array($this, 'add_accordion_classes'), 10, 2 );
		add_filter( 'easy_faqs_category_classes', array($this, 'add_category_classes'), 10, 2 );
		
		// enqueue Pro javascripts
		add_action( 'easy_faqs_enqueue_scripts', array($this, 'enqueue_scripts') );

		// make the list of themes available in JS (admin only)
		add_action( 'admin_init', array($this, 'provide_config_data_to_admin') );
		
		$just_activated = get_transient('easy_faqs_pro_just_activated');
		if ( !empty( $just_activated ) ) {
			add_action( 'init', array($this, 'activation_hook') );
			delete_transient('easy_faqs_pro_just_activated');
		}
	}
	
	function add_shortcodes()
	{
		// register search_faqs shortcode
		add_shortcode( 'submit_faq', array($this, 'submitFAQForm') );
		add_shortcode( 'search_faqs', array($this->SearchFAQs, 'outputSearchForm') );

		//  register dashboard widget
		add_action( 'wp_dashboard_setup', array($this->SearchFAQs, 'add_dashboard_widget') );
		
		// add an action to render the submitFAQForm (e.g., from a widget)
		add_action('easy_faqs_render_submit_faq_form', array($this, 'render_submit_faq_form'), 10, 1);

		// register Gutenburg custom blocks
		if ( function_exists('register_block_type') ) {
			register_block_type( 'easy-faqs-pro/faqs-by-category-accordion', array(
				'editor_script' 	=> 'faqs-by-category-accordion-block-editor',
				'editor_style'  	=> 'faqs-by-category-accordion-block-editor',
				'style'         	=> 'faqs-by-category-accordion-block',
				'render_callback' 	=> array($this, 'faqs_by_category_accordion_shortcode')
			) );
			
			register_block_type( 'easy-faqs-pro/list-faqs-accordion', array(
				'editor_script' 	=> 'list-faqs-accordion-block-editor',
				'editor_style'  	=> 'list-faqs-accordion-block-editor',
				'style'         	=> 'list-faqs-accordion-block',
				'render_callback' 	=> array($this, 'list_faqs_accordion_shortcode')
			) );

			register_block_type( 'easy-faqs-pro/search-faqs', array(
				'editor_script' 	=> 'search-faqs-block-editor',
				'editor_style'  	=> 'search-faqs-block-editor',
				'style'         	=> 'search-faqs-block',
				'render_callback' 	=> array($this->SearchFAQs, 'outputSearchForm')
			) );
			
			register_block_type( 'easy-faqs-pro/submit-faqs', array(
				'editor_script'		=> 'submit-faqs-block-editor',
				'editor_style'  	=> 'submit-faqs-block-editor',
				'style'         	=> 'submit-faqs-block',
				'render_callback' 	=> array($this, 'submitFAQForm')
			) );
		}
	}
	
	function do_shortcode_with_atts($shortcode, $atts)
	{
		$attr_str = '';
		foreach($atts as $key => $val) {
			$attr_str .= sprintf(' %s="%s"', $key, $val);
		}
		$shortcode = sprintf( '[%s %s]', $shortcode, trim($attr_str) );
		return do_shortcode($shortcode);
	}
	
	function faqs_by_category_accordion_shortcode($atts, $content = '')
	{
		return do_shortcode_with_atts('faqs_by_category', $atts);
	}

	function list_faqs_accordion_shortcode($atts, $content = '')
	{
		return do_shortcode_with_atts('faqs', $atts);
	}

	function activation_hook()
	{
		// clear cached data
		delete_transient('easy_faqs_pro_just_activated');
		
		// show "thank you for installing, please activate" message
		$updater = $this->Factory->get('GP_Plugin_Updater');
		if ( !$updater->has_active_license() ) {
			$updater->show_admin_notice('Thanks for installing Easy FAQs Pro! Activate your plugin now to enable automatic updates.', 'success');
			// TODO: make sure this is the correct URL
			wp_redirect( admin_url('admin.php?page=easy-faqs-license-information') );
			exit();
		}
	}
	
	function enqueue_admin_css($hook)
	{
		if ( strpos($hook, 'easy-faqs') !== false 
			|| strpos($hook, 'easy_faqs') !== false 
		) {
			wp_register_style( 'easy_faqs_pro_css', plugins_url('include/assets/css/easy_faqs_pro.css', $this->base_file) );
			wp_enqueue_style( 'easy_faqs_pro_css' );
		}
	}
	
	/**
	 * Adds the Pro themes to the theme list
	 */
	function add_pro_themes($available_themes)
	{
		$pro_themes = array(
			'banner' => array(
				'banner' => 'Banner Theme',
				'banner-gold' => 'Banner Theme - Gold',
				'banner-red' => 'Banner Theme - Red',
				'banner-green' => 'Banner Theme - Green',
				'banner-blue' => 'Banner Theme - Blue',
				'banner-purple' => 'Banner Theme - Purple',
				'banner-teal' => 'Banner Theme - Teal',
				'banner-orange' => 'Banner Theme - Orange',
				'banner-gray' => 'Banner Theme - Gray',
				'banner-maroon' => 'Banner Theme - Maroon',
				'banner-brown' => 'Banner Theme - Brown',
			),
			'casualfriday' => array(
				'casualfriday' => 'Casual Friday',
				'casualfriday-green' => 'Casual Friday - Green',
				'casualfriday-red' => 'Casual Friday - Red',
				'casualfriday-blue' => 'Casual Friday - Blue',
				'casualfriday-gray' => 'Casual Friday - Gray',
				'casualfriday-maroon' => 'Casual Friday - Maroon',
				'casualfriday-gold' => 'Casual Friday - Gold',
				'casualfriday-purple' => 'Casual Friday - Purple',
				'casualfriday-orange' => 'Casual Friday - Orange',
				'casualfriday-slate' => 'Casual Friday - Slate',
				'casualfriday-teal' => 'Casual Friday - Teal',
				'casualfriday-brown' => 'Casual Friday - Brown',
				'casualfriday-indigo' => 'Casual Friday - Indigo',
				'casualfriday-pink' => 'Casual Friday - Pink',
			),			
			'classic' => array(
				'classic' => 'Classic Theme',
				'classic-gray' => 'Classic Theme - Black',
				'classic-green' => 'Classic Theme - Green',
				'classic-purple' => 'Classic Theme - Purple',
				'classic-black' => 'Classic Theme - Black',
				'classic-orange' => 'Classic Theme - Orange',
				'classic-blue' => 'Classic Theme - Blue',
				'classic-red' => 'Classic Theme - Red',
				'classic-brown' => 'Classic Theme - Brown',
				'classic-gold' => 'Classic Theme - Gold',
				'classic-teal' => 'Classic Theme - Teal',
				'classic-pink' => 'Classic Theme - Pink',
				'classic-indigo' => 'Classic Theme - Indigo',
				'classic-maroon' => 'Classic Theme - Maroon',
			),			
			'corporate' => array(
				'corporate' => 'Corporate Theme',
				'corporate-blue' => 'Corporate Theme - Blue',
				'corporate-red' => 'Corporate Theme - Red',
				'corporate-gray' => 'Corporate Theme - Gray',
				'corporate-green' => 'Corporate Theme - Green',
				'corporate-teal' => 'Corporate Theme - Teal',
				'corporate-gold' => 'Corporate Theme - Gold',
				'corporate-skyblue' => 'Corporate Theme - Sky Blue',
				'corporate-slate' => 'Corporate Theme - Slate',
				'corporate-purple' => 'Corporate Theme - Purple',
				'corporate-orange' => 'Corporate Theme - Orange',
				'corporate-indigo' => 'Corporate Theme - Indigo',
				'corporate-brown' => 'Corporate Theme - Brown',
			),
			'deco' => array(
				'deco' => 'Deco Theme',
				'deco-salmon' => 'Deco Theme - Salmon',
				'deco-smoke' => 'Deco Theme - Smoke',
				'deco-gold' => 'Deco Theme - Gold',
				'deco-teal' => 'Deco Theme - Teal',
				'deco-orange' => 'Deco Theme - Orange',
				'deco-purple' => 'Deco Theme - Purple',
				'deco-blue' => 'Deco Theme - Blue',
				'deco-green' => 'Deco Theme - Green',
				'deco-gray' => 'Deco Theme - Gray',
				'deco-red' => 'Deco Theme - Red',
				'deco-brown' => 'Deco Theme - Brown',
				'deco-indigo' => 'Deco Theme - Indigo',
				'deco-pink' => 'Deco Theme - Pink',
				'deco-maroon' => 'Deco Theme - Maroon',
				'deco-lightgreen' => 'Deco Theme - Light Green',
			),
			'future' => array(
				'future' => 'Future Theme',
				'future-slate' => 'Future Theme - Slate',
				'future-gray' => 'Future Theme - Gray',
				'future-skyblue' => 'Future Theme - Sky Blue',
				'future-red' => 'Future Theme - Red',
				'future-green' => 'Future Theme - Green',
				'future-gold' => 'Future Theme - Gold',
				'future-blue' => 'Future Theme - Blue',
				'future-purple' => 'Future Theme - Purple',
				'future-teal' => 'Future Theme - Teal',
				'future-orange' => 'Future Theme - Orange',
				'future-maroon' => 'Future Theme - Maroon',
				'future-brown' => 'Future Theme - Brown',
			),			
			'modern' => array(
				'modern' => 'Modern Theme',
				'modern-gray' => 'Modern Theme - Gray',
				'modern-gold' => 'Modern Theme - Gold',
				'modern-green' => 'Modern Theme - Green',
				'modern-lightgreen' => 'Modern Theme - Light Green',
				'modern-blue' => 'Modern Theme - Blue',
				'modern-indigo' => 'Modern Theme - Indigo',
				'modern-purple' => 'Modern Theme - Purple',
				'modern-slate' => 'Modern Theme - Slate',
				'modern-orange' => 'Modern Theme - Orange',
				'modern-brown' => 'Modern Theme - Brown',
				'modern-maroon' => 'Modern Theme - Maroon',
				'modern-red' => 'Modern Theme - Red',
				'modern-teal' => 'Modern Theme - Teal',
			),
			'notch' => array(
				'notch' => 'Notch Theme',
				'notch-red' => 'Notch Theme - Red',
				'notch-purple' => 'Notch Theme - Purple',
				'notch-blue' => 'Notch Theme - Blue',
				'notch-green' => 'Notch Theme - Green',
				'notch-orange' => 'Notch Theme - Orange',
				'notch-gray' => 'Notch Theme - Gray',
				'notch-teal' => 'Notch Theme - Teal',
				'notch-gold' => 'Notch Theme - Gold',
				'notch-slate' => 'Notch Theme - Slate',
				'notch-maroon' => 'Notch Theme - Maroon',
			),
			'retro' => array(
				'retro' => 'Retro Theme',
				'retro-blue' => 'Retro Theme - Blue',
				'retro-red' => 'Retro Theme - Red',
				'retro-green' => 'Retro Theme - Green',
				'retro-maroon' => 'Retro Theme - Maroon',
				'retro-teal' => 'Retro Theme - Teal',
				'retro-gray' => 'Retro Theme - Gray',
				'retro-gold' => 'Retro Theme - Gold',
				'retro-purple' => 'Retro Theme - Purple',
				'retro-orange' => 'Retro Theme - Orange',
				'retro-slate' => 'Retro Theme - Slate',
				'retro-brown' => 'Retro Theme - Brown',
			)
		);
		return array_merge($available_themes, $pro_themes);
	}
	
	/** 
	 * Enqueues the Pro themes' CSS file. Hooked to the easy_faqs_enqueue_styles
	 * action.
	 *
	 * @param string The currently selected theme.
	 */	 
	function enqueue_pro_styles($current_theme = '')
	{
		// don't enqueue Pro themes if no_style is selected
		if ( 'no_style' == $current_theme ) {
			return;
		}

		wp_register_style( 
			'easy_faqs_pro_themes', 
			plugins_url('include/assets/css/pro_themes.css', $this->base_file)
		);
		wp_enqueue_style( 'easy_faqs_pro_themes' );
	}
	
	/** 
	 * Adds Pro settings tabs to admin. Hooks into filter 
	 * "easy_faqs_admin_settings_tabs"
	 *
	 * @param array $tabs Array of GP_Sajak tabs. 
	 *
	 * @retutn array Modified list of tabs. All array entries require  
					 'id', 'label', 'callback', and 'options' keys.
	 */	 
	function add_settings_tabs($tabs)
	{
		$tabs[] = array(
			'id' => 'pro_settings', 
			'label' => __('Pro Settings', 'easy-faqs'),
			'callback' => array($this->Settings, 'output_pro_settings_fields'),
			'options' => array('icon' => 'cog')
		);
		return $tabs;
	}
	
	/** 
	 * Adds Pro settings tabs to admin. Hooks into filter 
	 * "easy_faqs_admin_settings_tabs"
	 *
	 * @param array $tabs Array of GP_Sajak tabs. 
	 *
	 * @retutn array Modified list of tabs. All array entries require  
					 'id', 'label', 'callback', and 'options' keys.
	 */	 
	function add_help_tab($tabs)
	{
		$galahad = $this->Factory->get('GP_Galahad');
		$tabs[] = array(
			'id' => 'contact_support', 
			'label' => __('Contact Support', 'easy-faqs'),
			'callback' => array($galahad, 'output_contact_page'),
			'options' => array('icon' => 'envelope-o')
		);
		return $tabs;
	}
	
	function add_menus($top_level_slug)
	{
		// Add a quick links to Conversions under the Easy FAQs menu
		add_submenu_page(
			$top_level_slug,
			'License Information', 
			'License Information',
			'manage_options', 
			'easy-faqs-license-information',
			array($this->Settings, 'render_license_information_page')
		);
	}
	
	function add_submenu_pages($submenu_pages, $top_level_slug)
	{
		$new_pages = array();
		$new_pages[] = array(
			'page_title' => __('Question Form Options', 'easy-faqs'),
			'menu_title' => __('Question Form Options', 'easy-faqs'),
			'capability' => 'administrator',
			'menu_slug' => 'easy-faqs-submission-form-options',
			'callback' => array($this->Settings, 'submission_form_options')
		);
		$new_pages[] = array(
			'page_title' => __('Import & Export', 'easy-faqs'),
			'menu_title' => __('Import & Export', 'easy-faqs'),
			'capability' => 'administrator',
			'menu_slug' => 'easy-faqs-import-export',
			'callback' => array($this->Settings, 'import_export_page')
		);
		$new_pages[] = array(
			'page_title' => __('Recent Searches', 'easy-faqs'),
			'menu_title' => __('Recent Searches', 'easy-faqs'),
			'capability' => 'administrator',
			'menu_slug' => 'easy-faqs-recent-searches',
			'callback' => array($this->Settings, 'recent_searches_page')
		);
		return $this->array_insert($new_pages, $submenu_pages, 2);
	}
	
	function array_insert($arr_insert, $arr_target, $pos)
	{
        if (!is_array($arr_insert) || !is_array($arr_target) || $pos <= 0) {
			return $arr_target;
		}
        return array_merge( array_slice($arr_target, 0, $pos), $arr_insert, array_slice($arr_target, $pos) );
    }
	
	function render_submit_faq_form($atts = array())
	{
		echo $this->submitFAQForm($atts);
	}
	
	/*
	 * Either 
	 *	1) displays the Submit a Question form, or processes (if no POST data)
	 *  2) parses the posted data, saves the question to DB, and 
	 *		redirects/shows Thank You message.
	 *
	 * Can be wired up to submit faq shortcode. Is also called via an action
	 * from the widget.
	 */	
	function submitFAQForm($atts)
	{
		$content = '';

		// process form submissions
		$result = $this->parse_new_question_from_post();
		if ( !empty($result['post']) ) {
			/* 
			 * Successfully parsed the post data. save the post and redirect to the Thank You page
			 */
			
			// save post
			$new_id = wp_insert_post($result['post']);			   
			$inserted = true;
			
			// send notification email
			$submitted_question = array(
				'post' => $result['post']
			);			
			$this->easy_faqs_send_notification_email($submitted_question);
			
			// redirect, or show Thank You message
			$redirect_url = get_option('easy_faqs_submit_success_redirect_url','');			
			if ( !empty($redirect_url) ) {
				$content .= '<script type="text/javascript">window.location.replace("'.$redirect_url.'");</script>';
			} else {					
				$content .= '<p class="easy_faqs_submission_success_message">' . get_option('easy_faqs_submit_success_message','Thank You For Your Submission!') . '</p>';
			}
		}
		else if ( !empty($result['errors']) ) {
			/* 
			 * A question was posted, but there was an error parsing the post data.
			 * Show the error messages and the form again.
			 */
			if (!empty($error_message)) {
				$content .= $error_message;
			}
		
			// add FAQ form 
			if ( !$inserted ) {
				$content .= $this->get_faq_form(
					$atts,
					$result['errors']['title_error'],
					$result['errors']['body_error'],
					$result['errors']['captcha_error']
				);
			}	   
		}
		else {
			// just show the form
			$content .= $this->get_faq_form($atts);
		}
		
		return $content;
	}
	
	function parse_new_question_from_post($delete_after_capture = true)
	{		
		// process form submissions
		$inserted = false;
		$title_error = '';
		$body_error = '';
		$captcha_error = '';
   
		// if a question was posted, attempt to parse it
		// if possible, insert it into the database
		// if not, generate error messages
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['action']) && $_POST['action'] == "post_faq" && !empty($_POST['submit_faq_form_id']) ) {

			
			// grab form ID
			$form_id = !empty($_POST['submit_faq_form_id'])
					   ? intval($_POST['submit_faq_form_id'])
					   : '';
			$form_key = 'submit_faq_' . $form_id;
			$form_data = !empty($_POST[$form_key])
						 ? $_POST[$form_key]
						 : array();
						 
			$do_not_insert = false;
			
			if ( !empty($form_data['the-title']) ) {
				$title = $this->get_str('QUESTION_FROM'). $form_data['the-title'];
			} else {
				$title_error = '<p class="easy_faqs_error">' . htmlentities( $this->get_str('FAQ_FORM_ERROR_NAME') ) . '</p>';
				$do_not_insert = true;
			}	
		   
			if ( !empty($form_data['the-body']) ) {
				$body = $form_data['the-body'];
			} else {
				$body_error = '<p class="easy_faqs_error">' . htmlentities( $this->get_str('FAQ_FORM_ERROR_QUESTION') ) . '</p>';
				$do_not_insert = true;
			}		
		
			if ( class_exists('ReallySimpleCaptcha') && get_option('easy_faqs_use_captcha',0) ) {
				$correct = $this->easy_faqs_check_captcha(); 
				if (!$correct) {
					$captcha_error = '<p class="easy_faqs_error">' . htmlentities( $this->get_str('FAQ_FORM_ERROR_CAPTCHA') ) . '</p>';
					$do_not_insert = true;
				}
			}
		   
			if (!$do_not_insert) {
				
				$post = array(
						'post_title'    => $title,
						'post_content'  => $body,
						'post_category' => array(1),  // custom taxonomies too, needs to be an array
						'post_status'   => 'pending',
						'post_type'     => 'faq'
				);
				
				if ($delete_after_capture) {
					unset($_POST[$form_key]);
					unset($_POST['submit_faq_form_id']);
				}
				
				return compact('post');
			   
			} else {
				return array( 'errors' => compact('title_error', 'body_error', 'captcha_error') );
			}
		}  
		return false; // nothing submitted
	}

	function get_submit_form_header($heading_text = '')
	{
		// default class and text
		$heading_class = 'easy_faqs_form_heading';
		
		// return the formatted heading
		$output = sprintf('<h2 class="%s">%s</h2>', $heading_class, $heading_text);
		return apply_filters('easy_faqs_submit_form_header', $output, $heading_text, $heading_class);
	}	
	
	// render the Submit FAQ Form, and return the HTML
	function get_faq_form($atts, $title_error = '', $body_error = '', $captcha_error = '')
	{
		$rnd_form_id = rand(1000, 100000);
		$form_title_html = !empty($atts['title'])
						   ? $this->get_submit_form_header($atts['title'])
						   : '';
		ob_start();
		?>		
		<!-- New Post Form -->
		<div id="postbox">
			<?php echo $form_title_html; ?>
			<form id="new_post" name="new_post" method="post">
				<div class="easy_faqs_field_wrap <?php if ( !empty($title_error) ) { echo "easy_faqs_field_wrap_error"; }//if a name wasn't entered add the wrap error class ?>">
					<?php if ( !empty($title_error) ) { echo $title_error; }//if a title wasn't entered display a message ?>
					<label for="the-title"><?php echo htmlentities( $this->get_str('FAQ_FORM_NAME') ); ?></label><br />
					<input type="text" id="the-title" tabindex="1" name="submit_faq_<?php echo $rnd_form_id;?>[the-title]" />
					<p class="easy_faqs_description"><?php echo htmlentities( $this->get_str('FAQ_FORM_NAME_DESCRIPTION') ); ?></p>
				</div>
				<div class="easy_faqs_field_wrap <?php if ( !empty($body_error) ) { echo "easy_faqs_field_wrap_error"; }//if a question wasn't entered add the wrap error class ?>">
					<?php if ( !empty($body_error) ) { echo $body_error; }//if a question wasn't entered display a message ?>
					<label for="the-body"><?php echo htmlentities( $this->get_str('FAQ_FORM_QUESTION') ); ?></label><br />
					<textarea id="the-body" tabindex="2" name="submit_faq_<?php echo $rnd_form_id;?>[the-body]" cols="50" rows="6"></textarea>
					<p class="easy_faqs_description"><?php echo htmlentities( $this->get_str('FAQ_FORM_QUESTION_DESCRIPTION') ); ?></p>
				</div>

				<?php
					if ( class_exists('ReallySimpleCaptcha') && get_option('easy_faqs_use_captcha',0) ) {
						?>
						<div class="easy_faqs_field_wrap <?php if ( !empty($captcha_error) ) { echo "easy_faqs_field_wrap_error"; } //if a captcha wasn't entered add the wrap error class ?>">
						<?php 
							if ( !empty($captcha_error) ) {
								echo $captcha_error;
							}
							$this->easy_faqs_outputCaptcha(); 
						?>
						</div>
						<?php
					} 
				?>
				
				<div class="easy_faqs_field_wrap"><input type="submit" value="<?php echo htmlentities( $this->get_str('FAQ_SUBMIT_QUESTION_BUTTON') ); ?>" tabindex="3" id="submit" name="submit" /></div>
				<input type="hidden" name="action" value="post_faq" />
				<?php wp_nonce_field( 'new-post' ); ?>
				<input type="hidden" name="submit_faq_form_id" value="<?php echo $rnd_form_id; ?>" />
				
			</form>
		</div>
		<!--// New Post Form -->
		<?php
	   
		$content = ob_get_contents();
		ob_end_clean(); 	   
		return $content;
	}

	function easy_faqs_send_notification_email( $submitted_question = array() )
	{
		//get e-mail address from post meta field
		$email_addresses = explode( ",", get_option( 'easy_faqs_submit_notification_address', get_bloginfo('admin_email') ) );
	 
		// these fields the only two which are not escaped with htmlentities
		$subject = $this->get_str('NEW_FAQ_SUBMISSION_SUBJECT') . get_bloginfo('name');
		$body = $this->get_str('NEW_FAQ_SUBMISSION_BODY');
		
		//see if option is set to include question in e-mail
		if ( get_option('easy_faqs_submit_notification_include_question') ) { //option is set, build message containing question		
			$body .= "\r\n Name: {$submitted_question['post']['post_title']} \r\n";
			$body .= " Question: {$submitted_question['post']['post_content']} \r\n";
		}
	 
		//use this to set the From address of the e-mail
		$headers = 'From: ' . get_bloginfo('name') . ' <'.get_bloginfo('admin_email').'>' . "\r\n";
		
		//loop through available e-mail addresses and fire off the e-mails!
		foreach ( $email_addresses as $email_address ) {
			if ( wp_mail($email_address, $subject, $body, $headers) ) {
				//mail sent!
			} else {
				//failure!
			}
		}
	}
		
	function easy_faqs_check_captcha() {
		$captcha = new ReallySimpleCaptcha();
		// This variable holds the CAPTCHA image prefix, which corresponds to the correct answer
		$captcha_prefix = $_POST['captcha_prefix'];
		// This variable holds the CAPTCHA response, entered by the user
		$captcha_code = $_POST['captcha_code'];
		// This variable will hold the result of the CAPTCHA validation. Set to 'false' until CAPTCHA validation passes
		$captcha_correct = false;
		// Validate the CAPTCHA response
		$captcha_check = $captcha->check( $captcha_prefix, $captcha_code );
		// Set to 'true' if validation passes, and 'false' if validation fails
		$captcha_correct = $captcha_check;
		// clean up the tmp directory
		$captcha->remove($captcha_prefix);
		$captcha->cleanup();
		
		return $captcha_correct;
	}	
		
	function easy_faqs_outputCaptcha() {
		// Instantiate the ReallySimpleCaptcha class, which will handle all of the heavy lifting
		$captcha = new ReallySimpleCaptcha();
		 
		// ReallySimpleCaptcha class option defaults.
		// Changing these values will hav no impact. For now, these are here merely for reference.
		// If you want to configure these options, see "Set Really Simple CAPTCHA Options", below
		$captcha_defaults = array(
			'chars' => 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789',
			'char_length' => '4',
			'img_size' => array( '72', '24' ),
			'fg' => array( '0', '0', '0' ),
			'bg' => array( '255', '255', '255' ),
			'font_size' => '16',
			'font_char_width' => '15',
			'img_type' => 'png',
			'base' => array( '6', '18'),
		);
		 
		/**************************************
		* All configurable options are below  *
		***************************************/
		 
		//Set Really Simple CAPTCHA Options
		$captcha->chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
		$captcha->char_length = '4';
		$captcha->img_size = array( '100', '50' );
		$captcha->fg = array( '0', '0', '0' );
		$captcha->bg = array( '255', '255', '255' );
		$captcha->font_size = '16';
		$captcha->font_char_width = '15';
		$captcha->img_type = 'png';
		$captcha->base = array( '6', '18' );
		 
		/********************************************************************
		* Nothing else to edit.  No configurable options below this point.  *
		*********************************************************************/
		 
		// Generate random word and image prefix
		$captcha_word = $captcha->generate_random_word();
		$captcha_prefix = mt_rand();
		// Generate CAPTCHA image
		$captcha_image_name = $captcha->generate_image($captcha_prefix, $captcha_word);
		// Define values for CAPTCHA fields
		$captcha_image_url =  get_bloginfo('wpurl') . '/wp-content/plugins/really-simple-captcha/tmp/';
		$captcha_image_src = $captcha_image_url . $captcha_image_name;
		$captcha_image_width = $captcha->img_size[0];
		$captcha_image_height = $captcha->img_size[1];
		$captcha_field_size = $captcha->char_length;
		// Output the CAPTCHA fields
		?>
		<div class="easy_faqs_field_wrap">
			<img src="<?php echo $captcha_image_src; ?>"
			 alt="captcha"
			 width="<?php echo $captcha_image_width; ?>"
			 height="<?php echo $captcha_image_height; ?>" /><br/>
			<label for="captcha_code"><?php echo get_option('easy_faqs_captcha_field_label','Captcha'); ?></label><br/>
			<input id="captcha_code" name="captcha_code"
			 size="<?php echo $captcha_field_size; ?>" type="text" />
			<p class="easy_faqs_description"><?php echo get_option('easy_faqs_captcha_field_description','Enter the value in the image above into this field.'); ?></p>
			<input id="captcha_prefix" name="captcha_prefix" type="hidden"
			 value="<?php echo $captcha_prefix; ?>" />
		</div>
		<?php
	}
	
	function add_accordion_classes($wrapper_classes, $atts = array())
	{	
		if ( empty($atts['style']) ) {
			$atts['style'] = '';
		}

		//RWG:	override style with accordion_style if set, for backwards 
		//		compatibility with very old widgets
		if( !empty($atts['accordion_style']) ) {
			$atts['style'] = $atts['accordion_style'];
		}
		
		if ( "accordion" == $atts['style']) {
			$wrapper_classes[] = 'easy-faqs-accordion';
		}
		else if ( "accordion-collapsed" == $atts['style'] ) {
			$wrapper_classes[] = 'easy-faqs-accordion-collapsed';
		}
		else {
			$wrapper_classes[] = 'easy-faqs-no-ac';
		}
		return $wrapper_classes;
	}
	
	function provide_config_data_to_admin()
	{
		// Localize the script with new data
		$translation_array = array(
			'themes' => EasyFAQs_Config::all_themes(),
			'is_pro' => true,
			'theme_group_labels' => array(
				'standard_themes' => __('Free Themes', 'easy-faqs'),
				'pro_themes' => __('Pro Themes', 'easy-faqs'),
			),
		);
		wp_localize_script( 'list-faqs-accordion-block-editor', 'easy_faqs_admin_list_faqs_accordion', $translation_array );
	}	

	function enqueue_scripts()
	{
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script(
			'easy-faqs',
			plugins_url('include/assets/js/easy-faqs-init.js', $this->base_file),
			array( 'jquery' )
		);
	}
	
	function add_category_classes($category_classes = array(), $atts)
	{
		//loop through categories, outputting a heading for the category and the list of faqs in that category
		if ( !empty($atts['categories_accordion']) ) {
			$category_classes[] = 'categories_accordion';
		}

		if ( !empty($atts['categories_accordion'])
			&& in_array( $atts['categories_accordion'], array('accordion-collapsed', 'accordion_collapsed', 'collapsed') )
		) {
			$category_classes[] = 'categories_accordion_collapsed';
		}
		return $category_classes;
	}
	
	// converts a DateTime string (e.g., a MySQL timestamp) into a friendly time string, e.g. "10 minutes ago"	
	// source: http://stackoverflow.com/a/18602474
	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);
		
		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;
		
		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}
		
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
	
	function get_str($key, $default_value = '')
	{
		// TODO: check pro strings file
		return apply_filters('easy_faqs_get_str', $key, $default_value);
	}
	
	function register_widgets()
	{
		register_widget( 'submitFAQsWidget' );		
	}
	
	function init_updater()
	{
		$this->GP_Plugin_Updater = $this->Factory->get('GP_Plugin_Updater');		
	}	

	function init_galahad()
	{
		$this->GP_Galahad = $this->Factory->get('GP_Galahad');
	}	
}