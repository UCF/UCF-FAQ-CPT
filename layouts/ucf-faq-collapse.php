<?php
if ( ! function_exists( 'ucf_faq_list_display_collapse_before' ) ) {
	function ucf_faq_list_display_collapse_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="faq-list-wrapper">
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_list_display_collapse_before', 'ucf_faq_list_display_collapse_before', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_list_display_collapse_title' ) ) {
	function ucf_faq_list_display_collapse_title( $content, $items, $args ) {
		$formatted_title = '';
		if ( $title = $args['title'] ) {
			$formatted_title = '<h2 class="ucf-faq-list-title">' . $title . '</h2>';
		}
		return $formatted_title;
	}
	add_filter( 'ucf_faq_list_display_collapse_title', 'ucf_faq_list_display_collapse_title', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_list_display_collapse' ) ) {
	function ucf_faq_list_display_collapse( $content, $items, $args ) {
		ob_start();
		$unique_id = wp_rand();
		if( $items ):
			foreach( $items as $key => $item ) :
	?>
				<<?php echo $args['topic_element']; ?> class="ucf-faq-topic mt-4 mb-3 <?php echo $args['topic_class']; ?>"><?php echo $key; ?></<?php echo $args['topic_element']; ?>>
	<?php
				foreach( $item as $post ) :
	?>
					<a href="<?php echo get_permalink( $post->ID ); ?>"><<?php echo $args['question_element']; ?> class="ucf-faq-question mt-3 <?php echo $args['question_class']; ?>" data-toggle="collapse" href="#post<?php echo $post->ID . $unique_id; ?>">
						<?php echo $post->post_title; ?></<?php echo $args['question_element']; ?>>
					</a>
					<div class="collapse ucf-faq-answer" id="post<?php echo $post->ID . $unique_id; ?>">
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
	add_filter( 'ucf_faq_list_display_collapse', 'ucf_faq_list_display_collapse', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_list_display_collapse_after' ) ) {
	function ucf_faq_list_display_collapse_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_list_display_collapse_after', 'ucf_faq_list_display_collapse_after', 10, 3 );
}
