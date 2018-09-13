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
				'layout'             => 'classic',
				'title'              => '',
				'topic'              => '',
				'topic_element'      => 'h2',
				'topic_class'        => 'h4',
				'question_element'   => 'h3',
				'question_class'     => 'h6',
				'related_element'    => 'h3',
				'related_class'      => 'h4',
				'show'               => '',
				'tags'               => '',
				'order_by_sort_meta' => true,
			), $atts, 'ucf-faq-list' );

			$atts['order_by_sort_meta'] = filter_var( $atts['order_by_sort_meta'], FILTER_VALIDATE_BOOLEAN );

			$args = array(
				'post_type'      => 'faq',
				'posts_per_page' => -1
			);

			if ( $atts['order_by_sort_meta'] ) {

				// Order by meta_value first, then title
				$args['orderby'] = array(
					'meta_value' => 'ASC',
					'title'      => 'ASC'
				);

				$args['meta_query'] = array(
					'relation' => 'OR',
					array(
						'key'     => 'faq_question_sort_order',
						'compare' => 'EXISTS',
					),
					array(
						'key'     => 'faq_question_sort_order',
						'compare' => 'NOT EXISTS'
					)
				);
			}

			if ( $atts['topic'] ) {
				$term = get_term_by( 'slug', $atts['topic'], 'topic' );

				if ( ! empty( $term ) ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'topic',
							'field' => 'id',
							'terms' => $term->term_id
						)
					);
				}
			}

			$posts = get_posts( $args );
			$items = array();

			foreach ( $posts as $post ) {
				$topics = wp_get_post_terms( $post->ID, 'topic' );

				foreach ( $topics as $topic ) {
					$items[$topic->name][] = $post;
				}
			}

			$faqs = UCF_FAQ_List_Common::display_faqs( $items, $atts['layout'], $atts );

			$related_faqs_html = "";

			if ( $atts['tags'] !== '' ) {

				$related_posts = UCF_FAQ_Common::get_related_faqs( $atts['tags'], $items );
				$related_faqs_html = '<' . $atts['related_element'] . ' class="' . $atts['related_class'] . '">Related FAQs</' . $atts['related_element'] . '>';

				foreach ( $related_posts as $post ) {
					$related_faqs_html .=  UCF_FAQ_Common::display_faq( $post, $atts );
				}
			}

			return $faqs . $related_faqs_html;
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-list' ) ) {
		add_shortcode( 'ucf-faq-list', array( 'UCF_FAQ_List_Shortcode', 'shortcode' ) );
	}
}


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
			), $atts, 'ucf-faq-list' );

			$topics = get_terms( 'topic', array(
				'post_type' => array( 'faq' )
			) );

			return UCF_FAQ_Topic_List_Common::display_faq_topics( $topics, $atts['layout'], $atts );
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-topic-list' ) ) {
		add_shortcode( 'ucf-faq-topic-list', array( 'UCF_FAQ_Topic_List_Shortcode', 'shortcode' ) );
	}
}
?>
