<?php
/**
 * Defines hooks for displaying lists of faqs.
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
 * Defines hooks for displaying lists of faq categories.
 **/
if ( ! class_exists( 'UCF_FAQ_Category_List_Common' ) ) {
	class UCF_FAQ_Category_List_Common {
		public static function display_faq_categories( $items, $layout, $args ) {
			ob_start();
			// Display before
			$layout_before = ucf_faq_category_list_display_classic_before( '', $items, $args );
			if ( has_filter( 'ucf_faq_category_list_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_faq_category_list_display_' . $layout . '_before', $layout_before, $items, $args );
			}
			echo $layout_before;
			// Display title
			$layout_title = ucf_faq_category_list_display_classic_title( '', $items, $args );
			if ( has_filter( 'ucf_faq_category_list_display_' . $layout . '_title' ) ) {
				$layout_title = apply_filters( 'ucf_faq_category_list_display_' . $layout . '_title', $layout_title, $items, $args );
			}
			echo $layout_title;

			$layout_content = ucf_faq_category_list_display_classic( '', $items, $args );
			if ( has_filter( 'ucf_faq_category_list_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_faq_category_list_display_' . $layout, $layout_content, $items, $args );
			}
			echo $layout_content;

			// Display after
			$layout_after = ucf_faq_category_list_display_classic_after( '', $items, $args );
			if ( has_filter( 'ucf_faq_category_list_display_' . $layout . '_after' ) ) {
				$layout_after = apply_filters( 'ucf_faq_category_list_display_' . $layout . '_after', $layout_after, $items, $args );
			}
			echo $layout_after;
			return ob_get_clean();
		}
	}
}

/*

add_filter( 'template_include', 'faq_page_template', 9 );

function faq_page_template( $template ) {

	// var_dump( "get_query_var: " . get_query_var( 'post_type' ) );

	// if ( get_query_var( 'post_type' ) === 'faq' ) {
		$new_template = plugin_dir_path( __FILE__ ) . 'faq-category-page-template.php';
		if ( file_exists( $new_template ) ) {
			return $new_template;
		}
	// }

	return $template;
} */
