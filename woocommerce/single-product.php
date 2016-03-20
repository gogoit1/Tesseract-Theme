<?php
/**
 * The Template for displaying all single products.
 *
 * @author  Tesseract
 * @package WooCommerce/Templates
 * @version 2.5.3
 */

// Exit if accessed directly
if ( ! defined('ABSPATH')) {
  exit;
}

$layout = get_theme_mod('tesseract_woocommerce_product_layout');

get_header('shop');

	/**
	 * woocommerce_before_main_content hook
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 */
	do_action('woocommerce_before_main_content');

	if (have_posts()) {

		while (have_posts()) : the_post();

			wc_get_template_part('content', 'single-product');

		endwhile; // end of the loop.

	}

	/**
	 * woocommerce_after_main_content hook
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action('woocommerce_after_main_content');

	/**
	 * woocommerce_sidebar hook
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	if (($layout == 'sidebar-left') || ($layout == 'sidebar-right')) {
		do_action('woocommerce_sidebar');
	}

get_footer('shop');
