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
				'topic'          => '',
				'topic_element'  => 'h2',
				'topic_class'    => 'h4',
				'question_element'  => 'h3',
				'question_class'    => 'h6',
			), $atts, 'ucf-faq-list' );

			$topic_id = null;

			if( $atts['topic'] ) {
				$slug = get_term_by( 'slug', $atts['topic'], 'topic' );
				if( !empty( $slug ) ) {
					$topic_id =  $slug->term_id;
				}
			}

			$args = array(
				'post_type'      => 'faq',
				'topic'       => $topic_id,
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC'
			);

			$posts = get_posts( $args );
			$items = array();

			foreach( $posts as $post ) {
				$topics = wp_get_post_terms( $post->ID, 'topic' );

				foreach( $topics as $topic ) {
					$items[$topic->name][] = $post;
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
				'layout'            => 'classic',
				'title'             => '',
				'topic_element'  => 'h2',
				'topic_class'    => 'h4',
			), $atts, 'ucf-faq-list' );

			$topics = get_terms( 'topic', array(
				'post_type' => array('faq')
			) );

			return UCF_FAQ_Topic_List_Common::display_faq_topics( $topics, $atts['layout'], $atts );
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-topic-list' ) ) {
		add_shortcode( 'ucf-faq-topic-list', array( 'UCF_FAQ_Topic_List_Shortcode', 'shortcode' ) );
	}
}
?>
