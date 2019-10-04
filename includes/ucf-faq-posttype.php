<?php
/**
 * Handles the registration of the FAQ custom post type.
 * @author Jim Barnes
 * @since 1.0.0
 **/
if ( ! class_exists( 'UCF_FAQ_PostType' ) ) {
	class UCF_FAQ_PostType {
		public static $text_domain = 'ucf_faq';

		/**
		 * Registers the FAQ custom post type.
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function register() {
			$singular = apply_filters( self::$text_domain . '_singular_label', 'FAQ' );
			$plural = apply_filters( self::$text_domain . '_plural_label', 'FAQs' );
			register_post_type( 'faq', self::args( $singular, $plural ) );

			add_action( 'acf/init', array( 'UCF_FAQ_PostType', 'fields' ), 10, 0 );
		}

		/**
		 * Returns an array of labels for the custom post type.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param $singular string | The singular form for the CPT labels.
		 * @param $plural string | The plural form for the CPT labels.
		 * @return Array
		 **/
		public static function labels( $singular, $plural ) {
			return array(
				'name'                  => _x( $plural, 'Post Type General Name', self::$text_domain ),
				'singular_name'         => _x( $singular, 'Post Type Singular Name', self::$text_domain ),
				'menu_name'             => __( $plural, self::$text_domain ),
				'name_admin_bar'        => __( $singular, self::$text_domain ),
				'archives'              => __( $plural . ' Archives', self::$text_domain ),
				'parent_item_colon'     => __( 'Parent ' . $singular . ':', self::$text_domain ),
				'all_items'             => __( 'All ' . $plural, self::$text_domain ),
				'add_new_item'          => __( 'Add New ' . $singular, self::$text_domain ),
				'add_new'               => __( 'Add New', self::$text_domain ),
				'new_item'              => __( 'New ' . $singular, self::$text_domain ),
				'edit_item'             => __( 'Edit ' . $singular, self::$text_domain ),
				'update_item'           => __( 'Update ' . $singular, self::$text_domain ),
				'view_item'             => __( 'View ' . $singular, self::$text_domain ),
				'search_items'          => __( 'Search ' . $plural, self::$text_domain ),
				'not_found'             => __( 'Not found', self::$text_domain ),
				'not_found_in_trash'    => __( 'Not found in Trash', self::$text_domain ),
				'insert_into_item'      => __( 'Insert into ' . $singular, self::$text_domain ),
				'uploaded_to_this_item' => __( 'Uploaded to this ' . $singular, self::$text_domain ),
				'items_list'            => __( $plural . ' list', self::$text_domain ),
				'items_list_navigation' => __( $plural . ' list navigation', self::$text_domain ),
				'filter_items_list'     => __( 'Filter ' . $plural . ' list', self::$text_domain ),
			);
		}

		/**
		 * Returns the arguments for registering the custom post type.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param $singular string | The singular form for the CPT labels.
		 * @param $plural string | The plural form for the CPT labels.
		 * @return Array
		 **/
		public static function args( $singular, $plural ) {
			$args = array(
				'label'                 => __( $plural, self::$text_domain ),
				'description'           => __( $plural, self::$text_domain ),
				'labels'                => self::labels( $singular, $plural, self::$text_domain ),
				'supports'              => array( 'title', 'editor', 'revisions', 'custom-fields', ),
				'taxonomies'            => self::taxonomies(),
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-admin-users',
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => true,
				'rewrite'               => array( 'slug' => 'question' ), //custom slug for single question pages
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'post',
			);

			if ( UCF_FAQ_Config::get_option_or_default( UCF_FAQ_Config::$option_prefix . 'disable_faq_archive' ) ) {
				$args['has_archive'] = false;
			}

			$args = apply_filters( self::$text_domain . '_post_type_args', $args );

			return $args;
		}

		/**
		 * Returns a list of taxonomies to add during post type registration.
		 * @author RJ Bruneel
		 * @since 1.0.0
		 * @return Array<string>
		 **/
		public static function taxonomies() {
			$retval = array();
			$taxonomies = array(
				'post_tag',
				'topic'
			);

			$taxonomies = apply_filters( self::$text_domain . '_taxonomies', $taxonomies );

			foreach ( $taxonomies as $taxonomy ) {
				if ( taxonomy_exists( $taxonomy ) ) {
					$retval[] = $taxonomy;
				}
			}

			return $retval;
		}

		/**
		 * Registers the ACF fields
		 * @author Jim Barnes
		 * @since 1.1.0
		 * @return void
		 */
		public static function fields() {
			// Can't add a local field group, return.
			if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

			$fields = array();

			$fields[] = array(
				'key' => 'field_5b917a3820356',
				'label' => 'FAQ Question Sort Order',
				'name' => 'faq_question_sort_order',
				'type' => 'number',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			);

			$field_group = array(
				'key' => 'group_5b917a2fa04ba',
				'title' => 'FAQ Question Fields',
				'fields' => $fields,
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'faq',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			);

			acf_add_local_field_group( $field_group );
		}
	}
}
