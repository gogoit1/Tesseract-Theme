<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Tesseract
 */

$headright_content = get_theme_mod('tesseract_header_right_content');
$wooheader = (get_theme_mod('tesseract_woocommerce_headercart') == 1) ? true : false;

$rightclass = '';

if (($headright_content) && ($headright_content !== 'nothing')) {
	$rightclass = $wooheader ? $headright_content.' is-right is-woo ' : $headright_content.' is-right no-woo ';
} else if (($headright_content == 'nothing') && $wooheader) {
	$rightclass = $wooheader ? $headright_content.' no-right is-woo ' : $headright_content.' no-right no-woo ';
}

$opValue = get_theme_mod('tesseract_header_colors_bck_color_opacity');

$headpos = (is_front_page() && (tesseract_is_numeric($opValue) && (intval($opValue) < 100))) ? 'pos-absolute' : 'pos-relative';

$logoImg = get_theme_mod('tesseract_header_logo_image');
$blogname = get_bloginfo('blogname');
$hmenusize = get_theme_mod('tesseract_header_width');

$mmdisplay = get_theme_mod('tesseract_mobmenu_opener');
$mmdClass = ($mmdisplay == 1) ? 'showit' : 'hideit';

$hmenusize_class = ($hmenusize == 'fullwidth') ? 'fullwidth' : 'autowidth';

if ( ! $logoImg && $blogname) {
	$brand_content = 'blogname';
}
if ($logoImg) {
	$brand_content = 'logo';
}
if ( ! $logoImg && ! $blogname) {
	$brand_content = 'no-brand';
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<?php wp_head(); ?>

<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]-->

</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'tesseract'); ?></a>

  <header id="masthead" class="site-header <?php echo $rightclass.$headpos.' '.'menusize-'.$hmenusize_class.' '; echo get_header_image() ? 'is-header-image' : 'no-header-image'; ?>" role="banner">
    <div id="site-banner" class="cf<?php echo ' '.$headright_content.' '.$brand_content; ?>">
      <div id="site-banner-main" class="<?php echo (($headright_content) && ($headright_content !== 'nothing')) ? 'is-right' : 'no-right'; ?>">
        <div id="mobile-menu-trigger-wrap" class="cf"><a class="<?php echo $rightclass; ?>menu-open dashicons dashicons-menu" href="#" id="mobile-menu-trigger"></a></div>
        <div id="site-banner-left">
					<div id="site-banner-left-inner">
					<?php if ($logoImg || $blogname) { ?>
            <div class="site-branding <?php if ( ! display_header_text()) { echo 'hide-header-text'; } ?>">
            <?php if ($logoImg) { ?>
              <h1 class="site-logo"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><img src="<?php echo $logoImg; ?>" alt="logo" /></a></h1>
            <?php } else { ?>
              <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php } ?>
            </div><!-- .site-branding -->
          <?php } ?>

          <?php
					$menuSelected = get_theme_mod('tesseract_header_menu_select');
					if ($menuSelected !== 'none') {
					?>
            <nav id="site-navigation" class="<?php echo $mmdClass; ?> main-navigation top-navigation <?php echo $hmenusize_class; ?>" role="navigation">
              <?php tesseract_output_menu(FALSE, FALSE, 'primary', 0); ?>
            </nav><!-- #site-navigation -->
        	<?php } ?>
    			</div>
    		</div>

      	<?php get_template_part('content', 'header-rightcontent'); ?>

  		</div>
  	</div>
	</header><!-- #masthead -->

	<div id="content" class="cf site-content">
