<?php
if ( ! function_exists( 'ucf_faq_list_display_athena_before' ) ) {
	function ucf_faq_list_display_athena_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="faq-list-wrapper">
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_list_display_athena_before', 'ucf_faq_list_display_athena_before', 10, 4 );
}

if ( ! function_exists( 'ucf_faq_list_display_athena_title' ) ) {
	function ucf_faq_list_display_athena_title( $content, $items, $args ) {
		$formatted_title = '';
		if ( $title = $args['title'] ) {
			$formatted_title = '<h2 class="ucf-faq-list-title">' . $title . '</h2>';
		}
		return $formatted_title;
	}
	add_filter( 'ucf_faq_list_display_athena_title', 'ucf_faq_list_display_athena_title', 10, 4 );
}

if ( ! function_exists( 'ucf_faq_list_display_athena' ) ) {
	function ucf_faq_list_display_athena( $content, $items, $args ) {
		ob_start();
		if( $items ):
			foreach( $items as $key => $item ) :
	?>
				<h2 class="ucf-faq-category mt-5 mb-3 h4"><?php echo $key; ?></h2>
	<?php
				foreach( $item as $post ) :
	?>
					<a href="<?php echo get_permalink( $post->ID ); ?>"><h3 class="ucf-faq-question mt-3 h6" data-toggle="collapse" href="#post<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></h3></a>
					<div class="collapse ucf-faq-answer" id="post<?php echo $post->ID; ?>">
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
	add_filter( 'ucf_faq_list_display_athena', 'ucf_faq_list_display_athena', 10, 4 );
}

if ( ! function_exists( 'ucf_faq_list_display_athena_after' ) ) {
	function ucf_faq_list_display_athena_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_list_display_athena_after', 'ucf_faq_list_display_athena_after', 10, 4 );
}
