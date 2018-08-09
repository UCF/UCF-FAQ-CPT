<?php
/**
 * Defines the faq-list shortcode
 **/
if ( ! class_exists( 'UCF_FAQ_List_Shortcode' ) ) {
	class UCF_FAQ_List_Shortcode {
		/**
		* Displays a list of FAQs
		* @author RJ Bruneel
		* @since 1.0.0
		* @param $atts array | An array of attributes
		* @return string | The html output of the shortcode.
		**/
		public static function shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'layout'        => 'classic',
				'title'         => 'FAQ'
			), $atts, 'ucf-faq-list' );

			$args = array(
				'post_type'      => 'faq',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC'
			);

			$posts = get_posts( $args );
			ob_start();

			$items = array();

			foreach( $posts as $post ) {
				$categories = wp_get_post_terms( $post->ID, 'category' );

				foreach( $categories as $cat ) {
					$items[$cat->name][] = $post;
				}
			}

			echo UCF_FAQ_List_Common::display_faqs( $items, $atts['layout'], $atts );
			return ob_get_clean();
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-list' ) ) {
		add_shortcode( 'ucf-faq-list', array( 'UCF_FAQ_List_Shortcode', 'shortcode' ) );
	}
}
?>
