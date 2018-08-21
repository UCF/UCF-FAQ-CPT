<?php
get_header();
$title_classes = ( get_option( 'ucf_faq_include_athena_classes' ) ) ? " container mb-5" : "";
?>

<article>
	<div class="ucf-faq-topic-list<?php echo $title_classes; ?>">
		<?php
		$topic_description = term_description();

		if ( ! empty( $topic_description ) ) {
			$topic_description_classes = "";

			if( get_option( 'ucf_faq_include_athena_classes' ) ) {
				$topic_description_classes = " mb-4";
			}

			echo '<div class="ucf-faq-topic-description'. $topic_description_classes . '">' . $topic_description . '</div>';
		}

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				$question_classes = "";
				$question_attrs = "";
				$answer_classes = "";
				$answer_attrs = "";

				if( get_option( 'ucf_faq_include_athena_classes' ) ) {
					$question_classes = " mt-3 h5";
					$question_attrs = ' data-toggle="collapse" href="#post' . $post->ID . '"';
					$answer_classes = " mt-2 mb-4 collapse";
					$answer_attrs = ' id="post' . $post->ID . '"';
				}
			?>
				<a href="<?php echo get_permalink( $post->ID ); ?>">
					<h2 class="ucf-faq-question<?php echo $question_classes; ?>"<?php echo $question_attrs; ?>>
						<?php the_title(); ?>
					</h2>
				</a>
				<div class="ucf-faq-topic-answer<?php echo $answer_classes; ?>"<?php echo $answer_attrs; ?>>
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
