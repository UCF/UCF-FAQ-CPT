<?php get_header(); ?>

<article>
	<div class="container my-5 ucf-faq-list">
		<h1 class="ucf-faq-title mb-4">Frequently Asked Questions</h1>
		<?php
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
