<?php

namespace Molongui\Fw\Includes;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Molongui\Fw\Includes\i18n' ) )
{
	class i18n
	{
		private $domain;
		public function load_plugin_textdomain()
		{
			load_plugin_textdomain(
				'molongui-common-framework',
				false,
				dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/i18n/'
			);
			load_plugin_textdomain(
				$this->domain,
				false,
				dirname( dirname( dirname( plugin_basename( __FILE__ ) ) ) ) . '/i18n/'
			);
		}
		public function set_domain( $domain )
		{
			$this->domain = $domain;
		}
	}
}
