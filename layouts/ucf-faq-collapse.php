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
		if ( $items ):
			$show = ( $args['show'] === "true" ) ? " show" : "";

			foreach ( $items as $key => $item ) :
				$unique_id = wp_rand();
	?>
				<?php if ( $key !== 'All' ): ?>
					<<?php echo $args['topic_element']; ?> class="ucf-faq-topic <?php UCF_FAQ_Config::add_athena_attr( 'd-block pt-3' ); ?> <?php echo $args['topic_class']; ?>"><?php echo $key; ?></<?php echo $args['topic_element']; ?>>
				<?php endif; ?>
	<?php
				foreach ( $item as $post ) :
					echo UCF_FAQ_Common::display_faq( $post, $args, $unique_id );
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
?>
