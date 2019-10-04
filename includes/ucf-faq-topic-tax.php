<?php
/**
 * Handles the registration of the FAQ Topics taxonomy
 * @author RJ Bruneel
 * @since 1.0.0
 **/

if ( ! class_exists( 'UCF_FAQ_Topic' ) ) {
	class UCF_FAQ_Topic {
		public static $text_domain = 'ucf_faq';

		public static function register_topic() {
			register_taxonomy( 'topic', array( 'faq' ), self::args() );
		}

		public static function labels() {
			return array(
				'name'                       => _x( 'Topics', 'Taxonomy General Name', self::$text_domain ),
				'singular_name'              => _x( 'Topic', 'Taxonomy Singular Name', self::$text_domain ),
				'menu_name'                  => __( 'Topics', self::$text_domain ),
				'all_items'                  => __( 'All Topics', self::$text_domain ),
				'parent_item'                => __( 'Parent Topic', self::$text_domain ),
				'parent_item_colon'          => __( 'Parent Topic:', self::$text_domain ),
				'new_item_name'              => __( 'New Topic Name', self::$text_domain ),
				'add_new_item'               => __( 'Add New Topic', self::$text_domain ),
				'edit_item'                  => __( 'Edit Topic', self::$text_domain ),
				'update_item'                => __( 'Update Topic', self::$text_domain ),
				'view_item'                  => __( 'View Topic', self::$text_domain ),
				'separate_items_with_commas' => __( 'Separate topics with commas', self::$text_domain ),
				'add_or_remove_items'        => __( 'Add or remove topics', self::$text_domain ),
				'choose_from_most_used'      => __( 'Choose from the most used', self::$text_domain ),
				'popular_items'              => __( 'Popular topics', self::$text_domain ),
				'search_items'               => __( 'Search topics', self::$text_domain ),
				'not_found'                  => __( 'Not Found', self::$text_domain ),
				'no_terms'                   => __( 'No items', self::$text_domain ),
				'items_list'                 => __( 'Topics list', self::$text_domain ),
				'items_list_navigation'      => __( 'Topics list navigation', self::$text_domain ),
			);
		}

		public static function args() {
			$args = array(
				'labels'                     => self::labels(),
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'rewrite'                    => array( 'slug' => 'faq' )
			);

			return $args;
		}

		/**
		 * Adds ACF Fields
		 * @author Jim Barnes
		 * @since 1.1.0
		 * @return void
		 */
		public static function fields() {
			// Can't add local field group, return.
			if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

			$fields = array();

			/**
			 * Add Display Settings tab
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5b9ace1a451fb',
				'label' => 'Display Settings',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'placement' => 'top',
				'endpoint' => 0,
			);

			/**
			 * Add show answers toggle
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5b85b5c65fe52',
				'label' => 'Show FAQ Answers',
				'name' => 'faq-topic-show-answers',
				'type' => 'true_false',
				'instructions' => 'If checked the FAQ answer will be visible on page load.',
				'required' => 0,
				'ui' => 0
			);

			/**
			 * Add topic image
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5b8598c5aeaa9',
				'label' => 'FAQ Topic Image',
				'name' => 'faq-topic-image',
				'type' => 'image',
				'instructions' => 'An image displayed above the topic title on the card layout using the ucf-faq-topic-list shortcode.',
				'required' => 0,
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'min_width' => 300,
				'min_height' => 300,
				'min_size' => '',
				'max_width' => 500,
				'max_height' => 500,
				'max_size' => '',
				'mime_types' => 'jpg, png',
			);

			/**
			 * Add title field
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5b9028cb19703',
				'label' => 'Related FAQ Title',
				'name' => 'related-faq-title',
				'type' => 'text',
				'instructions' => 'Title displayed above the related FAQ below topic FAQs.',
				'required' => 0,
				'default_value' => 'Related FAQs'
			);

			/**
			 * Add related faq field
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5bb370e9c4c2f',
				'label' => 'Related FAQs',
				'name' => 'related_faqs',
				'type' => 'relationship',
				'instructions' => 'The related FAQs that will be displayed as "Related FAQs" when using the [ucf-faq-list] and [ucf-faq-topic-list] shortcodes.',
				'required' => 0,
				'post_type' => array(
					0 => 'faq',
				),
				'filters' => array(
					0 => 'search',
					1 => 'taxonomy',
				),
				'return_format' => 'object',
			);

			/**
			 * Add CTA Text field
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5b90292019704',
				'label' => 'FAQ Topic Footer CTA Text',
				'name' => 'faq-topic-footer-cta-text',
				'type' => 'text',
				'instructions' => 'The text for the topic footer CTA link.',
				'required' => 0,
				'default_value' => 'View All FAQs'
			);

			/**
			 * Add CTA URL field
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5b9029c019705',
				'label' => 'FAQ Topic Footer CTA URL',
				'name' => 'faq-topic-footer-cta-url',
				'type' => 'text',
				'instructions' => 'The url for the topic footer CTA link.',
				'required' => 0,
				'default_value' => '/faq/'
			);

			/**
			 * Add sort order field
			 */
			$fields[] = array(
				'key' => 'field_5bcf50f2ba743',
				'label' => 'Topic Sort Order',
				'name' => 'topic_sort_order',
				'type' => 'number',
				'instructions' => 'Enter an order value by which this topic should be sorted when displayed in a topic list. Topics with lower sort order values will be placed at the top of the list. If a value isn\'t provided, this topic will be sorted alphabetically.',
				'required' => 0
			);

			/**
			 * Add contents tab
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5b9acdc1451f9',
				'label' => 'Frontend Topic Contents',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'placement' => 'top',
				'endpoint' => 0,
			);

			/**
			 * Add single topic view field
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5b9ace2d451fc',
				'label' => 'Single Topic View',
				'name' => 'faq-topic-view-type',
				'type' => 'select',
				'instructions' => 'Select how this Topic\'s template should be displayed on the frontend.',
				'required' => 1,
				'choices' => array(
					'default' => 'Default',
					'custom' => 'Custom Content',
				),
				'default_value' => array(
					0 => 'default',
				),
				'allow_null' => 0,
				'multiple' => 0,
				'ui' => 0,
				'ajax' => 0,
				'return_format' => 'value'
			);

			/**
			 * Add topic spotlight field
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5b90050373b29',
				'label' => 'Topic Spotlight',
				'name' => 'faq-topic-spotlight',
				'type' => 'post_object',
				'instructions' => 'Select a Spotlight to be displayed on the topic list page.',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5b9ace2d451fc',
							'operator' => '==',
							'value' => 'default',
						),
					),
				),
				'post_type' => array(
					0 => 'ucf_spotlight',
				),
				'allow_null' => 0,
				'multiple' => 0,
				'return_format' => 'object',
				'ui' => 1,
			);

			/**
			 * Add custom content field
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$fields[] = array(
				'key' => 'field_5b9ad0b9451fd',
				'label' => 'Topic Custom Content',
				'name' => 'faq-topic-custom-content',
				'type' => 'wysiwyg',
				'instructions' => 'Custom content to use on the single Topic view, in lieu of the template provided by the UCF FAQ Plugin.	You will need to include FAQ lists yourself using the <code>[ucf-faq-list]</code> shortcode.',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5b9ace2d451fc',
							'operator' => '==',
							'value' => 'custom',
						),
					),
				),
				'default_value' => '',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
				'delay' => 0,
			);

			/**
			 * Define field group
			 * @author Jim Barnes
			 * @since 1.1.0
			 */
			$field_group = array(
				'key' => 'group_5b8598adb88f3',
				'title' => 'Topic Fields',
				'fields' => $fields,
				'location' => array(
					array(
						array(
							'param' => 'taxonomy',
							'operator' => '==',
							'value' => 'topic',
						),
					),
				),
				'menu_order' => -1,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true
			);

			acf_add_local_field_group( $field_group );
		}
	}
}
?>
