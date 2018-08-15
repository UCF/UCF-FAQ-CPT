<?php get_header(); ?>

<article>
	<div class="container ucf-faq-topic-archive">
		<?php
		$topic_description = topic_description();
		if ( ! empty( $topic_description ) ) {
			echo '<div class="ucf-faq-topic-description mb-4">' . $topic_description . '</div>';
		}

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
			?>
				<h2 class="ucf-faq-topic-question h5"><?php the_title(); ?></h2>
				<div class="ucf-faq-topic-answer mt-2 mb-4">
					<?php echo the_content(); ?>
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
