<?php get_header(); ?>

<article>
	<div class="container ucf-faq-category-archive">
		<?php
		$category_description = category_description();
		if ( ! empty( $category_description ) ) {
			echo '<div class="ucf-faq-category-description mb-4">' . $category_description . '</div>';
		}

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
			?>
				<h2 class="ucf-faq-category-question h5"><?php the_title(); ?></h2>
				<div class="ucf-faq-category-answer mt-2 mb-4">
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
