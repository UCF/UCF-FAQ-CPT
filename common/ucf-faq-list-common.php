<?php
/**
 * Defines hooks for displaying a list of FAQs.
 * @author RJ Bruneel
 * @since 1.0.0
 **/
if ( ! class_exists( 'UCF_FAQ_List_Common' ) ) {
	class UCF_FAQ_List_Common {
		public static function display_faqs( $items, $layout, $args ) {
			ob_start();
			// Display before
			$layout_before = ucf_faq_list_display_classic_before( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_faq_list_display_' . $layout . '_before', $layout_before, $items, $args );
			}
			echo $layout_before;
			// Display title
			$layout_title = ucf_faq_list_display_classic_title( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout . '_title' ) ) {
				$layout_title = apply_filters( 'ucf_faq_list_display_' . $layout . '_title', $layout_title, $items, $args );
			}
			echo $layout_title;

			$layout_content = ucf_faq_list_display_classic( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_faq_list_display_' . $layout, $layout_content, $items, $args );
			}
			echo $layout_content;

			// Display after
			$layout_after = ucf_faq_list_display_classic_after( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout . '_after' ) ) {
				$layout_after = apply_filters( 'ucf_faq_list_display_' . $layout . '_after', $layout_after, $items, $args );
			}
			echo $layout_after;
			return ob_get_clean();
		}
	}
}


/**
 * Defines hooks for displaying a list of FAQ topics.
 * @author RJ Bruneel
 * @since 1.0.0
 **/
if ( ! class_exists( 'UCF_FAQ_Topic_List_Common' ) ) {
	class UCF_FAQ_Topic_List_Common {
		public static function display_faq_topics( $items, $layout, $args ) {
			ob_start();
			// Display before
			$layout_before = ucf_faq_topic_list_display_classic_before( '', $items, $args );
			if ( has_filter( 'ucf_faq_topic_list_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_faq_topic_list_display_' . $layout . '_before', $layout_before, $items, $args );
			}
			echo $layout_before;
			// Display title
			$layout_title = ucf_faq_topic_list_display_classic_title( '', $items, $args );
			if ( has_filter( 'ucf_faq_topic_list_display_' . $layout . '_title' ) ) {
				$layout_title = apply_filters( 'ucf_faq_topic_list_display_' . $layout . '_title', $layout_title, $items, $args );
			}
			echo $layout_title;

			$layout_content = ucf_faq_topic_list_display_classic( '', $items, $args );
			if ( has_filter( 'ucf_faq_topic_list_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_faq_topic_list_display_' . $layout, $layout_content, $items, $args );
			}
			echo $layout_content;

			// Display after
			$layout_after = ucf_faq_topic_list_display_classic_after( '', $items, $args );
			if ( has_filter( 'ucf_faq_topic_list_display_' . $layout . '_after' ) ) {
				$layout_after = apply_filters( 'ucf_faq_topic_list_display_' . $layout . '_after', $layout_after, $items, $args );
			}
			echo $layout_after;
			return ob_get_clean();
		}
	}
}
