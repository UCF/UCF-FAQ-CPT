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
				<<?php echo $args['category_element']; ?> class="ucf-faq-category <?php echo $args['category_class']; ?>"><?php echo $key; ?></<?php echo $args['category_element']; ?>>
	<?php
				foreach( $item as $post ) :
	?>
					<<?php echo $args['question_element']; ?> class="ucf-faq-question <?php echo $args['question_class']; ?>"><?php echo $post->post_title; ?></<?php echo $args['question_element']; ?>>
					<p class="ucf-faq-answer">
						<?php echo $post->post_content; ?>
					</p>
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
