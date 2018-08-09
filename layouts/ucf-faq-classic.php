<?php

if ( ! function_exists( 'ucf_faq_list_display_classic_before' ) ) {
	function ucf_faq_list_display_classic_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="faq-list-wrapper">
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_list_display_classic_before', 'ucf_faq_list_display_classic_before', 10, 4 );
}

if ( ! function_exists( 'ucf_faq_list_display_classic_title' ) ) {
	function ucf_faq_list_display_classic_title( $content, $items, $args ) {
		$formatted_title = '';
		if ( $title = $args['title'] ) {
			$formatted_title = '<h2 class="ucf-faq-list-title">' . $title . '</h2>';
		}
		return $formatted_title;
	}
	add_filter( 'ucf_faq_list_display_classic_title', 'ucf_faq_list_display_classic_title', 10, 4 );
}

if ( ! function_exists( 'ucf_faq_list_display_classic' ) ) {
	function ucf_faq_list_display_classic( $content, $items, $args ) {
		ob_start();
		if( $items ):
			foreach( $items as $key => $item ) :
	?>
				<h2 class="ucf-faq-category"><?php echo $key; ?></h2>
	<?php
				foreach( $item as $post ) :
	?>
					<h3 class="ucf-faq-question"><?php echo $post->post_title; ?></h3>
					<div class="ucf-faq-answer">
						<?php echo $post->post_content; ?>
					</div>
	<?php
				endforeach;
			endforeach;
		else:
	?>
			<div class="ucf-faq-list-error">No results found.</div>
	<?php
		endif;
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_list_display_classic', 'ucf_faq_list_display_classic', 10, 4 );
}

if ( ! function_exists( 'ucf_faq_list_display_classic_after' ) ) {
	function ucf_faq_list_display_classic_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_list_display_classic_after', 'ucf_faq_list_display_classic_after', 10, 4 );
}
