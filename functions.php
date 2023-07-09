<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! defined( 'UNDERSTRAP_DIR_PATH' ) ) {
	define( 'UNDERSTRAP_DIR_PATH', untrailingslashit( get_template_directory() ).'-child' );
}

if ( ! defined( 'UNDERSTRAP_DIR_URI' ) ) {
	define( 'UNDERSTRAP_DIR_URI', untrailingslashit( get_template_directory_uri() ).'-child' );
}

require_once UNDERSTRAP_DIR_PATH . '/inc/helpers/autoloader.php';
require_once UNDERSTRAP_DIR_PATH . '/inc/helpers/template-tags.php';

function understrap_get_theme_instance() {
	\UNDERSTRAP_THEME\Inc\UNDERSTRAP_THEME::get_instance();
}

understrap_get_theme_instance();


/*
function remove_parent_functions() {
	remove_action( 'understrap_site_info', 'understrap_add_site_info' );
	add_action( 'understrap_site_info', 'understrap_add_site_child_info' );
}
add_action( 'init', 'remove_parent_functions', 15 );

function understrap_add_site_child_info() {
	echo "Scan2Ai made by Massinelli s.r.l.";
}
*/