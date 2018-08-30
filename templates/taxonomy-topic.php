<?php
get_header();

$tags = array();
$faqs = array();
$container_classes = " container mb-5";
$show = ( get_field( 'faq-topic-show-answers', get_queried_object() ) ) ?  " show" : "";
$topic_description = term_description();


function display_faq( $post, $show, $question_class ) {
	ob_start();

	$question_classes = " mt-3 " . $question_class;
	$question_attrs   = ' data-toggle="collapse" href="#post' . $post->ID . '"';
	$answer_classes   = " mt-2 mb-4 collapse" . $show;
	$answer_attrs     = ' id="post' . $post->ID . '"';
?>
	<a href="<?php echo get_permalink( $post->ID ); ?>">
		<h2 class="ucf-faq-question<?php UCF_FAQ_Config::add_athena_attr( $question_classes ); ?>"<?php UCF_FAQ_Config::add_athena_attr( $question_attrs ); ?>>
			<?php echo $post->post_title; ?>
		</h2>
	</a>

	<div class="ucf-faq-topic-answer<?php UCF_FAQ_Config::add_athena_attr( $answer_classes ); ?>"<?php UCF_FAQ_Config::add_athena_attr( $answer_attrs ); ?>>
		<?php echo $post->post_content; ?>
	</div>
<?php
	return ob_get_clean();
}
?>


<article>
	<div class="ucf-faq-topic-list<?php UCF_FAQ_Config::add_athena_attr( $container_classes ); ?>">
		<?php

		if ( ! empty( $topic_description ) ) {
			$topic_description_classes = " mb-4";
		?>
			<div class="ucf-faq-topic-description<?php UCF_FAQ_Config::add_athena_attr( $topic_description_classes ); ?>">
				<?php UCF_FAQ_Config::add_athena_attr( $topic_description ); ?>
			</div>
		<?php
		}

		if ( have_posts() ) {
			?>
			<div class="<?php UCF_FAQ_Config::add_athena_attr( 'row' ); ?>">
				<div class="<?php UCF_FAQ_Config::add_athena_attr( 'col-md-8' ); ?>">
			<?php
				while ( have_posts() ) {
					the_post();

					// Save FAQs and tags for related FAQs section
					array_push( $faqs, $post );

					foreach( wp_get_post_tags( $post->ID ) as $tag ) {
						if( !in_array( $tag, $tags ) ) {
							array_push( $tags, $tag->slug );
						}
					}

					echo display_faq( $post, $show, 'h4' );
				}

				// Get posts with same tags to display in related FAQs section
				$args = array(
					'post_type'      => 'faq',
					'posts_per_page' => -1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'post_tag',
							'field'    => 'slug',
							'terms'    => $tags,
						),
					),
				);

				$posts = get_posts( $args );
				$related_faqs = null;

				foreach( $posts as $post ) {
					if( !in_array( $post, $faqs ) ) { // Don't display FAQs already on the page
						$related_faqs .=  display_faq( $post, $show, 'h5' );
					}
				}

				if( $related_faqs ) {
				?>
					<h2 class="<?php UCF_FAQ_Config::add_athena_attr( 'h3 mt-5 mb-4' ); ?>">Related FAQs</h3>
				<?php
					echo $related_faqs;
				}

			?>
				</div>

				<div class="<?php UCF_FAQ_Config::add_athena_attr( 'col-md-4 mt-3' ); ?>">
					<h2 class="<?php UCF_FAQ_Config::add_athena_attr( 'h5' ); ?>">TODO: Spotlight</h3>
				</div>
			</div>
			<?php
		}
		else {
			echo 'No results found.';
		}
		?>
	</div>
</article>

<?php get_footer(); ?>
