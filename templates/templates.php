<?php
/**
 * Adds filter to display custom template for FAQ topic taxonomy.
 * @author RJ Bruneel
 * @since 1.0.0
 **/
function ucf_faq_template( $template ) {
	if ( get_query_var( 'post_type' ) === 'faq' && is_archive() ) {
		// Look for a file in theme
		if( !locate_template('archive-faq.php' ) ) {
			$new_template = plugin_dir_path( __FILE__ ) . 'archive-faq.php';
			if ( file_exists( $new_template ) ) {
				return $new_template;
			}
		}
	}

	return $template;
}

add_filter( 'template_include', 'ucf_faq_template', 9 );


/**
 * Adds filter to display custom template for FAQ topic taxonomy.
 * @author RJ Bruneel
 * @since 1.0.0
 **/
function ucf_faq_topic_template( $template ) {
	if ( is_tax( 'topic' ) ) {
		// Look for a file in theme
		if( !locate_template('taxonomy-topic.php' ) ) {
			$new_template = plugin_dir_path( __FILE__ ) . 'taxonomy-topic.php';
			if ( file_exists( $new_template ) ) {
				return $new_template;
			}
		}
	}

	return $template;
}

add_filter( 'template_include', 'ucf_faq_topic_template', 9 );


function ucf_faq_sort_order( $query ) {
	if ( is_tax( 'topic' ) || ( get_query_var( 'post_type' ) === 'faq' && is_archive() ) || is_post_type_archive( 'faq' ) ) {
		$query->set( 'meta_key', 'faq_question_sort_order' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'ASC' );
		$query->set( 'posts_per_page', '-1' );
	}
};

add_action( 'pre_get_posts', 'ucf_faq_sort_order' );
?>
