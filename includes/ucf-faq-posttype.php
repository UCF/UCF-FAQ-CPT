<?php
/**
 * Handles the registration of the FAQ custom post type.
 * @author Jim Barnes
 * @since 1.0.0
 **/
if ( ! class_exists( 'UCF_FAQ_PostType' ) ) {
	class UCF_FAQ_PostType {
		/**
		 * Registers the FAQ custom post type.
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function register() {
			$text_domain = 'ucf_faq';
			$singular = apply_filters( $text_domain . '_singular_label', 'FAQ' );
			$plural = apply_filters( $text_domain . '_plural_label', 'FAQs' );
			register_post_type( 'faq', self::args( $singular, $plural, $text_domain ) );
		}

		/**
		 * Returns an array of labels for the custom post type.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param $singular string | The singular form for the CPT labels.
		 * @param $plural string | The plural form for the CPT labels.
		 * @param $text_domain string | Text domain for CPT.
		 * @return Array
		 **/
		public static function labels( $singular, $plural, $text_domain ) {
			return array(
				'name'                  => _x( $plural, 'Post Type General Name', $text_domain ),
				'singular_name'         => _x( $singular, 'Post Type Singular Name', $text_domain ),
				'menu_name'             => __( $plural, $text_domain ),
				'name_admin_bar'        => __( $singular, $text_domain ),
				'archives'              => __( $plural . ' Archives', $text_domain ),
				'parent_item_colon'     => __( 'Parent ' . $singular . ':', $text_domain ),
				'all_items'             => __( 'All ' . $plural, $text_domain ),
				'add_new_item'          => __( 'Add New ' . $singular, $text_domain ),
				'add_new'               => __( 'Add New', $text_domain ),
				'new_item'              => __( 'New ' . $singular, $text_domain ),
				'edit_item'             => __( 'Edit ' . $singular, $text_domain ),
				'update_item'           => __( 'Update ' . $singular, $text_domain ),
				'view_item'             => __( 'View ' . $singular, $text_domain ),
				'search_items'          => __( 'Search ' . $plural, $text_domain ),
				'not_found'             => __( 'Not found', $text_domain ),
				'not_found_in_trash'    => __( 'Not found in Trash', $text_domain ),
				'insert_into_item'      => __( 'Insert into ' . $singular, $text_domain ),
				'uploaded_to_this_item' => __( 'Uploaded to this ' . $singular, $text_domain ),
				'items_list'            => __( $plural . ' list', $text_domain ),
				'items_list_navigation' => __( $plural . ' list navigation', $text_domain ),
				'filter_items_list'     => __( 'Filter ' . $plural . ' list', $text_domain ),
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
		public static function args( $singular, $plural, $text_domain ) {
			$args = array(
				'label'                 => __( $plural, $text_domain ),
				'description'           => __( $plural, $text_domain ),
				'labels'                => self::labels( $singular, $plural, $text_domain ),
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
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'post',
			);

			$args = apply_filters( $text_domain . '_post_type_args', $args );

			return $args;
		}

		/**
		 * Returns a list of taxonomies to add during post type registration.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return Array<string>
		 **/
		public static function taxonomies() {
			$taxonomies = array(
				'post_tag',
				'category'
			);

			$taxonomies = apply_filters( 'ucf_faq_taxonomies', $taxonomies );

			foreach( $taxonomies as $taxonomy ) {
				if ( ! taxonomy_exists( $taxonomy ) ) {
					unset( $taxonomies[$taxonomy] );
				}
			}

			return $taxonomies;
		}

		public static function append_metadata( $faq ) {
			$meta = get_post_meta( $faq->ID );

			// Short circuit if there is no meta
			if ( ! $meta ) return $faq;

			foreach( $meta as $key=>$value ) {
				if ( is_array( $value ) && count( $value ) === 1 ) {
					$meta[$key] = $value[0];
				}
			}

			$meta = apply_filters( 'ucf_faq_format_metadata', $meta );

			$faq->metadata = $meta;
			return $faq;
		}
	}
}
