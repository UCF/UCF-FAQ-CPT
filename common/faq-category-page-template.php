<?php get_header(); ?>

<article>
	<div class="container">
		<?php
		$category_id = get_queried_object()->term_id;

		$category_description = category_description();
		if ( ! empty( $category_description ) ) {
			echo '<div class="ucf-faq-category-description mb-4">' . $category_description . '</div>';
		}
		?>
		<?php

		$args = array(
			'post_type'      => 'faq',
			'category'       => $category_id,
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC'
		);

		$posts = get_posts( $args );

		foreach ( $posts as $post) : ?>

			<h2 class="ucf-faq-category-question h5"><?php echo $post->post_title; ?></h2>
			<div class="ucf-faq-category-answer mt-2 mb-4">
				<?php echo $post->post_content; ?>
			</div>

		<?php endforeach; ?>
	</div>
</article>

<?php get_footer(); ?>
