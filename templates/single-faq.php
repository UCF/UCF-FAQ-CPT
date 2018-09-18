<?php
get_header();
$atts['show'] = ( get_field( 'faq-topic-show-answers', get_queried_object() ) ) ?  " show" : "";
$container_classes = " container my-5";
$row_classes = " row";
$title_classes = " mb-4";
$answer_classes = " col-lg-8";
$related_classes = " col-lg-8 mb-4";
$tags = array();
$topic = wp_get_post_terms( $post->ID, 'topic' );

if ( $topic && is_array( $topic ) ) {
	$topic = $topic[0];
}

$related_faq_title = ( get_field( 'related-faq-title', $topic ) ) ? get_field( 'related-faq-title', $topic ) : 'Related FAQs';

$cta_text = get_field( 'faq-topic-footer-cta-text', $topic );
$cta_url = site_url() . get_field( 'faq-topic-footer-cta-url', $topic );

foreach ( wp_get_post_tags( $post->ID ) as $tag ) {
	array_push( $tags, $tag->slug );
}

$related_posts = UCF_FAQ_Common::get_related_faqs( $tags, array( $post->ID ) );
?>

<article>
	<div class="ucf-faq-list<?php UCF_FAQ_Config::add_athena_attr( $container_classes ); ?>">
		<div class="ucf-faq-list-inner<?php UCF_FAQ_Config::add_athena_attr( $row_classes ); ?>">
			<div class="ucf-faq-topic-answer<?php UCF_FAQ_Config::add_athena_attr( $answer_classes ); ?>">
				<?php
				echo apply_filters( 'the_content', $post->post_content );
				?>
			</div>
			<?php if ( $related_posts ) : ?>
				<div class="ucf-faq-related-questions<?php UCF_FAQ_Config::add_athena_attr( $related_classes ); ?>">
					<?php echo UCF_FAQ_Common::display_related_faqs( $related_posts, $related_faq_title, $atts ); ?>
				</div>
			<?php endif; ?>
			<?php if ( $cta_text && $cta_url ) : ?>
				<div class="ucf-faq-footer<?php UCF_FAQ_Config::add_athena_attr( $answer_classes ); ?>">
					<?php echo UCF_FAQ_Common::display_footer_cta( $cta_text, $cta_url ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article>

<?php get_footer(); ?>
