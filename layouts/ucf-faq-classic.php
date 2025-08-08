<?php

if ( ! function_exists( 'ucf_faq_list_display_classic_before' ) ) {
	function ucf_faq_list_display_classic_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="ucf-faq-list ucf-faq-list-classic">
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_list_display_classic_before', 'ucf_faq_list_display_classic_before', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_list_display_classic_title' ) ) {
	function ucf_faq_list_display_classic_title( $content, $items, $args ) {
		$formatted_title = '';
		if ( $title = $args['title'] ) {
			$formatted_title = '<h2 class="ucf-faq-list-title">' . $title . '</h2>';
		}
		return $formatted_title;
	}
	add_filter( 'ucf_faq_list_display_classic_title', 'ucf_faq_list_display_classic_title', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_list_display_classic' ) ) {
	function ucf_faq_list_display_classic( $content, $items, $args ) {
		ob_start();
		if ( $items ):
			foreach ( $items as $key => $item ) :
				$unique_id = wp_rand();
	?>
				<?php if ( $key !== 'All' ): ?>
					<<?php echo $args['topic_element']; ?> class="ucf-faq-topic <?php UCF_FAQ_Config::add_athena_attr( 'd-block pt-3 mb-3' ); ?> <?php echo $args['topic_class']; ?>"><?php echo $key; ?></<?php echo $args['topic_element']; ?>>
				<?php endif; ?>
	<?php
				foreach ( $item as $post ):
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
	add_filter( 'ucf_faq_list_display_classic', 'ucf_faq_list_display_classic', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_list_display_classic_after' ) ) {
	function ucf_faq_list_display_classic_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_list_display_classic_after', 'ucf_faq_list_display_classic_after', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_list_display_classic_script' ) ) {
	function ucf_faq_list_display_classic_script( $content, $items, $args ) {
		// Check to see if we're generating data.
		$generate = UCF_FAQ_Config::get_option_or_default( 'add_json_ld' );
		if ( ! $generate ) return '';

		$markup = UCF_FAQ_Common::generate_json_ld( $items );

		ob_start();
?>
<script type="application/ld+json">
	<?php echo $markup; ?>
</script>
<?php
		return ob_get_clean();
	}
}
