<?php
get_header();
$container_classes = " container mb-5";
$term_object = get_term_by('slug', $term, 'topic');
$show = ( get_field( 'faq-topic-show-answers', $term_object) ) ?  " show" : "";
$topic_description = term_description();
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
				<div class="<?php UCF_FAQ_Config::add_athena_attr( 'col-8' ); ?>">
			<?php
			while ( have_posts() ) {
				the_post();
				$question_classes = " mt-3 h4";
				$question_attrs = ' data-toggle="collapse" href="#post' . $post->ID . '"';
				$answer_classes = " mt-2 mb-4 collapse" . $show;
				$answer_attrs = ' id="post' . $post->ID . '"';
			?>
				<a href="<?php echo get_permalink( $post->ID ); ?>">
					<h2 class="ucf-faq-question<?php UCF_FAQ_Config::add_athena_attr( $question_classes ); ?>"<?php UCF_FAQ_Config::add_athena_attr( $question_attrs ); ?>>
						<?php the_title(); ?>
					</h2>
				</a>
				<div class="ucf-faq-topic-answer<?php UCF_FAQ_Config::add_athena_attr( $answer_classes ); ?>"<?php UCF_FAQ_Config::add_athena_attr( $answer_attrs ); ?>>
					<?php the_content(); ?>
				</div>
			<?php
			}
			?>
				</div>
				<div class="<?php UCF_FAQ_Config::add_athena_attr( 'col-4 mt-3' ); ?>">
					<h3 class="<?php UCF_FAQ_Config::add_athena_attr( 'h5' ); ?>">TODO: Spotlight</h3>
				</div>
			</div>
			<div class="<?php UCF_FAQ_Config::add_athena_attr( 'row mt-4' ); ?>">
				<div class="<?php UCF_FAQ_Config::add_athena_attr( 'col-4' ); ?>">
					<h3 class="<?php UCF_FAQ_Config::add_athena_attr( 'h5' ); ?>">TODO: Related FAQs</h3>
					<p>List of FAQs with the same topic.</p>
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
