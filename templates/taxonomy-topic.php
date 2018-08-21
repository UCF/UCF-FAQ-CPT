<?php
get_header();
$container_classes = " container mb-5";
?>

<article>
	<div class="ucf-faq-topic-list<?php UCF_FAQ_Config::add_athena_attr( $container_classes ); ?>">
		<?php
		$topic_description = term_description();

		if ( ! empty( $topic_description ) ) {
			$topic_description_classes = " mb-4";
		?>
			<div class="ucf-faq-topic-description<?php UCF_FAQ_Config::add_athena_attr( $topic_description_classes ); ?>">
				<?php UCF_FAQ_Config::add_athena_attr( $topic_description ); ?>
			</div>
		<?php
		}

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				$question_classes = " mt-3 h5";
				$question_attrs = ' data-toggle="collapse" href="#post' . $post->ID . '"';
				$answer_classes = " mt-2 mb-4 collapse";
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
		}
		else {
			echo 'No results found.';
		}
		?>
	</div>
</article>

<?php get_footer(); ?>
