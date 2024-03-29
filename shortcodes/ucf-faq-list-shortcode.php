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
				'topics'             => '',
				'tags'               => '',
				'related_tags'       => '',
				'topic_element'      => 'h2',
				'topic_class'        => 'h4',
				'question_element'   => 'strong',
				'question_class'     => 'h5',
				'related_element'    => 'strong',
				'related_class'      => 'h4',
				'show'               => '',
				'group_by'           => 'topic',
				'order_by_sort_meta' => true,
				'footer_cta_text'    => 'View All FAQs',
				'footer_cta_url'     => '/faq/'
			), $atts, 'ucf-faq-list' );

			$atts['order_by_sort_meta'] = filter_var( $atts['order_by_sort_meta'], FILTER_VALIDATE_BOOLEAN );

			$args = array(
				'post_type'      => 'faq',
				'posts_per_page' => -1
			);
			$tax_query = array();
			$topics = array();
			$tags = array();
			$related_tags = array();

			// Generate orderby post query args
			if ( $atts['order_by_sort_meta'] ) {

				// Order by meta_value first, then title
				$args['orderby'] = array(
					'meta_value_num' => 'ASC',
					'title'          => 'ASC'
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

			// Generate topic-related query args
			if ( $atts['topics'] ) {
				$topics = explode( ',', $atts['topics'] );
				$tax_query[] = array(
					'taxonomy' => 'topic',
					'field' => 'slug',
					'terms' => $topics
				);
			}

			// Generate tag-related query args
			if ( $atts['tags'] ) {
				$tags = explode( ',', $atts['tags'] );
				$tax_query[] = array(
					'taxonomy' => 'post_tag',
					'field' => 'slug',
					'terms' => $tags
				);
			}

			// Add tax_query to query args if valid args are defined
			if ( ! empty( $tax_query ) ) {
				$args['tax_query'] = $tax_query;
			}

			// Fetch posts and group them
			$posts = get_posts( $args );
			$items = array();

			if ( $atts['group_by'] === 'topic' ) {
				foreach ( $posts as $post ) {
					$post_topics = wp_get_post_terms( $post->ID, 'topic' );

					// NOTE: FAQs not belonging to at least one topic will NOT be
					// listed in shortcode results when grouping by topic is
					// enabled
					foreach ( $post_topics as $topic ) {
						if (
							( $atts['topics'] && in_array( $topic->slug, $topics ) )
							|| empty( $atts['topics'] )
						) {
							$items[$topic->name][] = $post;
						}
					}
				}
			}
			else {
				$items['All'] = $posts;
			}

			// Display results
			$faqs = UCF_FAQ_List_Common::display_faqs( $items, $atts['layout'], $atts );

			$related_faq_markup = '';
			if ( ! empty( $atts['related_tags'] ) ) {
				$related_tags = explode( ',', $atts['related_tags'] );
				$related_exclude = array_map( function( $value ) {
					return $value->ID;
				}, $posts );
				$related_posts = UCF_FAQ_Common::get_related_faqs_by_tag( $related_tags, $related_exclude );
				$related_faq_markup = UCF_FAQ_Common::display_related_faqs( $related_posts, 'Related FAQs', $atts );
			}

			$cta = UCF_FAQ_Common::display_footer_cta( $atts['footer_cta_text'], $atts['footer_cta_url'] );

			return $faqs . $related_faq_markup . $cta;
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-list' ) ) {
		add_shortcode( 'ucf-faq-list', array( 'UCF_FAQ_List_Shortcode', 'shortcode' ) );
	}
}
