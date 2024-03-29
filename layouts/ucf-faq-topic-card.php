<?php

if ( ! function_exists( 'ucf_faq_topic_list_display_card_before' ) ) {
	function ucf_faq_topic_list_display_card_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="faq-topic-list-wrapper">
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_topic_list_display_card_before', 'ucf_faq_topic_list_display_card_before', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_topic_list_display_card_title' ) ) {
	function ucf_faq_topic_list_display_card_title( $content, $items, $args ) {
		$formatted_title = '';
		if ( $title = $args['title'] ) {
			$formatted_title = '<h2 class="ucf-faq-topic-list-title">' . $title . '</h2>';
		}
		return $formatted_title;
	}
	add_filter( 'ucf_faq_topic_list_display_card_title', 'ucf_faq_topic_list_display_card_title', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_topic_list_display_card' ) ) {
	function ucf_faq_topic_list_display_card( $content, $items, $args ) {
		ob_start();
		if ( $items ):
	?>
			<div class="<?php UCF_FAQ_Config::add_athena_attr( 'row' ); ?>">
	<?php
			foreach ( $items as $key => $item ) :
				$is_description = ( $item->description );
				$margin_class = ( $is_description ) ? "" : " mb-0";
	?>
				<div class="<?php UCF_FAQ_Config::add_athena_attr( 'col-md-6 col-lg-4 mb-4' ); ?>">
					<a class="<?php UCF_FAQ_Config::add_athena_attr( 'hover-parent text-decoration-none' ); ?>" href="<?php echo get_term_link( $item->term_id ); ?>">
						<div class="<?php UCF_FAQ_Config::add_athena_attr( 'card h-100' ); ?>">

							<?php if ( $image_url = get_field( 'faq-topic-image', $item ) ) :?>
								<img class="ucf-faq-topic-image <?php UCF_FAQ_Config::add_athena_attr( 'card-img-top' ); ?>" src="<?php echo $image_url['url']; ?>" alt="<?php echo $item->name; ?>">
							<?php endif; ?>

							<div class="<?php UCF_FAQ_Config::add_athena_attr( 'card-block' ); ?>">
								<<?php echo $args['topic_element']; ?> class="ucf-faq-topic-title <?php UCF_FAQ_Config::add_athena_attr( 'card-title text-secondary hover-child-text-underline' . $margin_class ); ?> <?php echo $args['topic_class']; ?>">
									<?php echo $item->name; ?>
								</<?php echo $args['topic_element']; ?>>

								<?php if ( $is_description ) : ?>
									<div class="ucf-faq-topic-description <?php UCF_FAQ_Config::add_athena_attr( 'card-text text-secondary' ); ?>"><?php echo $item->description; ?></div>
								<?php endif; ?>

							</div>
						</div>
					</a>
				</div>
	<?php
			endforeach;
	?>
			</div>
	<?php
		else:
	?>
			<div class="ucf-faq-list-error">No results found.</div>
	<?php
		endif;
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_topic_list_display_card', 'ucf_faq_topic_list_display_card', 10, 3 );
}

if ( ! function_exists( 'ucf_faq_topic_list_display_card_after' ) ) {
	function ucf_faq_topic_list_display_card_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
	add_filter( 'ucf_faq_topic_list_display_card_after', 'ucf_faq_topic_list_display_card_after', 10, 3 );
}
