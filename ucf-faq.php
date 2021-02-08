<?php
/*
Plugin Name: UCF FAQ Custom Post Type
Description: Provides a FAQ custom post type and related meta fields.
Version: 2.0.0
Author: UCF Web Communications
License: GPL3
Github Plugin URI: UCF/UCF-FAQ-CPT
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'UCF_FAQ__PLUGIN_URL', plugins_url( basename( dirname( __FILE__ ) ) ) );
define( 'UCF_FAQ__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'UCF_FAQ__STATIC_URL', UCF_FAQ__PLUGIN_URL . '/static' );
define( 'UCF_FAQ__STYLES_URL', UCF_FAQ__STATIC_URL . '/css' );
define( 'UCF_FAQ__SCRIPT_URL', UCF_FAQ__STATIC_URL . '/js' );
define( 'UCF_FAQ__PLUGIN_FILE', __FILE__ );
define( 'UCF_FAQ__TYPEAHEAD', 'https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.3.1/typeahead.bundle.min.js' );
define( 'UCF_FAQ__HANDLEBARS', 'https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js' );

require_once UCF_FAQ__PLUGIN_DIR . 'includes/ucf-faq-config.php';
include_once UCF_FAQ__PLUGIN_DIR . 'includes/ucf-faq-topic-tax.php';
include_once UCF_FAQ__PLUGIN_DIR . 'includes/ucf-faq-posttype.php';

include_once UCF_FAQ__PLUGIN_DIR . 'common/ucf-faq-common.php';
include_once UCF_FAQ__PLUGIN_DIR . 'common/ucf-faq-list-common.php';
include_once UCF_FAQ__PLUGIN_DIR . 'common/ucf-faq-topic-list-common.php';
include_once UCF_FAQ__PLUGIN_DIR . 'common/ucf-faq-search-common.php';

include_once UCF_FAQ__PLUGIN_DIR . 'templates/templates.php';
include_once UCF_FAQ__PLUGIN_DIR . 'templates/faq-search-templates.php';

include_once UCF_FAQ__PLUGIN_DIR . 'shortcodes/ucf-faq-list-shortcode.php';
include_once UCF_FAQ__PLUGIN_DIR . 'shortcodes/ucf-faq-topic-list-shortcode.php';
include_once UCF_FAQ__PLUGIN_DIR . 'shortcodes/ucf-faq-search-shortcode.php';

include_once UCF_FAQ__PLUGIN_DIR . 'layouts/ucf-faq-classic.php';
include_once UCF_FAQ__PLUGIN_DIR . 'layouts/ucf-faq-topic-classic.php';
include_once UCF_FAQ__PLUGIN_DIR . 'layouts/ucf-faq-topic-card.php';
include_once UCF_FAQ__PLUGIN_DIR . 'layouts/ucf-resource-search-faq.php';

if ( ! function_exists( 'ucf_faq_plugin_activation' ) ) {
	function ucf_faq_plugin_activation() {
		UCF_FAQ_Topic::register_topic();
		UCF_FAQ_PostType::register();
		UCF_FAQ_Config::add_options();
		flush_rewrite_rules();
		return;
	}

	register_activation_hook( UCF_FAQ__PLUGIN_FILE, 'ucf_faq_plugin_activation' );
}

if ( ! function_exists( 'ucf_faq_plugin_deactivation' ) ) {
	function ucf_faq_plugin_deactivation() {
		UCF_FAQ_Config::delete_options();
		flush_rewrite_rules();
		return;
	}

	register_deactivation_hook( UCF_FAQ__PLUGIN_FILE, 'ucf_faq_plugin_deactivation' );
}

if ( ! function_exists( 'ucf_faq_plugins_loaded' ) ) {
	function ucf_faq_plugins_loaded() {
		add_action( 'init', array( 'UCF_FAQ_PostType', 'register' ), 10, 0 );
	}

	add_action( 'plugins_loaded', 'ucf_faq_plugins_loaded', 10, 0 );
}

if ( ! function_exists( 'ucf_faq_init' ) ) {
	function ucf_faq_init() {
		add_action( 'init', array( 'UCF_FAQ_Topic', 'register_topic'), 10, 0 );
		add_action( 'admin_menu', array( 'UCF_FAQ_Config', 'add_options_page' ) );

		add_action( 'acf/init', array( 'UCF_FAQ_PostType', 'fields' ), 10, 0 );
		add_action( 'acf/init', array( 'UCF_FAQ_Topic', 'fields' ), 10, 0 );
	}
	add_action( 'plugins_loaded', 'ucf_faq_init' );
}

?>
