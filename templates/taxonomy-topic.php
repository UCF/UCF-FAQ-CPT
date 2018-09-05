<?php
get_header();

$tags = array();
$faqs = array();
$container_classes = " container mb-5";
$show = ( get_field( 'faq-topic-show-answers', get_queried_object() ) ) ?  " show" : "";
$topic_description = term_description();
$spotlight = false;
if( in_array('UCF-Spotlights-Plugin/ucf-spotlight.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {
	$spotlight = get_field( 'faq-topic-spotlight', get_queried_object() );
}
?>


<article>
	<div class="ucf-faq-topic-list<?php UCF_FAQ_Config::add_athena_attr( $container_classes ); ?>">
		<?php

		if ( ! empty( $topic_description ) ) :
			$topic_description_classes = " col-md-8 mb-4";
		?>
			<div class="<?php UCF_FAQ_Config::add_athena_attr( 'row' ); ?>">
				<div class="ucf-faq-topic-description<?php UCF_FAQ_Config::add_athena_attr( $topic_description_classes ); ?>">
					<?php UCF_FAQ_Config::add_athena_attr( $topic_description ); ?>
				</div>
			</div>
		<?php
		endif;

		if ( have_posts() ) :
			?>
			<div class="<?php UCF_FAQ_Config::add_athena_attr( 'row' ); ?>">
				<div class="<?php UCF_FAQ_Config::add_athena_attr( 'col-md-8' ); ?>">
			<?php
				while ( have_posts() ) :
					the_post();

					// Save FAQ and tag list to filter out of related FAQs section
					array_push( $faqs, $post->ID );

					foreach( wp_get_post_tags( $post->ID ) as $tag ) {
						if( !in_array( $tag, $tags ) ) {
							array_push( $tags, $tag->slug );
						}
					}

					echo UCF_FAQ_Common::display_faq( $post, $show, 'h5' );
				endwhile;

				$related_posts = UCF_FAQ_Common::get_related_faqs( $tags, $faqs );
				$related_faq_html = null;

				foreach( $related_posts as $post ) {
					$related_faq_html .=  UCF_FAQ_Common::display_faq( $post, $show, 'h5' );
				}

				if( $related_faq_html ) :
				?>
					<h2 class="<?php UCF_FAQ_Config::add_athena_attr( 'h4 mt-5 mb-4' ); ?>">
						<?php echo get_field( 'related-faq-title', get_queried_object() ); ?>
					</h2>
				<?php
					echo $related_faq_html;
				endif;

				if( $cta_text = get_field( 'faq-topic-footer-cta-text', get_queried_object() ) ) :
			?>
					<a href="<?php echo site_url() . get_field( 'faq-topic-footer-cta-url', get_queried_object() ); ?>"
						class="<?php UCF_FAQ_Config::add_athena_attr( 'btn btn-primary mt-4' ); ?>">
						<?php echo $cta_text; ?>
					</a>
			<?php
				endif;
			?>
				</div>

				<?php if( $spotlight ) : ?>
					<div class="col-md-4 mt-5 mt-md-3">
						<?php echo do_shortcode( '[ucf-spotlight slug="' . $spotlight->post_name . '"]' ); ?>
					</div>
				<?php endif; ?>

			</div>
			<?php
		else: // have_posts() else
			echo 'No results found.';
		endif;
		?>
	</div>
</article>

<?php get_footer(); ?>
