<?php
get_header();
$show = ( get_field( 'faq-topic-show-answers', get_queried_object() ) ) ?  " show" : "";
$container_classes = " container my-5";
$title_classes = " mb-4";
$answer_classes = " col-lg-8 mt-2 mb-4";
$topic = wp_get_post_terms( $post->ID, 'topic' )[0];
$tags = array();


foreach( wp_get_post_tags( $post->ID ) as $tag ) {
	array_push( $tags, $tag->slug );
}
?>

<article>
	<div class="ucf-faq-list<?php UCF_FAQ_Config::add_athena_attr( $container_classes ); ?>">
		<div class="ucf-faq-topic-answer<?php UCF_FAQ_Config::add_athena_attr( $answer_classes ); ?>">
			<?php
			echo apply_filters( 'the_content', $post->post_content );

			$related_posts = UCF_FAQ_Common::get_related_faqs( $tags, "" );
			$related_faq_html = null;

			foreach( $related_posts as $post ) {
				$related_faq_html .=  UCF_FAQ_Common::display_faq( $post, $show, 'h5' );
			}

			if( $related_faq_html ) :
			?>
					<h2 class="<?php UCF_FAQ_Config::add_athena_attr( 'h4 mt-5 mb-4' ); ?>">
					<?php echo get_field( 'related-faq-title', $topic ); ?>
					</h2>
			<?php
					echo $related_faq_html;
				endif;

			?>
			<a href="<?php echo site_url() . get_field( 'faq-topic-footer-cta-url', $topic ) ?>"
				class="<?php UCF_FAQ_Config::add_athena_attr( 'btn btn-primary mt-4' ); ?>">
				<?php echo get_field( 'faq-topic-footer-cta-text', $topic ) ?>
			</a>
		</div>
	</div>
</article>

<?php get_footer(); ?>
