<?php

if ( ! function_exists( 'ucf_faq_topic_list_display_classic_before' ) ) {
	function ucf_faq_topic_list_display_classic_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="faq-topic-list-wrapper">
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_topic_list_display_classic_before', 'ucf_faq_topic_list_display_classic_before', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_topic_list_display_classic_title' ) ) {
	function ucf_faq_topic_list_display_classic_title( $content, $items, $args ) {
		$formatted_title = '';
		if ( $title = $args['title'] ) {
			$formatted_title = '<h2 class="ucf-faq-topic-list-title">' . $title . '</h2>';
		}
		return $formatted_title;
	}
	add_filter( 'ucf_faq_topic_list_display_classic_title', 'ucf_faq_topic_list_display_classic_title', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_topic_list_display_classic' ) ) {
	function ucf_faq_topic_list_display_classic( $content, $items, $args ) {
		ob_start();
		if ( $items ):
			foreach ( $items as $item ) :
	?>
				<a href="<?php echo get_term_link( $item->term_id ); ?>">
					<<?php echo $args['topic_element']; ?> class="ucf-faq-topic-title <?php echo $args['topic_class']; ?>"><?php echo $item->name; ?></<?php echo $args['topic_element']; ?>>
				</a>
				<div class="ucf-faq-topic-content">
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
	add_filter( 'ucf_faq_topic_list_display_classic', 'ucf_faq_topic_list_display_classic', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_topic_list_display_classic_after' ) ) {
	function ucf_faq_topic_list_display_classic_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_topic_list_display_classic_after', 'ucf_faq_topic_list_display_classic_after', 10, 3 );
}
