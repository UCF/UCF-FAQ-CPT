<?php
get_header();
$atts['show'] = ( get_field( 'faq-topic-show-answers', get_queried_object() ) ) ?  " show" : "";
$container_classes = " container my-5";
$title_classes = " mb-4";
$answer_classes = " col-lg-8 mt-2 mb-4";
$tags = array();
$topic = wp_get_post_terms( $post->ID, 'topic' );

if( $topic && is_array( $topic ) ) {
	$topic = $topic[0];
}

$cta_text = get_field( 'faq-topic-footer-cta-text', $topic );
$cta_url = site_url() . get_field( 'faq-topic-footer-cta-url', $topic );

foreach( wp_get_post_tags( $post->ID ) as $tag ) {
	array_push( $tags, $tag->slug );
}

$related_posts = UCF_FAQ_Common::get_related_faqs( $tags, "" );
$related_faq_html = null;
?>

<article>
	<div class="ucf-faq-list<?php UCF_FAQ_Config::add_athena_attr( $container_classes ); ?>">
		<div class="ucf-faq-topic-answer<?php UCF_FAQ_Config::add_athena_attr( $answer_classes ); ?>">
			<?php
			echo apply_filters( 'the_content', $post->post_content );

			foreach( $related_posts as $post ) {
				$related_faq_html .=  UCF_FAQ_Common::display_faq( $post, $atts );
			}

			if( $related_faq_html ) :
			?>
				<h2 class="<?php UCF_FAQ_Config::add_athena_attr( 'h4 mt-5 mb-4' ); ?>">
				<?php echo get_field( 'related-faq-title', $topic ); ?>
				</h2>
			<?php
				echo $related_faq_html;
			endif;

			if( $cta_text && $cta_url ) :
			?>
				<a href="<?php echo $cta_url; ?>"
					class="<?php UCF_FAQ_Config::add_athena_attr( 'btn btn-primary mt-4' ); ?>">
					<?php echo $cta_text; ?>
				</a>
			<?php
			endif;
			?>
		</div>
	</div>
</article>

<?php get_footer(); ?>
