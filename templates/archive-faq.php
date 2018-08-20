<?php get_header(); ?>

<article>
	<div class="container my-5 ucf-faq-list">
		<h1 class="ucf-faq-title mb-4">Frequently Asked Questions</h1>
		<?php
		if ( have_posts() ) {

			$args = array(
				'post_type'      => 'faq',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC'
			);

			$posts = get_posts( $args );
			$items = array();

			foreach( $posts as $post ) {
				$topics = wp_get_post_terms( $post->ID, 'topic' );

				foreach( $topics as $topic ) {
					$items[$topic->name][] = $post;
				}
			}

			foreach( $items as $key => $item ) :
			?>
				<h2 class="ucf-faq-topic mt-4 mb-3"><?php echo $key; ?></h2>
			<?php
				foreach( $item as $post ) :

					$unique_id = wp_rand();
			?>
					<a href="<?php echo get_permalink( $post->ID ); ?>">
						<h3 class="ucf-faq-question mt-3 h5" data-toggle="collapse" href="#post<?php echo $post->ID . $unique_id; ?>">
							<?php echo $post->post_title; ?>
						</h3>
					</a>
					<div class="ucf-faq-topic-answer mt-2 mb-4 collapse" id="post<?php echo $post->ID . $unique_id; ?>">
						<?php echo $post->post_content; ?>
					</div>
			<?php
				endforeach;
			endforeach;
		}
		else {
			echo 'No results found.';
		}
		?>
	</div>
</article>

<?php get_footer(); ?>
