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
		echo get_field( 'faq-topic-custom-content', $topic );

	else:
		$tags              = array();
		$faqs              = array();
		$faq_atts          = array();
		$faq_atts['show']  = ( get_field( 'faq-topic-show-answers', $topic ) ) ?  ' show' : '';
		$related_posts     = array();
		$related_faq_html  = '';
		$related_faq_title = ( get_field( 'related-faq-title', $topic ) ) ? get_field( 'related-faq-title', $topic ) : 'Related FAQs';
		$cta_text          = get_field( 'faq-topic-footer-cta-text', $topic );
		$cta_url           = get_field( 'faq-topic-footer-cta-url', $topic );
		$spotlight         = false;

		if ( in_array( 'UCF-Spotlights-Plugin/ucf-spotlight.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$spotlight = get_field( 'faq-topic-spotlight', $topic );
		}
	?>

	<?php
	// Display term description, if available
	$topic_description = term_description();
	if ( ! empty( $topic_description ) ):
	?>
	<div class="ucf-faq-topic-description<?php UCF_FAQ_Config::add_athena_attr( ' container lead mt-4 mt-sm-5 mb-5' ); ?>">
		<?php echo $topic_description; ?>
	</div>
	<?php endif; ?>

	<div class="ucf-faq-topic-list<?php UCF_FAQ_Config::add_athena_attr( ' container mt-4 mt-sm-5 mb-5' ); ?>">
		<div class="<?php UCF_FAQ_Config::add_athena_attr( 'row' ); ?>">
			<div class="ucf-faq-topic-list-items<?php UCF_FAQ_Config::add_athena_attr( ' col-lg-7 mb-4' ); ?>">

				<?php if ( ! have_posts() ): ?>

					<p>No results found.</p>

				<?php else: ?>

					<?php
					// Display the main FAQ post loop:
					while ( have_posts() ) : the_post();
						$faqs[] = $post->ID;

						// Display each individual FAQ
						$unique_id = wp_rand();
						echo UCF_FAQ_Common::display_faq( $post, $faq_atts, $unique_id );
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
				$related_posts = UCF_FAQ_Common::get_related_faqs_by_topic( array( $topic ), $faqs );
				echo UCF_FAQ_Common::display_related_faqs( $related_posts, $related_faq_title, $faq_atts );

				// Display CTA Footer
				echo UCF_FAQ_Common::display_footer_cta( $cta_text, $cta_url );

				$generate = UCF_FAQ_Config::get_option_or_default( 'add_json_data' );

				if ( $generate ) :
				?>
				<script type="application/ld+json">
				<?php
					$posts = $wp_query->posts;
					echo UCF_FAQ_Common::generate_json_ld( $posts );

				?>
				</script>
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
