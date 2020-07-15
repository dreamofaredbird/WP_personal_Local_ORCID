<?php

if ( !class_exists('GP_Galahad') ):

class GP_Galahad
{
	function __construct($options)
	{
		$this->parse_options($options);
		$this->add_hooks();
	}
	
	function parse_options($options)
	{
		$defaults = array(
			'plugin_name' => '',
			'license_key' => '',
			'patterns' => array(
				'testimonials_link',
				'testimonials_image',
				'meta_data_position',
				'ezt_(.*)',
				'testimonials_style',
				'easy_t_(.*)',
			)
		);

		$this->options = array_merge($defaults, $options);
	}
	
	function add_hooks()
	{
		add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );		
	}
	
	function admin_enqueue_scripts()
	{
		wp_register_script(
			'gp_galahad',
			plugins_url('assets/js/gp_galahad.js', __FILE__),
			array( 'jquery' ),
			false,
			true
		);
		wp_enqueue_script('gp_galahad');
		
		$css_url = plugins_url( 'assets/css/gp_galahad.css' , __FILE__ );
		wp_register_style('gp_galahad', $css_url);
		wp_enqueue_style('gp_galahad');			
	}
	
	function output_contact_page()
	{
		$site_data = $this->collect_site_details();		
		$current_user = wp_get_current_user();
		?>
		<h3><?php _e('Contact Support'); ?></h3>
		<?php if ( !empty($this->options['active_license']) ): ?>
		<p><?php _e('Would you like personalized support? Use the form below to submit a request!'); ?></p>
		<p><?php _e('If you aren\'t able to find a helpful answer in our Help Center, go ahead and send us a support request!'); ?></p>
		<p><?php _e('Please be as detailed as possible, including links to example pages with the issue present and what steps you\'ve taken so far.  If relevant, include any shortcodes or functions you are using.'); ?></p>
		<p><?php _e('Thanks!'); ?></p>
		<div class="gp_galahad gp_support_form_wrapper">
			<div class="gp_galahad_message"></div>
			
			<div data-gp-ajax-form="1" data-ajax-submit="1" class="gp-ajax-form" method="post" action="https://goldplugins.com/tickets/galahad/catch.php">
				<div style="display: none;">
					<textarea name="your-details" class="gp_galahad_site_details">
						<?php
							echo htmlentities(json_encode($site_data));
						?>
					</textarea>
					
				</div>
				<div class="form_field">
					<label><?php _e('Your Name (required)'); ?></label>
					<input type="text" aria-invalid="false" aria-required="true" size="40" value="<?php echo (!empty($current_user->display_name) ?  $current_user->display_name : ''); ?>" name="your_name">
				</div>
				<div class="form_field">
					<label><?php _e('Your Email (required)'); ?></label>
					<input type="email" aria-invalid="false" aria-required="true" size="40" value="<?php echo (!empty($current_user->user_email) ?  $current_user->user_email : ''); ?>" name="your_email"></span>
				</div>
				<div class="form_field">
					<label><?php _e('URL where the problem can be seen:'); ?></label>
					<input type="text" aria-invalid="false" aria-required="false" size="40" value="" name="example_url">
				</div>
				<div class="form_field">
					<label><?php _e('Your Message'); ?></label>
					<textarea aria-invalid="false" rows="10" cols="40" name="your_message"></textarea>
				</div>
				<div class="form_field">
					<input type="hidden" name="include_wp_info" value="0" />
					<label for="include_wp_info">
						<input type="checkbox" id="include_wp_info" name="include_wp_info" value="1" /><?php _e('Include information about my WordPress environment (server information, installed plugins, theme, and current version)'); ?>
					</label>
				</div>					
				<p><em><?php _e('Sending this data will allow the Gold Plugins can you help much more quickly. We strongly encourage you to include it.'); ?></em></p>
				<input type="hidden" name="registered_email" value="" />
				<input type="hidden" name="site_url" value="<?php echo htmlentities(site_url()); ?>" />
				<input type="hidden" name="challenge" value="<?php echo substr(md5(sha1('bananaphone' . $this->options['license_key'] )), 0, 10); ?>" />
				<div class="submit_wrapper">
					<input type="submit" class="button submit" value="<?php _e('Send'); ?>">
				</div>
			</div>
		</div>
		<?php else: ?>
			<p><?php _e('You must activate your license before submitting a support ticket.'); ?></p>
			<p><a href="<?php echo admin_url('admin.php?page=easy-faqs-license-information');?>" class="button"><?php _e('Activate Your License'); ?></a></p>
		<?php endif; 
	}
	
	function collect_site_details()
	{
		//load all plugins on site
		$all_plugins = get_plugins();

		//load current theme object
		$the_theme = wp_get_theme();

		//load current options that match our specified patterns
		$the_options = $this->load_all_options();

		//load wordpress area
		global $wp_version;
		
		$site_data = array(
			'plugins'	=> $all_plugins,
			'theme'		=> $the_theme,
			'wordpress'	=> $wp_version,
			'options'	=> $the_options
		);
		
		return $site_data;		
	}
	
	/**
	 * Builds an array of options and their values that are relevant to this plugin.
	 *
	 * @return array All WP options and their values that match one of the patterns
	 *				 specified in options['patterns'].
	 */
	private function load_all_options()
	{
		$my_options = array();
		$all_options = wp_load_alloptions();
				
		foreach ( $all_options as $name => $value ) {
			if ( $this->preg_match_array( $name, $this->options['patterns'] ) ) {
				$my_options[ $name ] = $value;
			}
		}
		
		return $my_options;
	}
	
	function preg_match_array( $candidate, $patterns )
	{
		foreach ($patterns as $pattern) {
			$p = sprintf('#%s#i', $pattern);
			if ( preg_match($p, $candidate, $matches) == 1 ) {
				return true;
			}
		}
		return false;
	}
}

endif; // class_exists