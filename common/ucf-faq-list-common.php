<?php
/**
 * Defines hooks for displaying lists of faqs.
 **/
if ( ! class_exists( 'UCF_FAQ_List_Common' ) ) {
	class UCF_FAQ_List_Common {
		public static function display_faqs( $items, $layout, $args ) {
			ob_start();
			// Display before
			$layout_before = ucf_faq_list_display_classic_before( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_faq_list_display_' . $layout . '_before', $layout_before, $items, $args );
			}
			echo $layout_before;
			// Display title
			$layout_title = ucf_faq_list_display_classic_title( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout . '_title' ) ) {
				$layout_title = apply_filters( 'ucf_faq_list_display_' . $layout . '_title', $layout_title, $items, $args );
			}
			echo $layout_title;

			$layout_content = ucf_faq_list_display_classic( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_faq_list_display_' . $layout, $layout_content, $items, $args );
			}
			echo $layout_content;

			// Display after
			$layout_after = ucf_faq_list_display_classic_after( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout . '_after' ) ) {
				$layout_after = apply_filters( 'ucf_faq_list_display_' . $layout . '_after', $layout_after, $items, $args );
			}
			echo $layout_after;
			return ob_get_clean();
		}
	}
}

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
				<h2 class="mt-5 mb-3 h4"><?php echo $key; ?></h2>
	<?php
				foreach( $item as $post ) :
	?>
					<h3 class="mt-3 h6" data-toggle="collapse" href="#post<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></h3>
					<div class="collapse" id="post<?php echo $post->ID; ?>">
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
