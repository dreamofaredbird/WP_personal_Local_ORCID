<?php
/**
 * Handles the customizer CSS overrides from TEC
 *
 * @since   5.0.1
 * @package Tribe\Events\Pro\Service_Providers
 */

namespace Tribe\Events\Pro\Service_Providers;

use Tribe__Customizer;
use Tribe__Utils__Color;

class Customizer extends \tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 *
	 * @since 5.0.1
	 */
	public function register() {

		if ( ! tribe_events_views_v2_is_enabled() ) {
			return;
		}

		add_filter( 'tribe_customizer_css_template', [ $this, 'filter_accent_color_css' ], 100, 1 );
	}

	/**
	 * Handle accent color customizations for Pro.
	 *
	 * @since 5.0.1
	 *
	 * @param string $template The original CSS template.
	 *
	 * @return string $template The resulting CSS template.
	 */
	public function filter_accent_color_css( $template ) {
		$customizer              = Tribe__Customizer::instance();
		$global_elements_section = tribe( 'tec.customizer.global-elements' );
		$settings                = $customizer->get_option( [ $global_elements_section->ID ] );

		if  ( $customizer->has_option( $global_elements_section->ID, 'accent_color' ) ) {
			$accent_color     = new Tribe__Utils__Color( $settings['accent_color'] );
			$accent_color_rgb = $accent_color::hexToRgb( $settings['accent_color'] );
			$accent_css_rgb   = $accent_color_rgb['R'] . ',' . $accent_color_rgb['G'] . ',' . $accent_color_rgb['B'];

			// Pro styles.
			$template .= '
				.tribe-events-pro .tribe-events-pro-week-grid__header-column--current .tribe-events-pro-week-grid__header-column-daynum,
				.tribe-events-pro .tribe-events-pro-week-grid__header-column--current .tribe-events-pro-week-grid__header-column-daynum-link {
					color: <%= global_elements.accent_color %>;
				}
			';

			$template .= '
				.tribe-events-pro.tribe-events-view--week .datepicker .day.current::before {
					background: <%= global_elements.accent_color %>;
				}
			';

			$template .= '
				.tribe-events-pro.tribe-events-view--week .datepicker .active .day,
				.tribe-events-pro.tribe-events-view--week .datepicker .active .day:hover {
					background: rgba( ' . $accent_css_rgb . ', 0.07);
				}
			';

			$template .= '
				.tribe-events-pro .tribe-events-pro-week-grid__event-link-inner {
					background: rgba( ' . $accent_css_rgb . ', 0.1);
				}
			';

			$template .= '
				.tribe-events-pro .tribe-events-pro-week-grid__event-link:hover .tribe-events-pro-week-grid__event-link-inner,
				.tribe-events-pro .tribe-events-pro-week-grid__event-link:focus .tribe-events-pro-week-grid__event-link-inner {
					background: rgba( ' . $accent_css_rgb . ', 0.2);
				}
			';

			$template .= '
				.tribe-events-pro .tribe-events-pro-week-grid__multiday-event-bar-inner {
					background-color: rgba( ' . $accent_css_rgb . ', 0.24);
				}
			';

			$template .= '
				.tribe-events-pro .tribe-events-pro-week-grid__multiday-event-bar-inner--hover,
				.tribe-events-pro .tribe-events-pro-week-grid__multiday-event-bar-inner:hover,
				.tribe-events-pro .tribe-events-pro-week-grid__multiday-event-bar-inner:focus {
					background-color: rgba( ' . $accent_css_rgb . ', 0.54);
				}
			';

			$template .= '
				.tribe-events-pro .tribe-events-pro-week-day-selector__events-icon {
					background-color: <%= global_elements.accent_color %>;
				}
			';

			$template .= '
				.tribe-events-pro .tribe-events-pro-map__event-card-wrapper--active .tribe-events-pro-map__event-card-button,
				.tribe-events-pro .tribe-events-pro-week-day-selector__day--active {
					border-color: <%= global_elements.accent_color %>;
				}
			';
		}

		return $template;
	}
	/**
	 * Handle text color customizations for Pro.
	 *
	 * @since 5.0.1
	 *
	 * @deprecated  5.0.2
	 *
	 * @param string $template The original CSS template.
	 *
	 * @return string $template The resulting CSS template.
	 */
	public function filter_text_color_css( $template ) {
		_deprecated_function( __METHOD__, 'TBD' );

		$customizer   = Tribe__Customizer::instance();
		$text_section = tribe( 'tec.customizer.text' );
		$settings     = $customizer->get_option( [ $text_section->ID ] );

		if ( $customizer->has_option( $text_section->ID, 'primary_text_color' ) ) {
			$primary_text_color     = new Tribe__Utils__Color( $settings['primary_text_color'] );
			$primary_text_color_rgb = $primary_text_color::hexToRgb( $settings['primary_text_color'] );
			$primary_rgb            = $primary_text_color_rgb['R'] . ',' . $primary_text_color_rgb['G'] . ',' . $primary_text_color_rgb['B'];

			// PRO Styles.
			$template .= '
				.tribe-events-pro .tribe-events-pro-week-grid__events-time-tag,
				.tribe-events-pro .tribe-events-pro-week-grid__event-tooltip-datetime,
				.tribe-events-pro .tribe-events-pro-week-grid__header-column--current .tribe-events-pro-week-grid__header-column-weekday {
					color: <%= text.primary_text_color %>;
				}
			';

			$template .= '
				.tribe-events-pro.tribe-events-view--week .datepicker .day.disabled {
					color: <%= text.primary_text_color %>;
				}
			';

			$template .= '
				.tribe-events-pro.tribe-events-view--week .datepicker .day.past {
					color: rgba( ' . $primary_rgb . ', 0.62 );
				}
			';
		}

		if ( $customizer->has_option( $text_section->ID, 'secondary_text_color' ) ) {
			// PRO Styles.
			$template .= '
				.tribe-events .tribe-events-calendar-month__calendar-event-datetime,
				.tribe-events-pro .tribe-events-pro-photo__event-date-tag-month,
				.tribe-events-pro .tribe-events-pro-week-grid__event-datetime,
				.tribe-events-pro .tribe-events-pro-map__event-date-tag-month,
				.tribe-common--breakpoint-medium.tribe-events-pro .tribe-events-pro-map__event-distance {
					color: <%= text.secondary_text_color %>;
				}
			';
		}

		return $template;
	}
}
