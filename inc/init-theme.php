<?php
// Require global functions that are used both the front and admin side.
require_once(get_template_directory().'/inc/global-functions.php');

/**
 * Implement the Menus.
 */
require(get_template_directory().'/inc/menu.php');

/**
 * Include custom styles inline.
 */
require(get_template_directory().'/inc/style-inline.php');

/**
 * Implement the Custom Header feature.
 */
require(get_template_directory().'/inc/custom-header.php');

/**
 * Custom template tags for this theme.
 */
require(get_template_directory().'/inc/template-tags.php');

/**
 * Custom functions that act independently of the theme templates.
 */
require(get_template_directory().'/inc/extras.php');

/**
 * Customizer additions.
 */
require(get_template_directory().'/inc/customizer-functions.php');
require(get_template_directory().'/inc/customizer-frontend-functions.php');
require(get_template_directory().'/inc/customizer.php');

/**
 * Load WooCommerce compatibility file.
 */
if (is_plugin_active('woocommerce/woocommerce.php')) {
	require(get_template_directory().'/woocommerce/woocommerce-functions.php');
}

/**
 * Load Jetpack compatibility file.
 */
require(get_template_directory().'/inc/jetpack.php');

/**
 * Content Importer
 */
require(get_template_directory().'/importer/load.php');
require(get_template_directory().'/inc/beaver-builder-modules/beaver-builder-modules.php');
