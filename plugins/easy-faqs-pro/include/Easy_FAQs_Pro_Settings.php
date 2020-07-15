<?php
	class Easy_FAQs_Pro_Settings
	{
		function __construct( $factory )
		{
			add_action( 'admin_init', array( $this, 'create_settings' ) );
			$this->options = get_option( 'easy_faqs_options' );
			$this->Factory = $factory;
			$this->shed = $this->Factory->get( 'GP_BikeShed' );
		}
		
		function create_settings()
		{
			$this->add_license_settings();			
		}
		
		function add_license_settings()
		{
			register_setting( 'easy-faqs-pro-license-group', 'easy_faqs_pro_registered_key', array($this, 'handle_check_software_license') );
		}
		
		function output_pro_settings_fields()
		{		
			$this->settings_page_top();
			$options = get_option('easy_faqs_options');
			$license_key = $this->get_license_key();			
			?>							
				<h3>Easy FAQs Pro Settings</h3>			
				<p>Pro settings page.</p>
				<?php if ( $this->is_activated() ): ?>		
				<?php endif; ?>			
			<?php 
			$this->settings_page_bottom();
		}
		
		/*
		 * Verifies the provided pro credentials before they are saved. Intended to
		 * be called from the sanitization callback of the registration options.
		 *
		 * @param string $new_api_key The API key that's just been entered into the 
		 * 								settings page. Passed by WordPress to the 
		 * 								sanitization callback. Optional.
		 */
		function handle_check_software_license($new_api_key = '')
		{
			// abort if required field is missing
			$lm_action = strtolower( filter_input(INPUT_POST, '_gp_license_manager_action') );
			if ( empty($new_api_key) || empty($lm_action) ) {
				return $new_api_key;
			}
			
			$updater = $this->Factory->get('GP_Plugin_Updater');

			if ( $lm_action == 'activate' ) {
				// attempt to activate the new key with the home server
				$result = $updater->activate_api_key($new_api_key);
			}
			else if ( $lm_action == 'deactivate' ) {
				// attempt to deactivate the key with the home server
				$result = $updater->deactivate_api_key($new_api_key);	
			}
			
			$options = get_option('easy_faqs_options');
			$options['api_key'] = $new_api_key;
			update_option('easy_faqs_options', $options);
			
			return $new_api_key;
		}
		
		function render_license_information_page()
		{	
			// setup the Sajak tabs for this screen
			$this->tabs = new GP_Sajak( array(
				'header_label' => 'Easy FAQs Pro - License',
				'settings_field_key' => 'easy-faqs-pro-license-group', // can be an array
			) );		
			
			$this->tabs->add_tab(
				'easy_testimonials_pro_license', // section id, used in url fragment
				'Pro License', // section label
				array( $this, 'output_registration_options' ), // display callback
				array( // tab options
					'icon' => 'key',
					'show_save_button' => false
				)
			);
			
			// render the page
			//$this->settings_page_top();	
			$this->tabs->display();
			//$this->settings_page_bottom();
		}
		
		function output_registration_options()
		{		
			$this->settings_page_top();
			$options = get_option('easy_faqs_options');
			$license_key = $this->get_license_key();			
			?>							
				<h3>Easy FAQs Pro License</h3>			
				<p>With an active API key, you will be able to receive automatic software updates and contact support directly.</p>
				<?php if ( $this->is_activated() ): ?>		
				<div class="has_active_license" style="color:green;margin-bottom:20px;">
					<?php $expiration = $this->license_expiration_date();
					if ( $expiration == 'lifetime' ):
					?>
					<p><strong>&#x2713; Your API Key has been activated.</p>
					<?php else: ?>				
					<p><strong>&#x2713; Your API Key is active through <?php echo $this->license_expiration_date(); ?></strong>.</p>
					<?php endif; ?>
				</div>
				<input type="hidden" name="_gp_license_manager_action" value="deactivate" />
				<input type="hidden" name="easy_faqs_pro_registered_key" value="<?php echo htmlentities( $license_key ); ?>" />
				<button class="button">Deactivate</button>
				<?php else: ?>			
				<p>You can find your API key in the email you received upon purchase, or in the <a href="https://goldplugins.com/members/?utm_source=easy_testimonials_pro_plugin&utm_campaign=get_api_key_from_member_portal">Gold Plugins member portal</a>.</p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="easy_faqs_pro_registered_key">API Key</label></th>
						<td><input type="text" class="widefat" name="easy_faqs_pro_registered_key" id="easy_faqs_pro_registered_key" value="<?php echo htmlentities( $license_key ); ?>" autocomplete="off" />
						</td>
					</tr>
				</table>			
				<input type="hidden" name="_gp_license_manager_action" value="activate" />
				<button class="button">Activate</button>
				<?php endif; ?>			
			<?php 
			$this->settings_page_bottom();
		}
		
		function get_license_key()
		{
			$options = get_option('easy_faqs_options');
			$license_key = !empty($options) && !empty($options['api_key'])
						   ? trim($options['api_key'])
						   : '';
			return $license_key;
		}
		
		function is_activated()
		{
			$key = $this->get_license_key();
			if ( empty($key) ) {
				return false;
			}
			
			$updater = $this->Factory->get('GP_Plugin_Updater');
			return $updater->has_active_license();
		}
		
		function license_expiration_date()
		{
			$updater = $this->Factory->get('GP_Plugin_Updater');
			$expiration = $updater->get_license_expiration();
			
			// handle lifetime licenses
			if ('lifetime' == $expiration) {
				return 'lifetime';
			}
			
			// convert to friendly date
			return ( !empty($expiration) )
				   ? date_i18n( get_option('date_format', 'M d, Y'), $expiration)
				   : '';
		}

		function submission_form_options()
		{
			$this->settings_page_top();
			$this->question_form_tabs();
			$this->settings_page_bottom();
		}
		
		function question_form_tabs()
		{
			//add upgrade button if free version
			$extra_buttons = array();
			if(!isValidFAQKey()){
				$extra_buttons = array(
					array(
						'class' => 'btn-purple',
						'label' => 'Upgrade To Pro',
						'url' => 'https://goldplugins.com/our-plugins/easy-faqs-details/upgrade-to-easy-faqs-pro/'
					)
				);
			}
			
			$tabs = new GP_Sajak( array(
				'header_label' => 'Question Form Settings',
				'settings_field_key' => 'easy-faqs-submission-form-options-group', // can be an array	
				'extra_buttons_header' => $extra_buttons,
				'extra_buttons_footer' => $extra_buttons
			) );
			
			$tabs->add_tab(
				'labels_and_descriptions', // section id, used in url fragment
				'Field Labels &amp; Descriptions', // section label
				array($this, 'output_labels_and_descriptions'), // display callback
				array(
					'icon' => 'gear' // icons here: http://fontawesome.io/icons/
				)
			);
			
			$tabs->add_tab(
				'submission_options', // section id, used in url fragment
				'Submission Options', // section label
				array($this, 'output_submission_options'), // display callback
				array(
					'icon' => 'gear' // icons here: http://fontawesome.io/icons/
				)
			);
			
			$tabs->add_tab(
				'spam_prevention', // section id, used in url fragment
				'Spam Prevention', // section label
				array($this, 'output_spam_prevention_options'), // display callback
				array(
					'icon' => 'gear' // icons here: http://fontawesome.io/icons/
				)
			);
			
			$tabs->add_tab(
				'error_messages', // section id, used in url fragment
				'Error Messages', // section label
				array($this, 'output_error_messages'), // display callback
				array(
					'icon' => 'gear' // icons here: http://fontawesome.io/icons/
				)
			);
			
			$tabs->display();
		}
		
		function import_export_page()
		{
			$this->settings_page_top(false);
			$this->import_export_tabs();
			$this->settings_page_bottom();
		}

		function import_export_tabs()
		{
			//add upgrade button if free version
			$extra_buttons = array();
			if(!isValidFAQKey()){
				$extra_buttons = array(
					array(
						'class' => 'btn-purple',
						'label' => 'Upgrade To Pro',
						'url' => 'https://goldplugins.com/our-plugins/easy-faqs-details/upgrade-to-easy-faqs-pro/'
					)
				);
			}
			
			$tabs = new GP_Sajak( array(
				'header_label' => 'Import &amp; Export',
				'settings_field_key' => 'easy-import-export-group', // can be an array
				'show_save_button' => false, // hide save buttons for all panels 	
				'extra_buttons_header' => $extra_buttons,
				'extra_buttons_footer' => $extra_buttons
			) );
			
			$tabs->add_tab(
				'faqs_importer', // section id, used in url fragment
				'Import FAQs', // section label
				array($this, 'output_faqs_importer'), // display callback
				array(
					'icon' => 'gear' // icons here: http://fontawesome.io/icons/
				)
			);
			
			$tabs->add_tab(
				'faqs_exporter', // section id, used in url fragment
				'Export FAQs', // section label
				array($this, 'output_faqs_exporter'), // display callback
				array(
					'icon' => 'gear' // icons here: http://fontawesome.io/icons/
				)
			);
			
			$tabs->display();
		}

		function output_faqs_importer()
		{
			if( !isValidFAQKey() ): // not pro ?>
				<h3>Import FAQs</h3>	
				<p class="easy_faqs_not_registered"><strong>These features require Easy FAQs Pro.</strong>&nbsp;&nbsp;&nbsp;<a class="button" target="blank" href="https://goldplugins.com/our-plugins/easy-faqs-details/upgrade-to-easy-faqs-pro/?utm_campaign=upgrade&utm_source=plugin&utm_banner=import_upgrade">Upgrade Now</a></p>		
			<?php else: //is pro ?>
				<form method="POST" action="" enctype="multipart/form-data">
					<h3>FAQs Importer</h3>	
					<?php 
						//CSV Importer
						$importer = new FAQsPlugin_Importer($this);
						$importer->csv_importer(); // outputs form and handles input. TODO: break into 2 functions (one to show form, one to process input)
					?>
				</form>
			<?php endif;
		}
		
		function output_faqs_exporter()
		{
			if( !isValidFAQKey() ): // not pro ?>
				<h3>Export FAQs</h3>		
				<p class="easy_faqs_not_registered"><strong>These features require Easy FAQs Pro.</strong>&nbsp;&nbsp;&nbsp;<a class="button" target="blank" href="https://goldplugins.com/our-plugins/easy-faqs-details/upgrade-to-easy-faqs-pro/?utm_campaign=upgrade&utm_source=plugin&utm_banner=export_upgrade">Upgrade Now</a></p>		
			<?php else: //is pro ?>
				<form method="POST" action="" enctype="multipart/form-data">
					<h3>FAQs Exporter</h3>	
					<?php 
						//CSV Exporter
						FAQsPlugin_Exporter::output_form();
					?>
				</form>
			<?php endif;
		}

		function recent_searches_page()
		{
			$this->settings_page_top(false);		
			$this->recent_searches_page_tabs();		
			$this->settings_page_bottom();
		}
		
		function recent_searches_page_tabs()
		{
			//add upgrade button if free version
			$extra_buttons = array();
			if(!isValidFAQKey()){
				$extra_buttons = array(
					array(
						'class' => 'btn-purple',
						'label' => 'Upgrade To Pro',
						'url' => 'https://goldplugins.com/our-plugins/easy-faqs-details/upgrade-to-easy-faqs-pro/'
					)
				);
			}
			
			$tabs = new GP_Sajak( array(
				'header_label' => 'Recent Searches',
				'settings_field_key' => 'easy-faqs-recent-searches-group', // can be an array
				'show_save_button' => false, // hide save buttons for all panels 	
				'extra_buttons_header' => $extra_buttons,
				'extra_buttons_footer' => $extra_buttons	
			) );
			
			$tabs->add_tab(
				'recent_searches', // section id, used in url fragment
				'Recent Searches', // section label
				array($this, 'output_recent_searches'), // display callback
				array(
					'icon' => 'gear' // icons here: http://fontawesome.io/icons/
				)
			);
			
			$tabs->display();
		}
		
		function output_recent_searches(){		
			$categories = get_terms( 'easy-faq-category', 'orderby=title&hide_empty=0' );
			?>
			<div id="easy_faqs_recent_searches">
				<h3>Recent Searches</h3>
				<?php if (isValidFAQKey()): ?>
				<?php
					global $wpdb;		
					$table_name = $wpdb->prefix . 'easy_faqs_search_log';
					$limit = 25;
					$page = (isset($_GET['results_page']) && intval($_GET['results_page']) > 0) ? intval($_GET['results_page']) : 1;
					$offset = $page > 1 ? ( ($page - 1) * $limit ) : 0;
					$sql_template = 'SELECT * from %s ORDER BY time DESC LIMIT %d,%d';
					$sql = sprintf($sql_template, $table_name, $offset, $limit);				
					$recent_searches = $wpdb->get_results($sql);
					
					
					// get the total count				
					$count_sql_template = 'SELECT count(id) from %s';
					$count_sql = sprintf($count_sql_template, $table_name);
					$record_count = $wpdb->get_var($count_sql);
					
					if (is_array($recent_searches)) {
						echo '<table id="easy_faqs_recent_searches" class="wp-list-table widefat fixed pages">';
							echo '<thead>';
								echo '<tr>';
									echo '<th>Time</th>';
									echo '<th>Query</th>';
									echo '<th>Results</th>';
									echo '<th>Visitor IP</th>';
									//echo '<th>Location</th>';
								echo '</tr>';
							echo '</thead>';
							echo '<tbody>';
								foreach($recent_searches as $i => $search)
								{
									$row_class = ($i % 2 == 0) ? 'alternate' : '';
								echo '<tr class="'.$row_class.'">';
									$friendly_time = date('Y-m-d H:i:s', strtotime($search->time));
									$friendly_time = $this->time_elapsed_string($friendly_time);
									printf ('<td>%s</td>', htmlentities($friendly_time));
									printf ('<td>%s</td>', htmlentities($search->query));
									printf ('<td>%s</td>', htmlentities($search->result_count));
									printf ('<td>%s</td>', htmlentities($search->ip_address));
									//printf ('<td>%s</td>', htmlentities($search->friendly_location));
								echo '</tr>';				
								}
							echo '</tbody>';
						echo '</table>';
						
						if ($record_count > $limit)
						{
							$link_template = '<li><a href="%s">%s</a></li>';
							$href_template = admin_url('admin.php?page=easy-faqs-recent-searches&results_page=') . '%d';
							$last_page = ceil($record_count / $limit);
							echo '<div class="tablenav bottom">';
							echo '<div class="tablenav-pages">';
							echo '<ul class="search_result_pages">';

							// first page link
							$href = sprintf($href_template, 1);
							printf($link_template, $href, '&laquo;');

							// output page links
							for($i = 1; $i <= $last_page; $i++)
							{
								$href = sprintf($href_template, ($i));
								printf($link_template, $href, $i);
							}						
							
							// last page link
							$href = sprintf($href_template, $last_page);
							printf($link_template, $href, '&raquo;');						
							
							echo '</ul>';
							echo '</div>'; // end tablenav-pages
							echo '</div>'; // end tablenav
						}
					}		
				?>	
			<?php else: ?>
				<p class="easy_faqs_not_registered"><strong>This feature requires Easy FAQs Pro.</strong>&nbsp;&nbsp;&nbsp;<a class="button" target="blank" href="https://goldplugins.com/our-plugins/easy-faqs-details/upgrade-to-easy-faqs-pro/?utm_campaign=upgrade_search&utm_source=plugin&utm_banner=recent_searches">Upgrade Now</a></p>
			<?php endif; ?>
				</div><!-- end #easy_faqs_recent_searches -->
			<?php
		}
		
		function output_labels_and_descriptions(){
			?>
			<h3>Field Labels &amp; Descriptions</h3>
				
			<p>Use the below options to control the look and feel of the question submission form.</p>
		
			<fieldset>
				<legend>Name Field</legend>			
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="easy_faqs_name_label">Label</label></th>
						<td><input type="text" name="easy_faqs_name_label" id="easy_faqs_name_label" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option( 'easy_faqs_name_label', $this->get_str('FAQ_FORM_NAME') ); ?>" />
						<p class="description">This is the label of the first field in the form, which defaults to "Your Name".</p>
						</td>
					</tr>
				</table>
				
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="easy_faqs_name_description">Description</label></th>
						<td><textarea name="easy_faqs_name_description" id="easy_faqs_name_description" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?>><?php echo get_option('easy_faqs_name_description', $this->get_str('FAQ_FORM_NAME_DESCRIPTION') ); ?></textarea>
						<p class="description">This is the description below the first field in the form, which defaults to "Please enter your name".</p>
						</td>
					</tr>
				</table>
			</fieldset>
						
			<fieldset>
				<legend>Question Field</legend>			
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="easy_faqs_question_label">Label</label></th>
						<td><input type="text" name="easy_faqs_question_label" id="easy_faqs_question_label" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_faqs_question_label', $this->get_str('FAQ_FORM_QUESTION') ); ?>" />
						<p class="description">This is the label of the second field in the form, which defaults to "Your Question".</p>
						</td>
					</tr>
				</table>
							
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="easy_faqs_question_description">Description</label></th>
						<td><textarea name="easy_faqs_question_description" id="easy_faqs_question_description" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?>><?php echo get_option('easy_faqs_question_description', $this->get_str('FAQ_FORM_QUESTION_DESCRIPTION') ); ?></textarea>
						<p class="description">This is the description below the second field in the form, which defaults to "Please enter your Question".</p>
						</td>
					</tr>
				</table>
			</fieldset>		
						
			<fieldset>
				<legend>Submit Button</legend>	
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="easy_faqs_submit_button_label">Submit Button Label</label></th>
						<td><input type="text" name="easy_faqs_submit_button_label" id="easy_faqs_submit_button_label" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_faqs_submit_button_label', $this->get_str('FAQ_SUBMIT_QUESTION_BUTTON') ); ?>" />
						<p class="description">This is the label of the submit button at the bottom of the form.</p>
						</td>
					</tr>
				</table>
			</fieldset>
			<?php
		}
		
		function output_submission_options(){
			?>
			<h3>Submission Options</h3>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_faqs_submit_success_message">Submission Success Message</label></th>
					<td><textarea name="easy_faqs_submit_success_message" id="easy_faqs_submit_success_message" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?>><?php echo get_option('easy_faqs_submit_success_message', $this->get_str('FAQ_SUBMIT_SUCCESS') ); ?></textarea>
					<p class="description">This is the text that appears after a successful submission.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_faqs_submit_success_redirect_url">Submission Success Redirect URL</label></th>
					<td><input type="text" name="easy_faqs_submit_success_redirect_url" id="easy_faqs_submit_success_redirect_url" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_faqs_submit_success_redirect_url', ''); ?>"/>
					<p class="description">If you want the user to be taken to a specific URL on your site after asking their Question, enter it into this field.  If the field is empty, they will stay on the same page and see the Success Message, instead.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_faqs_submit_notification_address">Submission Success Notification E-Mail Address</label></th>
					<td><input type="text" name="easy_faqs_submit_notification_address" id="easy_faqs_submit_notification_address" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_faqs_submit_notification_address'); ?>" />
					<p class="description">If set, we will attempt to send an e-mail notification to this address upon a successful submission.  If not set, submission notifications will be sent to the site's Admin E-mail address.  You can include multiple, comma-separated e-mail addresses here.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_faqs_submit_notification_include_question">Include Question In Notification E-mail</label></th>
					<td><input type="checkbox" name="easy_faqs_submit_notification_include_question" id="easy_faqs_submit_notification_include_question" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?> value="1" <?php if(get_option('easy_faqs_submit_notification_include_question')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, the notification e-mail will include the Question asked.</p>
					</td>
				</tr>
			</table>
			<?php
		}
		
		function output_spam_prevention_options(){
			?>
			<h3>Spam Prevention</h3>
			<table class="form-table">
			<?php
					// Submission Form CAPTCHA (checkbox)
					$desc = 'If checked, and a compatible plugin is installed (such as <a href="https://wordpress.org/plugins/really-simple-captcha/" target="_blank">Really Simple Captcha</a>) then we will output a Captcha on the Submission Form.  This is useful if you are having SPAM problems.';
					if(!class_exists('ReallySimpleCaptcha')) {
						$desc .= '</p><p class="alert"><strong>ALERT: Really Simple Captcha is NOT active.  Captcha feature will not function.</strong>';
					}
					$checked = (get_option('easy_faqs_use_captcha') == '1');
					$this->shed->checkbox( array('name' => 'easy_faqs_use_captcha', 'label' =>'Enable Really Simple Captcha', 'value' => 1, 'checked' => $checked, 'description' => $desc, 'inline_label' => 'Show a CAPTCHA on form submissions to prevent spam', 'disabled' => false) );
			?>
			</table>
			<?php
		}
		
		function output_error_messages(){
			?>
			<h3>Error Messages</h3>
					
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_faqs_name_error_message">Name Error Message</label></th>
					<td><textarea name="easy_faqs_name_error_message" id="easy_faqs_name_error_message" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?>><?php echo get_option('easy_faqs_name_error_message',  $this->get_str('FAQ_FORM_ERROR_NAME') ); ?></textarea>
					<p class="description">This is the message shown when this field isn't filled out correctly.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_faqs_question_error_message">Question Error Message</label></th>
					<td><textarea name="easy_faqs_question_error_message" id="easy_faqs_question_error_message" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?>><?php echo get_option('easy_faqs_question_error_message',  $this->get_str('FAQ_FORM_ERROR_QUESTION') ); ?></textarea>
					<p class="description">This is the message shown when this field isn't filled out correctly.</p>
					</td>
				</tr>
			</table>
					
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_faqs_captcha_error_message">Captcha Error Message</label></th>
					<td><textarea name="easy_faqs_captcha_error_message" id="easy_faqs_captcha_error_message" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?>><?php echo get_option('easy_faqs_captcha_error_message',  $this->get_str('FAQ_FORM_ERROR_CAPTCHA') ); ?></textarea>
					<p class="description">This is the message shown when this field isn't filled out correctly.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_faqs_general_error_message">General Error Message</label></th>
					<td><textarea name="easy_faqs_general_error_message" id="easy_faqs_general_error_message" <?php if(!isValidFAQKey()): ?>disabled="disabled"<?php endif; ?>><?php echo get_option('easy_faqs_general_error_message',  $this->get_str('FAQ_FORM_ERROR_SUBMISSION') ); ?></textarea>
					<p class="description">This is the message shown when this field isn't filled out correctly.</p>
					</td>
				</tr>
			</table>
			<?php
		}
		
		//output top of settings page
		function settings_page_top($show_tabs = true)
		{
			global $pagenow;
			$title = 'Easy FAQs ' . __('Settings', 'easy-faqs');
			if( isset($_GET['settings-updated']) 
				&& $_GET['settings-updated'] == 'true' 
				&& $_GET['page'] != 'easy-faqs-license-settings' 
				&& strpos($_GET['page'], 'license-settings') !== false
			) {
				$this->messages[] = "Settings updated.";
			}
		?>
			<div class="wrapxx xxeasy_faqs_admin_wrap">
		<?php
			if( !empty($this->messages) ){
				foreach($this->messages as $message){
					echo '<div id="messages" class="gp_updated fade">';
					echo '<p>' . $message . '</p>';
					echo '</div>';
				}
				
				$this->messages = array();
			}
		?>
			<div id="icon-options-general" class="icon32"></div>
			<?php
		}
		
		//builds the bottom of the settings page
		//includes the signup form, if not pro
		function settings_page_bottom()
		{
			?>
			</div>
			<?php
		}
		
		// converts a DateTime string (e.g., a MySQL timestamp) into a friendly time string, e.g. "10 minutes ago"	
		// source: http://stackoverflow.com/a/18602474
		function time_elapsed_string($datetime, $full = false)
		{
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
		
	}