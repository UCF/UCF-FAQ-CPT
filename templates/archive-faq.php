<?php
get_header();
$container_classes = " container my-5";
$title_classes = " mb-4";
?>

<article>
	<div class="ucf-faq-list<?php UCF_FAQ_Config::add_athena_attr($container_classes); ?>">
		<h1 class="ucf-faq-title<?php UCF_FAQ_Config::add_athena_attr($title_classes); ?>">Frequently Asked Questions</h1>
		<?php
		if ( have_posts() ) {

			$posts = $wp_query->posts;
			$items = array();

			foreach( $posts as $post ) {
				$topics = wp_get_post_terms( $post->ID, 'topic' );

				foreach( $topics as $topic ) {
					$items[$topic->name][] = $post;
				}
			}

			foreach( $items as $key => $item ) :
				$topic_title_classes = " mt-4 mb-3";
			?>
				<h2 class="ucf-faq-topic<?php UCF_FAQ_Config::add_athena_attr($topic_title_classes); ?>"><?php echo $key; ?></h2>
			<?php
				foreach( $item as $post ) :
					$question_classes = " mt-3 h5";
					$question_attrs = ' data-toggle="collapse" href="#post' . $post->ID . '"';
					$answer_classes = " mt-2 mb-4 collapse";
					$answer_attrs = ' id="post' . $post->ID . '"';
			?>
					<a href="<?php echo get_permalink( $post->ID ); ?>">
						<h3 class="ucf-faq-question<?php UCF_FAQ_Config::add_athena_attr($question_classes); ?>"<?php UCF_FAQ_Config::add_athena_attr($question_attrs); ?>>
							<?php echo $post->post_title; ?>
						</h3>
					</a>
					<div class="ucf-faq-topic-answer<?php UCF_FAQ_Config::add_athena_attr($answer_classes); ?>"<?php UCF_FAQ_Config::add_athena_attr($answer_attrs); ?>>
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
