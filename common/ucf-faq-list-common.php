<?php
/**
 * Defines hooks for displaying a list of FAQs.
 * @author RJ Bruneel
 * @since 1.0.0
 **/
if ( ! class_exists( 'UCF_FAQ_List_Common' ) ) {
	class UCF_FAQ_List_Common {
		public static function display_faqs( $items, $layout, $args ) {
			ob_start();
			// Display before
			$layout_before = ucf_faq_list_display_classic_before( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_faq_list_display_' . $layout . '_before', $layout_before, $items, $args );
			}
			echo $layout_before;
			// Display title
			$layout_title = ucf_faq_list_display_classic_title( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout . '_title' ) ) {
				$layout_title = apply_filters( 'ucf_faq_list_display_' . $layout . '_title', $layout_title, $items, $args );
			}
			echo $layout_title;

			$layout_content = ucf_faq_list_display_classic( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_faq_list_display_' . $layout, $layout_content, $items, $args );
			}
			echo $layout_content;

			// Display after
			$layout_after = ucf_faq_list_display_classic_after( '', $items, $args );
			if ( has_filter( 'ucf_faq_list_display_' . $layout . '_after' ) ) {
				$layout_after = apply_filters( 'ucf_faq_list_display_' . $layout . '_after', $layout_after, $items, $args );
			}
			echo $layout_after;
			return ob_get_clean();
		}
	}
}


/**
 * Defines hooks for displaying a list of FAQ topics.
 * @author RJ Bruneel
 * @since 1.0.0
 **/
if ( ! class_exists( 'UCF_FAQ_Topic_List_Common' ) ) {
	class UCF_FAQ_Topic_List_Common {
		public static function display_faq_topics( $items, $layout, $args ) {
			ob_start();
			// Display before
			$layout_before = ucf_faq_topic_list_display_classic_before( '', $items, $args );
			if ( has_filter( 'ucf_faq_topic_list_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_faq_topic_list_display_' . $layout . '_before', $layout_before, $items, $args );
			}
			echo $layout_before;
			// Display title
			$layout_title = ucf_faq_topic_list_display_classic_title( '', $items, $args );
			if ( has_filter( 'ucf_faq_topic_list_display_' . $layout . '_title' ) ) {
				$layout_title = apply_filters( 'ucf_faq_topic_list_display_' . $layout . '_title', $layout_title, $items, $args );
			}
			echo $layout_title;

			$layout_content = ucf_faq_topic_list_display_classic( '', $items, $args );
			if ( has_filter( 'ucf_faq_topic_list_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_faq_topic_list_display_' . $layout, $layout_content, $items, $args );
			}
			echo $layout_content;

			// Display after
			$layout_after = ucf_faq_topic_list_display_classic_after( '', $items, $args );
			if ( has_filter( 'ucf_faq_topic_list_display_' . $layout . '_after' ) ) {
				$layout_after = apply_filters( 'ucf_faq_topic_list_display_' . $layout . '_after', $layout_after, $items, $args );
			}
			echo $layout_after;
			return ob_get_clean();
		}
	}
}


if ( ! class_exists( 'UCF_FAQ_Common' ) ) {
	class UCF_FAQ_Common {
		/**
		 * Method to output the faq question and answer HTML.
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function display_faq( $post, $show, $question_class ) {
			ob_start();

			$question_classes = " mt-4 " . $question_class;
			$question_attrs   = ' data-toggle="collapse" href="#post' . $post->ID . '"';
			$answer_classes   = " mt-2 mb-4 collapse" . $show;
			$answer_attrs     = ' id="post' . $post->ID . '"';
		?>
			<a href="<?php echo get_permalink( $post->ID ); ?>">
				<h2 class="ucf-faq-question<?php UCF_FAQ_Config::add_athena_attr( $question_classes ); ?>"<?php UCF_FAQ_Config::add_athena_attr( $question_attrs ); ?>>
					<?php echo $post->post_title; ?>
				</h2>
			</a>

			<div class="ucf-faq-topic-answer<?php UCF_FAQ_Config::add_athena_attr( $answer_classes ); ?>"<?php UCF_FAQ_Config::add_athena_attr( $answer_attrs ); ?>>
				<?php echo apply_filters( 'the_content', $post->post_content ); ?>
			</div>
		<?php
			return ob_get_clean();
		}


		/**
		 * Get related FAQs by tag excluding faqs already on the page.
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function get_related_faqs( $tags, $faqs ) {
			$args = array(
				'post_type'      => 'faq',
				'posts_per_page' => -1,
				'post__not_in'   => $faqs,
				'tax_query'      => array(
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'slug',
						'terms'    => $tags,
					),
				),
			);

			return get_posts( $args );
		}

	}
}
