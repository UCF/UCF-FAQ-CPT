<?php
/**
 * Provides a shortcode for the UCF FAQ Search
 */
if ( ! class_exists( 'UCF_FAQ_Search_Shortcode' ) ) {
	class UCF_FAQ_Search_Shortcode {
		public static function shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'title'         => 'Search All FAQs',
				'title_classes' => 'h3 text-secondary',
				'placeholder'   => 'Search&hellip;'
			), $atts );

			return UCF_FAQ_Search_Common::display_faq_search( $atts );
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-search' ) ) {
		add_shortcode( 'ucf-faq-search', array( 'UCF_FAQ_Search_Shortcode', 'shortcode' ) );
	}
}
