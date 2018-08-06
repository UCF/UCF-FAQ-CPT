<?php
/*
Plugin Name: UCF FAQ Custom Post Type
Description: Provides a FAQ custom post type and related meta fields.
Version: 1.0.0
Author: UCF Web Communications
License: GPL3
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'UCF_FAQ__PLUGIN_URL', plugins_url( basename( dirname( __FILE__ ) ) ) );
define( 'UCF_FAQ__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'UCF_FAQ__STATIC_URL', UCF_FAQ__PLUGIN_URL . '/static' );
define( 'UCF_FAQ__PLUGIN_FILE', __FILE__ );

include_once 'includes/ucf-faq-posttype.php';

if ( ! function_exists( 'ucf_faq_plugin_activation' ) ) {
	function ucf_faq_plugin_activation() {
		UCF_FAQ_PostType::register();
		flush_rewrite_rules();
		return;
	}

	register_activation_hook( UCF_FAQ__PLUGIN_FILE, 'ucf_faq_plugin_activation' );
}

if ( ! function_exists( 'ucf_faq_plugin_deactivation' ) ) {
	function ucf_faq_plugin_deactivation() {
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

?>