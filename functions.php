<?php
/**
 * Tesseract functions and definitions
 *
 * @package Tesseract
 */

include_once(ABSPATH.'wp-admin/includes/plugin.php');

/**
 * The current version of the theme.
 */
define( 'TESSERACT_VERSION', '2.5.3' );

/**
 * The minimum version of WordPress required for Tesseract.
 */
define( 'TESSERACT_MIN_WP_VERSION', '4.2' );

/**
 * The suffix to use for scripts.
 */
if ( ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ) {
	define( 'TESSERACT_SUFFIX', '' );
} else {
	define( 'TESSERACT_SUFFIX', '.min' );
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset($content_width)) {
	$content_width = 700; /* pixels */
}

if ( ! function_exists('tesseract_setup')) {
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function tesseract_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Tesseract, use a find and replace
     * to change 'tesseract' to the name of your theme in all the template files
     */
    load_theme_textdomain('tesseract', get_template_directory().'/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Add tyles the visual editor to resemble the theme style.
    add_editor_style(array('css/editor-style' . TESSERACT_SUFFIX . '.css', tesseract_fonts_url()));

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Add Woocommerce support
     */
    add_theme_support('woocommerce');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support('post-thumbnails');

    // Set default size.
    set_post_thumbnail_size(1580, 480, true);

    // Add default size for single pages.
    add_image_size('tesseract-large', '1580', '480', true);

    // Add default size for homepage.
    add_image_size('tesseract-thumbnail', '210', '150', true);

    // Add default logo size for Jetpack.
    add_image_size('tesseract-site-logo', '300', '9999', false);

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(array(
      'primary' => __('Header', 'tesseract'),
      'primary_right' => __('Header Right', 'tesseract'),
      'secondary' => __('Footer', 'tesseract')
    ));

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    /*
     * Enable support for Post Formats.
     * See http://codex.wordpress.org/Post_Formats
     */
    add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));

    // Set up the WordPress core custom background feature.
    add_theme_support('custom-background', apply_filters('tesseract_custom_background_args', array(
      'default-color' => 'f9f9f9',
      'default-image' => ''
    )));
  }
} // tesseract_setup
add_action('after_setup_theme', 'tesseract_setup');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function tesseract_widgets_init() {
	register_sidebar(array(
		'name'          => __('Primary Sidebar', 'tesseract'),
		'id'            => 'sidebar-1',
		'description'   => __('Appears on the left.', 'tesseract'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
}
add_action('widgets_init', 'tesseract_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function tesseract_scripts() {
	global $wp_styles;

	// Enqueue default style
	wp_enqueue_style('tesseract-style', get_stylesheet_uri(), array(), TESSERACT_VERSION);

	// Google fonts
	wp_enqueue_style('tesseract-fonts', tesseract_fonts_url(), array(), TESSERACT_VERSION);

  // Social icons style
	wp_enqueue_style('tesseract-icons', get_template_directory_uri().'/css/typicons' . TESSERACT_SUFFIX . '.css', array(), TESSERACT_VERSION);

	/* only enqueue font-awesome stylesheet if not already enqueued */
	if (array_search('font-awesome', $wp_styles->queue) === false) {
		wp_enqueue_style('fontawesome', get_template_directory_uri().'/css/font-awesome' . TESSERACT_SUFFIX . '.css', array(), '4.4.0');
	}

  // Horizontal menu style
	wp_enqueue_style('tesseract-site-banner', get_template_directory_uri().'/css/site-banner' . TESSERACT_SUFFIX . '.css', array('tesseract-style'), TESSERACT_VERSION);
	wp_enqueue_style('tesseract-footer-banner', get_template_directory_uri().'/css/footer-banner' . TESSERACT_SUFFIX . '.css', array('tesseract-style'), TESSERACT_VERSION);
	wp_enqueue_style('dashicons');
	wp_enqueue_style('tesseract-sidr-style', get_template_directory_uri().'/css/jquery.sidr' . TESSERACT_SUFFIX . '.css', array('tesseract-style'), TESSERACT_VERSION);

	// Fittext
	wp_enqueue_script('tesseract-fittext', get_template_directory_uri().'/js/jquery.fittext' . TESSERACT_SUFFIX . '.js', array('jquery'), TESSERACT_VERSION, true);

	//Mobile menu
	wp_enqueue_script('tesseract-sidr', get_template_directory_uri().'/js/jquery.sidr' . TESSERACT_SUFFIX . '.js', array('tesseract-fittext'), TESSERACT_VERSION, true);

	// Modernizr for old browsers
	wp_enqueue_script('tesseract-modernizr', get_template_directory_uri().'/js/modernizr.custom' . TESSERACT_SUFFIX . '.js', array(), TESSERACT_VERSION, false);

  // JS helpers (This is also the place where we call the jQuery in array)
	wp_enqueue_script('tesseract-helpers-functions', get_template_directory_uri().'/js/helpers-functions' . TESSERACT_SUFFIX . '.js', array('jquery', 'tesseract-sidr'), TESSERACT_VERSION, true);
	wp_enqueue_script('tesseract-helpers', get_template_directory_uri().'/js/helpers' . TESSERACT_SUFFIX . '.js', array('jquery', 'tesseract-helpers-functions'), TESSERACT_VERSION, true);

	if (is_plugin_active('beaver-builder-lite-version/fl-builder.php') || is_plugin_active('beaver-builder/fl-builder.php')) {
		wp_enqueue_script('tesseract-helpers-beaver', get_template_directory_uri().'/js/helpers-beaver' . TESSERACT_SUFFIX . '.js', array('jquery', 'tesseract-helpers'), TESSERACT_VERSION, true);
	}

	// Skip link fix
	wp_enqueue_script('tesseract-skip-link-focus-fix', get_template_directory_uri().'/js/skip-link-focus-fix' . TESSERACT_SUFFIX . '.js', array(), TESSERACT_VERSION, true);

	// Comments
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	// Register the script
	wp_register_script('tesseract_helpers', get_template_directory_uri().'/js/helpers' . TESSERACT_SUFFIX . '.js');
}

add_action('wp_enqueue_scripts', 'tesseract_scripts');

function tesseract_noscript() {
	echo '<noscript><style>#sidebar-footer aside {border: none!important;}</style></noscript>';
}
add_action('wp_head', 'tesseract_noscript');

function tesseract_footer_branding() {
	do_action('tesseract_footer_branding');
}

/**
 * Output featured image on blog and archive pages.
 */
function tesseract_output_featimg_blog() {
	global $post;

	$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
	$featImg_display = get_theme_mod('tesseract_blog_display_featimg');
	$featImg_pos = get_theme_mod('tesseract_blog_featimg_pos');

	$w = $thumbnail[1];
	$h = $thumbnail[2];
	$bw = 720;
	$wr = $w/$bw;
	$hr = $h/$wr;

	$origRatio = $hr;

	$ratio = get_theme_mod('tesseract_blog_featimg_size');
	$ratio = (isset($ratio)) ? $ratio : 'default';
	switch ($ratio) :

		case 'tv': $featImg_height = ($origRatio >= 540) ? 540 : $origRatio; break;
		case 'hdtv': $featImg_height = ($origRatio >= 405) ? 405 : $origRatio; break;
		case 'theater1': $featImg_height = ($origRatio >= 390) ? 390 : $origRatio; break;
		case 'theater2': $featImg_height = ($origRatio >= 306) ? 306 : $origRatio; break;
		case 'default';
		case 'pixel';
		default: $featImg_height = $origRatio; break;

	endswitch;

	$pxratio = get_theme_mod('tesseract_blog_featimg_px_size');
	$featImg_height = (isset($pxratio) && ($ratio == 'pixel')) ? $pxratio : $featImg_height;

	if (isset($featImg_display) && ($featImg_display == 1)) { ?>
    <a class="entry-post-thumbnail <?php echo ($featImg_pos == 'below') ? 'below-title' : 'above-title'; ?>" href="<?php the_permalink(); ?>" style="background: transparent url('<?php echo esc_url($thumbnail[0]); ?>') no-repeat center center; width: 100%; height: <?php echo $featImg_height; ?>px; display: block; background-size: cover;"></a><!-- .entry-background -->
	<?php }
}

/*
 * Beaver Builder - remove page title
 */
function tesseract_show_page_header() {
  if (class_exists('FLBuilderModel') && FLBuilderModel::is_builder_enabled()) {
    $global_settings = FLBuilderModel::get_global_settings();

    if ( ! $global_settings->show_default_heading) {
      return false;
    }
  }

  return true;
}

/**
 * Register Google fonts.
 */
function tesseract_fonts_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by chosen font(s), translate this to 'off'. Do not translate into your own language.
	 */
	if ('off' !== _x('on', 'Google font: on or off', 'tesseract')) {
		$font_url = add_query_arg('family', urlencode('Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin,greek,greek-ext,vietnamese,cyrillic-ext,cyrillic,latin-ext'), "//fonts.googleapis.com/css");
	}

	return $font_url;
}

// Initialize Theme
require(get_template_directory().'/include/init-theme.php');

// Initialize Theme for Admin
if (is_admin()) {
  require(get_template_directory().'/include/admin/init-theme-admin.php');
}

/* check if a plugin exists in the plugins directory and if it's already active */
function is_plugin_installed($slug) {
	$plugins = get_plugins();

	foreach ($plugins as $plugin_key => $plugin_info) {
		if (preg_match("/^{$slug}\//", $plugin_key)) {
			return is_plugin_active($plugin_key);
		}
	}

	return false;
}

/* clear the dismiss unbranding transient when logging out */
function tesseract_clear_dismiss_transient() {
  delete_transient('dismiss_unbranding');
}
add_action('wp_logout', 'tesseract_clear_dismiss_transient');
add_action('wp_login', 'tesseract_clear_dismiss_transient', 10);
