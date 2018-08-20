<?php get_header(); ?>

<article>
	<div class="container mb-5 ucf-faq-topic-list">
		<?php
		$topic_description = term_description();
		if ( ! empty( $topic_description ) ) {
			echo '<div class="ucf-faq-topic-description mb-4">' . $topic_description . '</div>';
		}

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
			?>
				<a href="<?php echo get_permalink( $post->ID ); ?>">
					<h2 class="ucf-faq-question mt-3 h5" data-toggle="collapse" href="#post<?php echo $post->ID; ?>">
						<?php the_title(); ?>
					</h2>
				</a>
				<div class="ucf-faq-topic-answer mt-2 mb-4 collapse" id="post<?php echo $post->ID; ?>">
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
