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
				'layout'            => 'classic',
				'title'             => '',
				'category'          => '',
				'category_element'  => 'h2',
				'category_class'    => 'h4',
				'question_element'  => 'h3',
				'question_class'    => 'h6',
			), $atts, 'ucf-faq-list' );

			$category_id = null;

			if( $atts['category'] ) {
				$slug = get_term_by( 'slug', $atts['category'], 'category' );
				if( !empty( $slug ) ) {
					$category_id =  $slug->term_id;
				}
			}

			$args = array(
				'post_type'      => 'faq',
				'category'       => $category_id,
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC'
			);

			$posts = get_posts( $args );
			$items = array();

			foreach( $posts as $post ) {
				$categories = wp_get_post_terms( $post->ID, 'category' );

				foreach( $categories as $cat ) {
					$items[$cat->name][] = $post;
				}
			}

			return UCF_FAQ_List_Common::display_faqs( $items, $atts['layout'], $atts );
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-list' ) ) {
		add_shortcode( 'ucf-faq-list', array( 'UCF_FAQ_List_Shortcode', 'shortcode' ) );
	}
}

/**
 * Defines the faq-category-list shortcode
 **/
if ( ! class_exists( 'UCF_FAQ_Category_List_Shortcode' ) ) {
	class UCF_FAQ_Category_List_Shortcode {
		/**
		* Displays a list of FAQ categories
		* @author RJ Bruneel
		* @since 1.0.0
		* @param $atts array | An array of attributes
		* @return string | The html output of the shortcode.
		**/
		public static function shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'layout'            => 'classic',
				'title'             => '',
				'category_element'  => 'h2',
				'category_class'    => 'h4',
			), $atts, 'ucf-faq-list' );

			$categories = get_terms( 'category', array(
				'post_type' => array('faq')
			) );

			return UCF_FAQ_Category_List_Common::display_faq_categories( $categories, $atts['layout'], $atts );
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-category-list' ) ) {
		add_shortcode( 'ucf-faq-category-list', array( 'UCF_FAQ_Category_List_Shortcode', 'shortcode' ) );
	}
}
?>
