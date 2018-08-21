<?php get_header(); ?>

<article>
	<div class="<?php if( get_option( 'ucf_faq_include_athena_classes' ) ) echo "container my-5 "; ?>ucf-faq-list">
		<h1 class="ucf-faq-title<?php if( get_option( 'ucf_faq_include_athena_classes' ) ) echo " mb-4"; ?>">Frequently Asked Questions</h1>
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
				$title_classes = ( get_option( 'ucf_faq_include_athena_classes' ) ) ? " mt-4 mb-3" : "";
			?>
				<h2 class="ucf-faq-topic<?php echo $title_classes; ?>"><?php echo $key; ?></h2>
			<?php
				foreach( $item as $post ) :
					$question_classes = "";
					$question_attrs = "";
					$answer_classes = "";
					$answer_attrs = "";

					if ( get_option( 'ucf_faq_include_athena_classes' ) ) {
						$question_classes = " mt-3 h5";
						$question_attrs = ' data-toggle="collapse" href="#post' . $post->ID . '"';
						$answer_classes = " mt-2 mb-4 collapse";
						$answer_attrs = ' id="post' . $post->ID . '"';
					}
			?>
					<a href="<?php echo get_permalink( $post->ID ); ?>">
						<h3 class="ucf-faq-question<?php echo $question_classes; ?>"<?php echo $question_attrs; ?>>
							<?php echo $post->post_title; ?>
						</h3>
					</a>
					<div class="ucf-faq-topic-answer<?php echo $answer_classes; ?>"<?php echo $answer_attrs; ?>>
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
