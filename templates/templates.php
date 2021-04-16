<?php
/**
 * Adds filter to display custom template for FAQ topic taxonomy.
 * @author RJ Bruneel
 * @since 1.0.0
 **/
function ucf_faq_archive_template( $template ) {
	if ( get_query_var( 'post_type' ) === 'faq' && is_archive() ) {
		// Look for a file in theme
		if ( ! locate_template( 'archive-faq.php' ) ) {
			$new_template = plugin_dir_path( __FILE__ ) . 'archive-faq.php';
			if ( file_exists( $new_template ) ) {
				return $new_template;
			}
		}
	}

	return $template;
}

add_filter( 'template_include', 'ucf_faq_archive_template', 9 );


/**
 * Adds filter to display custom template for FAQ single.
 * @author RJ Bruneel
 * @since 1.0.0
 **/
function ucf_faq_template( $template ) {
	if ( get_query_var( 'post_type' ) === 'faq' && ! is_archive() ) {
		// Look for a file in theme
		if ( ! locate_template( 'single-faq.php' ) ) {
			$new_template = plugin_dir_path( __FILE__ ) . 'single-faq.php';
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
		if ( ! locate_template( 'taxonomy-topic.php' ) ) {
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
	if (
		! is_admin()
		&& (
			is_tax( 'topic' )
			|| ( $query->get( 'post_type' ) === 'faq' && is_archive() )
			|| is_post_type_archive( 'faq' )
		)
	) {
		$orderby = array(
			'meta_value_num' => 'ASC',
			'title'          => 'ASC'
		);

		$query->set( 'orderby', $orderby );
		$query->set( 'posts_per_page', '-1' );

		$meta_query = array(
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

		$query->set( 'meta_query', $meta_query );
	}
};

add_action( 'pre_get_posts', 'ucf_faq_sort_order' );
?>
