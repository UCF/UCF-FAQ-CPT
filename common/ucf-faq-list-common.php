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
		public static function display_faq( $post, $atts, $unique_id ) {
			ob_start();

			$atts['question_element'] = ( isset( $atts['question_element'] ) ) ? $atts['question_element'] : 'h3';
			$atts['question_class'] = ( isset( $atts['question_class'] ) ) ? $atts['question_class'] : ' h5';

			$question_attrs   = ' data-toggle="collapse" href="#post' . $post->ID . $unique_id .'"';
			$answer_classes   = " collapse" . $atts['show'];
			$answer_attrs     = ' id="post' . $post->ID . $unique_id . '"';
		?>
			<a href="<?php echo get_permalink( $post->ID ); ?>" class="<?php UCF_FAQ_Config::add_athena_attr( 'd-block pt-3' ); ?>">
				<<?php echo $atts['question_element']; ?> class="ucf-faq-question <?php UCF_FAQ_Config::add_athena_attr( $atts['question_class'] ); ?>"<?php UCF_FAQ_Config::add_athena_attr( $question_attrs ); ?>>
					<?php echo $post->post_title; ?>
				</<?php echo $atts['question_element']; ?>>
			</a>

			<div class="ucf-faq-topic-answer<?php UCF_FAQ_Config::add_athena_attr( $answer_classes ); ?>"<?php UCF_FAQ_Config::add_athena_attr( $answer_attrs ); ?>>
				<?php echo apply_filters( 'the_content', $post->post_content ); ?>
			</div>
		<?php
			return ob_get_clean();
		}


		/**
		 * Method to output the related faq question and answers with title.
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function display_related_faqs( $posts, $title, $atts ) {
			$retval = "";

			ob_start();

			if ( $posts ) :

			?>
				<h2 class="<?php UCF_FAQ_Config::add_athena_attr( 'h4 pt-4' ); ?>">
					<?php echo $title; ?>
				</h2>
			<?php
				$unique_id = wp_rand();

				foreach ( $posts as $post ) {
					echo UCF_FAQ_Common::display_faq( $post, $atts, $unique_id );
				}

			endif;

			$retval = ob_get_clean();

			return $retval;
		}



		/**
		 * Method to output the footer CTA.
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function display_footer_cta( $cta_text, $cta_url ) {
			$retval = "";

			if ( substr( $cta_url, 0, 1 ) === '/' ) {
				$cta_url = site_url() . $cta_url;
			}

			ob_start();

			if ( $cta_text && $cta_url ) :
			?>
				<a href="<?php echo $cta_url; ?>" class="<?php UCF_FAQ_Config::add_athena_attr( 'btn btn-primary mt-4' ); ?>"><?php echo $cta_text; ?></a>
			<?php
			endif;

			$retval = ob_get_clean();

			return $retval;
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
				'orderby'        => array(
					'meta_value' => 'ASC',
					'title'      => 'ASC'
				),
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'key'     => 'faq_question_sort_order',
						'compare' => 'EXISTS',
					),
					array(
						'key'     => 'faq_question_sort_order',
						'compare' => 'NOT EXISTS'
					)
				),
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
