<?php get_header(); ?>

<?php
$topic = get_queried_object();
?>

<article>
	<?php
	// Determine whether or not this template's default markup, or custom
	// markup, should be displayed:

	if ( get_field( 'faq-topic-view-type', $topic ) === 'custom' ) :

		// Display custom markup only
		echo apply_filters( 'the_content', get_field( 'faq-topic-custom-content', $topic ) );

	else:
		$tags              = array();
		$faqs              = array();
		$faq_atts          = array();
		$faq_atts['show']  = ( get_field( 'faq-topic-show-answers', $topic ) ) ?  ' show' : '';
		$related_posts     = array();
		$related_faq_html  = '';
		$related_faq_title = get_field( 'related-faq-title', $topic );
		$cta_text          = get_field( 'faq-topic-footer-cta-text', $topic );
		$cta_url           = get_field( 'faq-topic-footer-cta-url', $topic );
		$spotlight         = false;

		if ( in_array( 'UCF-Spotlights-Plugin/ucf-spotlight.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$spotlight = get_field( 'faq-topic-spotlight', $topic );
		}

		if ( substr( $cta_url, 0, 1 ) === '/' ) {
			$cta_url = site_url(). $cta_url;
		}
	?>

	<div class="ucf-faq-topic-list<?php UCF_FAQ_Config::add_athena_attr( ' container mt-4 mt-sm-5 mb-5' ); ?>">
		<div class="<?php UCF_FAQ_Config::add_athena_attr( 'row' ); ?>">
			<div class="ucf-faq-topic-description<?php UCF_FAQ_Config::add_athena_attr( ' col-lg-7 mb-4' ); ?>">

				<?php
				// Display term description, if available
				$topic_description = term_description();
				if ( ! empty( $topic_description ) ) {
					UCF_FAQ_Config::add_athena_attr( $topic_description );
				}
				?>

				<?php if ( ! have_posts() ): ?>

					<p>No results found.</p>

				<?php else: ?>

					<?php
					// Display the main FAQ post loop:
					while ( have_posts() ) : the_post();
					?>
						<?php
						// Save FAQ and tag list to filter out of related FAQs section
						array_push( $faqs, $post->ID );

						foreach ( wp_get_post_tags( $post->ID ) as $tag ) {
							if ( ! in_array( $tag, $tags ) ) {
								array_push( $tags, $tag->slug );
							}
						}
						?>

						<?php
						// Display each individual FAQ
						echo UCF_FAQ_Common::display_faq( $post, $faq_atts );
						?>

					<?php
					// END main FAQ post loop
					endwhile;
					?>

				<?php
				// END have_posts()
				endif;
				?>


				<?php
				// Generate Related FAQs markup
				$related_posts = UCF_FAQ_Common::get_related_faqs( $tags, $faqs );

				foreach ( $related_posts as $post ) {
					$related_faq_html .= UCF_FAQ_Common::display_faq( $post, $faq_atts );
				}
				?>

				<?php
				// Display Related FAQs
				if ( $related_faq_html ) :
				?>
					<?php if ( $related_faq_title ): ?>
					<h2 class="<?php UCF_FAQ_Config::add_athena_attr( 'h4 mt-5 mb-4' ); ?>">
						<?php echo wptexturize( $related_faq_title ); ?>
					</h2>
					<?php endif; ?>

					<?php echo $related_faq_html; ?>
				<?php endif; ?>

				<?php
				// Display CTA Footer
				if ( $cta_text && $cta_url ):
				?>
				<a href="<?php echo $cta_url; ?>" class="<?php UCF_FAQ_Config::add_athena_attr( 'btn btn-primary mt-4' ); ?>">
					<?php echo wptexturize( $cta_text ); ?>
				</a>
				<?php endif; ?>

			</div>


			<?php
			// Display Sidebar Spotlight
			if ( $spotlight ) :
			?>
			<div class="ucf-faq-topic-sidebar<?php UCF_FAQ_Config::add_athena_attr( ' col-lg-4 offset-lg-1 mt-5 mt-lg-2' ); ?>">
				<?php echo do_shortcode( '[ucf-spotlight slug="' . $spotlight->post_name . '"]' ); ?>
			</div>
			<?php endif; ?>

		</div>
	</div>
	<?php endif; ?>
</article>

<?php get_footer(); ?>
