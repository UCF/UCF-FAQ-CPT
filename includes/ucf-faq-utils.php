<?php
if ( ! function_exists( 'ucf_faq_group_by_tax_term' ) ) {
	function ucf_faq_group_posts_by_tax( $taxonomy_slug, $posts ) {
		$retval = array();
		foreach( $posts as $post ) {
			$post_terms = wp_get_post_terms( $post->ID, $taxonomy_slug );
			foreach( $post_terms as $term ) {
				if ( ! isset( $retval[$term->term_id] ) || ! is_array( $retval[$term->term_id] ) ) {
					$retval[$term->term_id] = array(
						'term'  => array(
							'name'  => $term->name,
							'meta' => ucf_faq_reduce_meta_values( get_term_meta( $term->term_id ) ),
						),
						'posts' => array()
					);
				}
				$retval[$term->term_id]['posts'][] = $post;
			}
		}
		return $retval;
	}
}
if ( ! function_exists( 'ucf_faq_reduce_meta_values' ) ) {
	/**
	 * Converts all single index arrays to values
	 * @author Jim Barnes
	 * @since 1.0.0
	 * @param $meta_array array | Array of meta values
	 * @return array
	 **/
	function ucf_faq_reduce_meta_values( $meta_array ) {
		$retval = $meta_array;
		foreach( $meta_array as $key=>$value ) {
			if ( is_array( $value ) && count( $value ) === 1 ) {
				$retval[$key] = $value[0];
			} else {
				$retval[$key] = $value;
			}
		}
		return $retval;
	}

}
?>
