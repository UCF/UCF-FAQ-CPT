<?php

if ( ! function_exists( 'ucf_faq_category_list_display_classic_before' ) ) {
	function ucf_faq_category_list_display_classic_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="faq-category-list-wrapper">
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_category_list_display_classic_before', 'ucf_faq_category_list_display_classic_before', 10, 4 );
}

if ( ! function_exists( 'ucf_faq_category_list_display_classic_title' ) ) {
	function ucf_faq_category_list_display_classic_title( $content, $items, $args ) {
		$formatted_title = '';
		if ( $title = $args['title'] ) {
			$formatted_title = '<h2 class="ucf-faq-category-list-title">' . $title . '</h2>';
		}
		return $formatted_title;
	}
	add_filter( 'ucf_faq_category_list_display_classic_title', 'ucf_faq_category_list_display_classic_title', 10, 4 );
}

if ( ! function_exists( 'ucf_faq_category_list_display_classic' ) ) {
	function ucf_faq_category_list_display_classic( $content, $items, $args ) {
		ob_start();
		if( $items ):
			foreach( $items as $item ) :
	?>
				<h2 class="ucf-faq-category-title"><?php echo $item->name; ?></h2>
				<div class="ucf-faq-category-content">
					<?php echo $item->description; ?>
				</div>
	<?php
			endforeach;
		else:
	?>
			<div class="ucf-faq-list-error">No results found.</div>
	<?php
		endif;
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_category_list_display_classic', 'ucf_faq_category_list_display_classic', 10, 4 );
}

if ( ! function_exists( 'ucf_faq_category_list_display_classic_after' ) ) {
	function ucf_faq_category_list_display_classic_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_category_list_display_classic_after', 'ucf_faq_category_list_display_classic_after', 10, 4 );
}
