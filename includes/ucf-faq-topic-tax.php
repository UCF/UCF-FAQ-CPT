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
				'hierarchical'               => false,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_tagcloud'              => true,
				'rewrite'                    => array( 'slug' => 'faq' )
			);

			if ( UCF_FAQ_Config::get_option_or_default( UCF_FAQ_Config::$option_prefix . 'disable_frontend_topics' ) ) {
				$args['public'] = false;
			}

			return $args;
		}
	}
}
?>
