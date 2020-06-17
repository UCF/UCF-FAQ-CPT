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

			$collapsed_class = ( $atts['show'] === 'true' ) ? '' : 'collapsed';
			$expanded_value  = ( $atts['show'] === 'true' ) ? 'true' : 'false';

			$atts['question_element'] = ( isset( $atts['question_element'] ) ) ? $atts['question_element'] : 'h3';
			$atts['question_class']   = ( isset( $atts['question_class'] ) ) ? $atts['question_class'] : '';
			$atts['show']             = ( $atts['show'] === 'true' ) ? ' show' : '';

			$question_attrs   = ' data-toggle="collapse" data-target="#post' . $post->ID . $unique_id .'" aria-expanded="' . $expanded_value . '"';
			$answer_classes   = ' collapse' . $atts['show'];
			$answer_attrs     = ' id="post' . $post->ID . $unique_id . '"';
		?>
			<div class="<?php UCF_FAQ_Config::add_athena_attr( 'd-flex mb-4 flex-column' ); ?>"<?php echo UCF_FAQ_Common::add_microdata( 'wrapper' ); ?>>
				<a href="<?php echo get_permalink( $post->ID ); ?>" class="ucf-faq-question-link <?php UCF_FAQ_Config::add_athena_attr( $collapsed_class ); ?> <?php UCF_FAQ_Config::add_athena_attr( 'd-flex' ); ?>" <?php UCF_FAQ_Config::add_athena_attr( $question_attrs ); ?>>
					<div class="ucf-faq-collapse-icon-container <?php UCF_FAQ_Config::add_athena_attr( 'mr-2 mr-md-3' ); ?>">
						<span class="ucf-faq-collapse-icon" aria-hidden="true"></span>
					</div>
					<<?php echo $atts['question_element']; ?> class="ucf-faq-question <?php UCF_FAQ_Config::add_athena_attr( 'align-self-center mb-0 ' . $atts['question_class'] ); ?>"<?php echo UCF_FAQ_Common::add_microdata( 'question' ); ?>>
						<?php echo $post->post_title; ?>
					</<?php echo $atts['question_element']; ?>>
				</a>
				<div class="ucf-faq-topic-answer<?php UCF_FAQ_Config::add_athena_attr( $answer_classes . ' ml-2 ml-md-3 mt-2' ); ?>"<?php UCF_FAQ_Config::add_athena_attr( $answer_attrs ); ?><?php echo UCF_FAQ_Common::add_microdata( 'answer_wrapper' ); ?>>
					<div class="<?php UCF_FAQ_Config::add_athena_attr( 'card' ); ?>">
						<div class="<?php UCF_FAQ_Config::add_athena_attr( 'card-block' ); ?>"<?php echo UCF_FAQ_Common::add_microdata( 'answer_text' ); ?>>
							<?php echo apply_filters( 'the_content', $post->post_content ); ?>
						</div>
					</div>
				</div>
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
				<hr class="<?php UCF_FAQ_Config::add_athena_attr( 'my-5' ); ?>">
				<h2 class="<?php UCF_FAQ_Config::add_athena_attr( 'h4 mb-4 heading-underline' ); ?>">
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
		 * Get related FAQs by topic excluding faqs already on the page.
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function get_related_faqs_by_topic( $topics, $excluded_faqs ) {
			if ( empty( $topics ) || ! is_array( $topics ) ) {
				return array();
			}

			$retval = array();

			foreach( $topics as $topic ) {
				$related = get_field( 'related_faqs', "topic_{$topic->term_id}" );
				if( $related && is_array( $related ) ) {
					$retval = array_merge( $retval, $related );
				}
			}

			$retval = array_filter( $retval, function( $faq ) use( $excluded_faqs ) {
				if ( in_array( $faq->ID, $excluded_faqs ) ) {
					return false;
				}

				return true;
			} );

			return $retval;
		}

		/**
		 * Get related FAQs by tag excluding faqs already on the page.
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function get_related_faqs_by_tag( $tags, $excluded_faqs ) {
			if ( empty( $tags ) || ! is_array( $tags ) ) {
				return array();
			}

			$args = array(
				'post_type'      => 'faq',
				'posts_per_page' => -1,
				'post__not_in'   => $excluded_faqs,
				'orderby'        => array(
					'meta_value_num' => 'ASC',
					'title'          => 'ASC'
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

		/**
		 * Utility function to sort terms.
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function sort_terms( $a, $b ) {
			// this function expects that items to be sorted are objects and
			// that the property to sort by is $object->sort_order
			if ( $a->sort_order == $b->sort_order ) {
			  return 0;
			} elseif ( $a->sort_order < $b->sort_order ) {
			  return -1;
			} else {
			  return 1;
			}
		}

		/**
		 * Enqueues the stastic assets
		 * @author Cadie Brown
		 * @since 1.0.0
		 */
		public static function enqueue_assets() {
			// CSS
			$include_athena_classes = UCF_FAQ_Config::get_option_or_default( 'include_athena_classes' );
			$css_deps = apply_filters( 'ucf_faq_style_deps', array() );
			if ( $include_athena_classes ) {
				$plugin_data   = get_plugin_data( UCF_FAQ__PLUGIN_FILE, false, false );
				$version       = $plugin_data['Version'];
				wp_enqueue_style( 'ucf_faq_css', plugins_url( 'static/css/ucf-faq.min.css', UCF_FAQ__PLUGIN_FILE ), $css_deps, $version, 'screen' );
			}

			$enqueue_typeahead  = UCF_FAQ_Config::get_option_or_default( 'enqueue_typeahead' );
			$typeahead_handle   = UCF_FAQ_Config::get_option_or_default( 'typeahead_handle' );
			$enqueue_handlebars = UCF_FAQ_Config::get_option_or_default( 'enqueue_handlebars' );
			$handlebars_handle  = UCF_FAQ_Config::get_option_or_default( 'handlebars_handle' );
			$limit              = UCF_FAQ_Config::get_option_or_default( 'typeahead_result_limit' );

			if ( $enqueue_typeahead ) {
				wp_enqueue_script( $typeahead_handle, 'https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.3.1/typeahead.bundle.min.js', array( 'jquery' ), null, true );
			}

			if ( $enqueue_handlebars ) {
				wp_enqueue_script( $handlebars_handle, 'https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js', null, null, true );
			}

			$dependencies = array(
				$typeahead_handle,
				$handlebars_handle
			);

			// Enqueue the plugin script
			wp_register_script( 'ucf_faq_script', plugins_url( 'static/js/ucf-faq-script.min.js', UCF_FAQ__PLUGIN_FILE ), $dependencies, $version, true );

			$localization = array(
				'remote_path' => get_rest_url( null, '/wp/v2/faq/' ),
				'empty'       => UCF_FAQ_Search_Templates::empty(),
				'suggestion'  => UCF_FAQ_Search_Templates::suggestion(),
				'footer'      => UCF_FAQ_Search_Templates::footer(),
				'limit'       => $limit,
			);

			wp_localize_script( 'ucf_faq_script', 'UCF_FAQ_SEARCH', $localization );

			wp_enqueue_script( 'ucf_faq_script' );
		}

		/**
		 * Adds the microdata markup
		 * @author Jim Barnes
		 * @since 1.1.6
		 * @param string $element The element flag so the function knows how to mark it up
		 * @return string
		 */
		public static function add_microdata( $element ) {
			if ( ! UCF_FAQ_Config::get_option_or_default( 'add_microdata' ) ) return '';

			switch( $element ) {
				case 'wrapper':
					return ' itemscope itemprop="mainEntity" itemtype="https://schema.org/Question"';
				case 'question':
					return ' itemprop="name"';
				case 'answer_wrapper':
					return ' itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"';
				case 'answer_text':
					return ' itemprop="text"';
				default:
					return '';
			}
		}
	}

	add_action( 'wp_enqueue_scripts', array( 'UCF_FAQ_Common', 'enqueue_assets' ) );
}
