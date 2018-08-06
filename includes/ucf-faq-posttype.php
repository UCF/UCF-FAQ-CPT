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
			$singular = apply_filters( 'ucf_faq_singular_label', 'FAQ' );
			$plural = apply_filters( 'ucf_faq_plural_label', 'FAQs' );
			register_post_type( 'faq', self::args( $singular, $plural ) );
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
				'name'                  => _x( $plural, 'Post Type General Name', 'ucf_faq' ),
				'singular_name'         => _x( $singular, 'Post Type Singular Name', 'ucf_faq' ),
				'menu_name'             => __( $plural, 'ucf_faq' ),
				'name_admin_bar'        => __( $singular, 'ucf_faq' ),
				'archives'              => __( $plural . ' Archives', 'ucf_faq' ),
				'parent_item_colon'     => __( 'Parent ' . $singular . ':', 'ucf_faq' ),
				'all_items'             => __( 'All ' . $plural, 'ucf_faq' ),
				'add_new_item'          => __( 'Add New ' . $singular, 'ucf_faq' ),
				'add_new'               => __( 'Add New', 'ucf_faq' ),
				'new_item'              => __( 'New ' . $singular, 'ucf_faq' ),
				'edit_item'             => __( 'Edit ' . $singular, 'ucf_faq' ),
				'update_item'           => __( 'Update ' . $singular, 'ucf_faq' ),
				'view_item'             => __( 'View ' . $singular, 'ucf_faq' ),
				'search_items'          => __( 'Search ' . $plural, 'ucf_faq' ),
				'not_found'             => __( 'Not found', 'ucf_faq' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'ucf_faq' ),
				'insert_into_item'      => __( 'Insert into ' . $singular, 'ucf_faq' ),
				'uploaded_to_this_item' => __( 'Uploaded to this ' . $singular, 'ucf_faq' ),
				'items_list'            => __( $plural . ' list', 'ucf_faq' ),
				'items_list_navigation' => __( $plural . ' list navigation', 'ucf_faq' ),
				'filter_items_list'     => __( 'Filter ' . $plural . ' list', 'ucf_faq' ),
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
				'label'                 => __( $plural, 'ucf_faq' ),
				'description'           => __( $plural, 'ucf_faq' ),
				'labels'                => self::labels( $singular, $plural ),
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

			$args = apply_filters( 'ucf_faq_post_type_args', $args );

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
