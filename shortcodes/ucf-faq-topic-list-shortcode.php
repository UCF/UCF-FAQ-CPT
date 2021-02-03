<?php
/**
 * Defines the faq-topic-list shortcode
 **/
if ( ! class_exists( 'UCF_FAQ_Topic_List_Shortcode' ) ) {
	class UCF_FAQ_Topic_List_Shortcode {
		/**
		* Displays a list of FAQ topics
		* @author RJ Bruneel
		* @since 1.0.0
		* @param $atts array | An array of attributes
		* @return string | The html output of the shortcode.
		**/
		public static function shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'layout'         => 'classic',
				'title'          => '',
				'topic_element'  => 'h2',
				'topic_class'    => 'h5',
			), $atts, 'ucf-faq-topic-list' );

			$taxonomy = 'topic';
			$terms = get_terms( $taxonomy );

			foreach ( $terms as $index=>$term ) {
				$sort_order = get_field( 'topic_sort_order', $taxonomy.'_'.$terms[$index]->term_id );
				$terms[$index]->sort_order = ( $sort_order ) ? (int)$sort_order : 0;
			}

			usort( $terms, 'UCF_FAQ_Common::sort_terms' );

			return UCF_FAQ_Topic_List_Common::display_faq_topics( $terms, $atts['layout'], $atts );
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-topic-list' ) ) {
		add_shortcode( 'ucf-faq-topic-list', array( 'UCF_FAQ_Topic_List_Shortcode', 'shortcode' ) );
	}
}
