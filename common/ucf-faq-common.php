<?php
/**
 * General-purpose functions related to FAQs.
 * @since 1.0.0
 */
if ( ! class_exists( 'UCF_FAQ_Common' ) ) {
	class UCF_FAQ_Common {
		/**
		 * Initiates the global variable used to store
		 * which FAQs are on the page
		 * @author Jim Barnes
		 * @since 2.2.0
		 * @return void
		 */
		public static function init_global_variable() {
			global $ucf_faq_cpt_faqs;
			if ( ! $ucf_faq_cpt_faqs ) $ucf_faq_cpt_faqs = array();
		}

		/**
		 * Method to output the faq question and answer HTML.
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function display_faq( $post, $atts, $unique_id ) {
			ob_start();

			$collapsed_class = ( $atts['show'] === 'true' ) ? '' : 'collapsed';
			$expanded_value  = ( $atts['show'] === 'true' ) ? 'true' : 'false';

			$atts['question_element'] = ( isset( $atts['question_element'] ) ) ? $atts['question_element'] : 'strong';
			$atts['question_class']   = ( isset( $atts['question_class'] ) ) ? $atts['question_class'] : 'h5';
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
					<div class="<?php UCF_FAQ_Config::add_athena_attr( 'card text-secondary' ); ?>">
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
		 * Registers frontend static assets for the plugin.
		 *
		 * @since 1.3.1
		 * @author Jo Dickson
		 * @return void
		 */
		public static function register_assets() {
			$plugin_data   = get_plugin_data( UCF_FAQ__PLUGIN_FILE, false, false );
			$version       = $plugin_data['Version'];

			$include_athena_classes = UCF_FAQ_Config::get_option_or_default( 'include_athena_classes' );
			if ( $include_athena_classes ) {
				$css_deps = apply_filters( 'ucf_faq_style_deps', array() );
				wp_register_style( 'ucf_faq_css', UCF_FAQ__STYLES_URL . '/ucf-faq.min.css', $css_deps, $version, 'screen' );
			}

			$enqueue_typeahead  = UCF_FAQ_Config::get_option_or_default( 'enqueue_typeahead_js' );
			$typeahead_handle   = UCF_FAQ_Config::get_option_or_default( 'typeahead_script_handle' );
			$enqueue_handlebars = UCF_FAQ_Config::get_option_or_default( 'enqueue_handlebars_js' );
			$handlebars_handle  = UCF_FAQ_Config::get_option_or_default( 'handlebars_script_handle' );
			$limit              = UCF_FAQ_Config::get_option_or_default( 'typeahead_result_limit' );

			if ( $enqueue_typeahead ) {
				wp_register_script( $typeahead_handle, UCF_FAQ__TYPEAHEAD, array( 'jquery' ), null, true );
			}
			if ( $enqueue_handlebars ) {
				wp_register_script( $handlebars_handle, UCF_FAQ__HANDLEBARS, null, null, true );
			}

			$dependencies = array(
				$typeahead_handle,
				$handlebars_handle
			);

			// Register the FAQ search script (to be enqueued late)
			wp_register_script( 'ucf_faq_search', UCF_FAQ__SCRIPT_URL . '/ucf-faq-search.min.js', $dependencies, $version, true );

			$localization = array(
				'remote_path' => get_rest_url( null, '/wp/v2/faq/' ),
				'empty'       => UCF_FAQ_Search_Templates::empty(),
				'suggestion'  => UCF_FAQ_Search_Templates::suggestion(),
				'footer'      => UCF_FAQ_Search_Templates::footer(),
				'limit'       => $limit,
			);

			wp_localize_script( 'ucf_faq_search', 'UCF_FAQ_SEARCH', $localization );
		}

		/**
		 * Enqueues general frontend styles for the plugin.
		 *
		 * @since 1.3.1
		 * @author Jo Dickson
		 * @return void
		 */
		public static function enqueue_styles() {
			if ( wp_style_is( 'ucf_faq_css', 'registered' ) ) {
				wp_enqueue_style( 'ucf_faq_css' );
			}
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

		/**
		 * Takes a series of FAQ items and generates
		 * the appropriate JSON+LD structured date
		 * @author Jim Barnes
		 * @since 2.1.0
		 * @param array $items The array of FAQ Items
		 * @return string
		 */
		public static function generate_json_ld( $items ) {
			$retval = array(
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => array()
			);

			foreach( $items as $item ) {
				$qa_pair = array(
					'@type'          => 'Question',
					'name'           => strip_tags( $item->post_title ),
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => strip_tags( $item->post_content )
					)
				);

				$retval['mainEntity'][] = $qa_pair;
			}

			return json_encode( $retval );
		}

		public static function add_json_ld() {
			$generate = UCF_FAQ_Config::get_option_or_default( 'add_json_data' );
			if ( ! $generate ) return;

			global $ucf_faq_cpt_faqs;
			if ( ! $ucf_faq_cpt_faqs || empty( $ucf_faq_cpt_faqs ) ) return;

			?>
			<script type="application/ld+json">
				<?php echo UCF_FAQ_Common::generate_json_ld( $ucf_faq_cpt_faqs ); ?>
			</script>
			<?php
		}
	}

	add_action( 'wp_enqueue_scripts', array( 'UCF_FAQ_Common', 'register_assets' ) );
	add_action( 'wp_enqueue_scripts', array( 'UCF_FAQ_Common', 'enqueue_styles' ) );
	add_action( 'wp_footer', array( 'UCF_FAQ_Common', 'add_json_ld' ), 10 );
}
