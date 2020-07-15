<?php
/**
 * Cached functions and flags.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Cache
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Cache'))
{
	/**
	 * Class used to implement cache functionality.
	 *
	 * @since 2.0.0
	 * 
	 * @uses Noakes_Menu_Manager_Wrapper
	 */
	final class Noakes_Menu_Manager_Cache extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Get a default cached item based on the provided name.
		 * 
		 * @since 2.0.0
		 * 
		 * @access protected
		 * @param  string $name Name of the cached item to return.
		 * @return string       Default cached item if it exists, otherwise an empty string.
		 */
		protected function _default($name)
		{
			switch ($name)
			{
				/* @var string Path to the plugin assets folder. */
				case 'assets_url':
				
					$folder = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? 'debug' : 'release';

					return trailingslashit(plugins_url('/' . $folder . '/', $this->_base->_plugin));
					
				/* @var array Before/after options for nav menus. */
				case 'before_after_options':
				
					$tag = __('%s Tag', 'noakes-menu-manager');

					return array
					(
						'' => __('None', 'noakes-menu-manager'),

						'em' => sprintf
						(
							$tag,
							'EM'
						),

						'span' => sprintf
						(
							$tag,
							'SPAN'
						),

						'strong' => sprintf
						(
							$tag,
							'STRONG'
						)
					);
					
				/* @var array Container options for nav menus. */
				case 'container_options':
				
					$tag = __('%s Tag', 'noakes-menu-manager');

					return array
					(
						'' => __('None', 'noakes-menu-manager'),

						'div' => sprintf
						(
							$tag,
							'DIV'
						),

						'nav' => sprintf
						(
							$tag,
							'NAV'
						)
					);
					
				/* @var array Depth options for nav menus. */
				case 'depth_options':
				
					return array
					(
						__('No Limit', 'noakes-menu-manager'),
						1,
						2,
						3,
						4,
						5,
						6,
						7,
						8,
						9
					);
					
				/* @var string Abbreviation output for Document Object Model. */
				case 'dom':

					return '<abbr title="' . esc_attr__('Document Object Model', 'noakes-menu-manager') . '">' . __('DOM', 'noakes-menu-manager') . '</abbr>';
					
				/* @var string Output for DOM ID. */
				case 'dom_id':
				
					return sprintf
					(
						__('%s ID', 'noakes-menu-manager'),
						$this->dom
					);
					
				/* @var boolean True if a legacy version of the Nav Menu Collapse plugin is active. */
				case 'has_legacy_nmc':
				
					return (Noakes_Menu_Manager_Utilities::is_plugin_active('nav-menu-collapse/nav-menu-collapse.php') && version_compare(NMC_VERSION, '1.3', '<'));
					
				/* @var array Item spacing options for nav menus. */
				case 'item_spacing_options':
				
					return array
					(
						'' => __('Preserve', 'noakes-menu-manager'),
						'discard' => __('Discard', 'noakes-menu-manager')
					);

				/* @var array Asset file names pulled from the manifest JSON. */
				case 'manifest':

					ob_start();

					include(dirname(__FILE__) . '/../../manifest.json');

					return json_decode(ob_get_clean(), true);
					
				/* @var array General details about the plugin. */
				case 'plugin_data':
				
					return get_plugin_data($this->_base->_plugin);

				/* @var array Menus registered outside of the Nav Menu Manager. */
				case 'registered_menus':

					return array();

				/* @var WP_Screen Current screen object if it exists. */
				case 'screen':

					return (function_exists('get_current_screen')) ? get_current_screen() : '';
			}

			return parent::_default($name);
		}

		/**
		 * Obtain a path to an asset.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  string $path      Path to the asset folder.
		 * @param  string $file_name File name for the asset.
		 * @return string            Full path to the requested asset.
		 */
		public function asset_path($path, $file_name)
		{
			$manifest = $this->manifest;

			if (isset($manifest[$file_name]))
			{
				$file_name = $manifest[$file_name];
			}

			return trailingslashit($this->assets_url . $path) . $file_name;
		}
	}
}
