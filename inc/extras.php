<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Tesseract
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function tesseract_page_menu_args($args) {
	$args['show_home'] = true;
	return $args;
}
add_filter('wp_page_menu_args', 'tesseract_page_menu_args');

/**
 * Adds custom classes to the array of body classes.
 *
 * @global $wp_version
 * @param array $classes Classes for the body element.
 * @return array
 */
function tesseract_body_classes($classes) {
	global $wp_version;

	// Adds a .group-blog class to blogs with more than 1 published author.
	if (is_multi_author()) {
		$classes[] = 'group-blog';
	}

	// Adds a .full-width-page class to posts without sidebar.
	if ( ! is_active_sidebar('sidebar-1')) {
		$classes[] = 'full-width-page';
	}

	$bodyClass = (version_compare($wp_version, '4.0.0', '>') && is_customize_preview()) ? 'backend' : 'frontend';

	$search_layout = get_theme_mod('tesseract_search_results_layout');

	$bplayout = get_theme_mod('tesseract_blog_post_layout');

	if ((is_page()) && (has_post_thumbnail())) {
		$bodyClass .= ' tesseract-featured';
	}

	if (is_plugin_active('beaver-builder-lite-version/fl-builder.php') || is_plugin_active('beaver-builder/fl-builder.php')) {
		$bodyClass .= ' beaver-on';
	}

	$opValue = get_theme_mod('tesseract_header_colors_bck_color_opacity');

	$header_bckOpacity = tesseract_is_numeric($opValue) ? TRUE : FALSE;

	if (is_front_page() && ($header_bckOpacity && (intval($opValue) < 100))) {
		$bodyClass .= ' transparent-header';
	}

	if (is_search()) {
		if ($search_layout == 'fullwidth') {
			$bodyClass .= ' fullwidth';
		}
		if ($search_layout == 'sidebar-right') {
			$bodyClass .= ' sidebar-right';
		}
	} elseif (is_single()) {
		if ($bplayout == 'fullwidth') {
			$bodyClass .= ' fullwidth';
		}
		if ($bplayout == 'sidebar-right') {
			$bodyClass .= ' sidebar-right';
		}
	}

	return $classes;
}
add_filter('body_class', 'tesseract_body_classes');

if ( ! function_exists('_wp_render_title_tag')) {
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function tesseract_wp_title($title, $sep) {
		if (is_feed()) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo('name', 'display');

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo('description', 'display');
		if ($site_description && (is_home() || is_front_page())) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if (($paged >= 2 || $page >= 2) && ! is_404()) {
			$title .= " $sep ".sprintf(__('Page %s', 'tesseract'), max($paged, $page));
		}

		return $title;
	}
	add_filter('wp_title', 'tesseract_wp_title', 10, 2);
}

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function tesseract_setup_author() {
	global $wp_query;

	if ($wp_query->is_author() && isset($wp_query->post)) {
		$GLOBALS['authordata'] = get_userdata($wp_query->post->post_author);
	}
}
add_action('wp', 'tesseract_setup_author');

function tesseract_new_excerpt_more($more) {
	global $post;

	return ' '.'<a class="moretag" href="'.get_permalink($post->ID).'">'.__('Read More ...', 'tesseract').'</a>';
}
add_filter('excerpt_more', 'tesseract_new_excerpt_more');

/* remove emoji scripts */
function disable_emojicons_tinymce($plugins) {
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

function disable_wp_emojicons() {
	// all actions related to emojis
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');

	// filter to remove TinyMCE emojis
	add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}
add_action('init', 'disable_wp_emojicons');
