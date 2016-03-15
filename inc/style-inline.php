<?php
// Localize script (only few lines in helpers.js)

// First things first: let's get a lighter version of the user-defined search input color applied in the mobile menu - tricky
// See @ http://stackoverflow.com/questions/11091695/how-to-find-the-hex-code-for-a-lighter-or-darker-version-of-a-hex-code-in-php
$watermarkColor = get_theme_mod('tesseract_mobmenu_search_color');

$col = Array(
  hexdec(substr($watermarkColor, 1, 2)),
  hexdec(substr($watermarkColor, 3, 2)),
  hexdec(substr($watermarkColor, 5, 2))
);

$lighter = Array(
  255-(255-$col[0])*0.8,
  255-(255-$col[1])*0.8,
  255-(255-$col[2])*0.8
);
$lighter = "#".sprintf("%02X%02X%02X", $lighter[0], $lighter[1], $lighter[2]);

wp_localize_script('tesseract_helpers', 'tesseract_vars', array(
  'hpad' => get_theme_mod('tesseract_header_height'),
  'fpad' => get_theme_mod('tesseract_footer_height'),
));

wp_enqueue_script('tesseract_helpers');

$header_bckRGB = get_theme_mod('tesseract_header_colors_bck_color') ? get_theme_mod('tesseract_header_colors_bck_color') : '#59bcd9';

$opValue = get_theme_mod('tesseract_header_colors_bck_color_opacity');
$header_bckOpacity = is_numeric($opValue) ? $opValue : 100;

$hex = $header_bckRGB;
$header_bckOpacity = $header_bckOpacity/100;

preg_match("/\s*(rgba\(\s*[0-9]+\s*,\s*[0-9]+\s*,\s*[0-9]+\s*,\d+\d*\.\d+\))/", $hex, $match);
$rgba = $match ? true : false;

list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
$header_bckColor = "rgb($r, $g, $b)";
$header_bckColor_home = "rgba($r, $g, $b, $header_bckOpacity)";

// HEADER and FOOTER
$header_textColor = get_theme_mod('tesseract_header_colors_text_color') ? get_theme_mod('tesseract_header_colors_text_color') : '#ffffff';

$header_linkColor = get_theme_mod('tesseract_header_colors_link_color') ? get_theme_mod('tesseract_header_colors_link_color') : '#ffffff';

$header_linkHoverColor = get_theme_mod('tesseract_header_colors_link_hover_color') ? get_theme_mod('tesseract_header_colors_link_hover_color') : '#d1ecff';

$footer_bckColor = get_theme_mod('tesseract_footer_colors_bck_color') ? get_theme_mod('tesseract_footer_colors_bck_color') : '#1e73be';

$footer_textColor = get_theme_mod('tesseract_footer_colors_text_color') ? get_theme_mod('tesseract_footer_colors_text_color') : '#ffffff';

$footer_headingColor = get_theme_mod('tesseract_footer_colors_heading_color') ? get_theme_mod('tesseract_footer_colors_heading_color') : '#ffffff';

$footer_linkColor = get_theme_mod('tesseract_footer_colors_link_color') ? get_theme_mod('tesseract_footer_colors_link_color') : '#ffffff';

$footer_linkHoverColor = get_theme_mod('tesseract_footer_colors_link_hover_color') ? get_theme_mod('tesseract_footer_colors_link_hover_color') : '#d1ecff';

$add_content_borderColor_array = tesseract_hex2rgb($footer_linkColor);
$add_content_borderColor = implode(', ', $add_content_borderColor_array);

// MOBMENU
$mobmenu_bckColor = get_theme_mod('tesseract_mobmenu_background_color') ? get_theme_mod('tesseract_mobmenu_background_color') : '#336ca6';
$mobmenu_linkColor = get_theme_mod('tesseract_mobmenu_link_color') ? get_theme_mod('tesseract_mobmenu_link_color') : '#fff';
$mobmenu_linkHoverColor = get_theme_mod('tesseract_mobmenu_link_hover_color') ? get_theme_mod('tesseract_mobmenu_link_hover_color') : '#fff';

list($lc_r, $lc_g, $lc_b) = sscanf($mobmenu_linkColor, "#%02x%02x%02x");
$mob_rgb_linkColor_submenu = "rgba($lc_r, $lc_g, $lc_b, 0.8)";

list($lhc_r, $lhc_g, $lhc_b) = sscanf($mobmenu_linkHoverColor, "#%02x%02x%02x");
$mob_rgb_linkHoverColor_submenu = "rgba($lhc_r, $lhc_g, $lhc_b, 0.8)";

$mobmenu_linkHoverBckColor_option = get_theme_mod('tesseract_mobmenu_link_hover_background_color') ? get_theme_mod('tesseract_mobmenu_link_hover_background_color') : 'dark';
$mobmenu_linkHoverBckColor_option_custom = get_theme_mod('tesseract_mobmenu_link_hover_background_color_custom');

switch ($mobmenu_linkHoverBckColor_option) {
  case 'custom' :
    $mobmenu_linkHoverBckColor = $mobmenu_linkHoverBckColor_option_custom;
    break;

  case 'light' :
    $mobmenu_linkHoverBckColor = 'rgba(255, 255, 255, 0.1)';
    break;

  default :
    $mobmenu_linkHoverBckColor = 'rgba(0, 0, 0, 0.2)';
}

$mobmenu_shadowColor_option = get_theme_mod('tesseract_mobmenu_shadow_color') ? get_theme_mod('tesseract_mobmenu_shadow_color') : 'dark';
$mobmenu_shadowColor_option_custom = get_theme_mod('tesseract_mobmenu_shadow_color_custom') ? get_theme_mod('tesseract_mobmenu_shadow_color_custom') : 'dark';

switch ($mobmenu_shadowColor_option) {
  case 'custom' :
    list($shad_r, $shad_g, $shad_b) = sscanf($mobmenu_shadowColor_option_custom, "#%02x%02x%02x");
    break;

  case 'light' :
    $shad_r = 255;
    $shad_g = 255;
    $shad_b = 255;
    break;

  default :
    $shad_r = 0;
    $shad_g = 0;
    $shad_b = 0;
}

$mobmenu_searchColor = get_theme_mod('tesseract_mobmenu_search_color');

list($sc_r, $sc_g, $sc_b) = sscanf($mobmenu_searchColor, "#%02x%02x%02x");

$mobmenu_searchColorRgb = "rgba($sc_r, $sc_g, $sc_b, 0.6)";

$mobmenu_searchBckColor = get_theme_mod('tesseract_mobmenu_search_background_color');
$mobmenu_searchBckColor = ($mobmenu_searchBckColor == 'dark') ? 'rgba(0, 0, 0, .15)' : 'rgba(255, 255, 255, 0.15)';

$mobmenu_socialBckColor = get_theme_mod('tesseract_mobmenu_social_background_color');
$mobmenu_socialBckColor = ($mobmenu_socialBckColor == 'dark') ? 'rgba(0, 0, 0, .15)' : 'rgba(255, 255, 255, 0.15)';

$mobmenu_buttonsBckColor_option = get_theme_mod('tesseract_mobmenu_buttons_background_color') ? get_theme_mod('tesseract_mobmenu_buttons_background_color') : 'dark';
$mobmenu_buttonsBckColor_option_custom = get_theme_mod('tesseract_mobmenu_buttons_background_color_custom');

switch ($mobmenu_buttonsBckColor_option) {
  case 'custom' :
    $mobmenu_buttonsBckColor = $mobmenu_buttonsBckColor_option_custom;
    break;

  case 'light' :
    $mobmenu_buttonsBckColor = 'rgba(255, 255, 255, 0.1)';
    break;

  default :
    $mobmenu_buttonsBckColor = 'rgba(0, 0, 0, 0.2)';
}

$mobmenu_buttons_textColor = get_theme_mod('tesseract_mobmenu_buttons_text_color');
$mobmenu_buttons_linkColor = get_theme_mod('tesseract_mobmenu_buttons_link_color');
$mobmenu_buttons_linkHoverColor = get_theme_mod('tesseract_mobmenu_buttons_link_hover_color');

$mobmenu_buttons_maxbtnSepColor = get_theme_mod('tesseract_mobmenu_maxbtn_sep_color');
$mobmenu_buttons_maxbtnSepColor = ($mobmenu_buttons_maxbtnSepColor == 'dark') ? 'inset 0 -1px rgba(0, 0, 0, .1)' : 'inset 0 -1px rgba(255, 255, 255, 0.1)';

$dynamic_styles_mobmenu = ".sidr {
  background-color: " . $mobmenu_bckColor.";
  }

.sidr .sidr-class-menu-item a,
.sidr .sidr-class-menu-item span { color: " . $mobmenu_linkColor."; }


.sidr .sidr-class-menu-item ul li a,
.sidr .sidr-class-menu-item ul li span {
  color: " . $mob_rgb_linkColor_submenu.";
}

.sidr .sidr-class-menu-item a:hover,
.sidr .sidr-class-menu-item span:hover,
.sidr .sidr-class-menu-item:first-child a:hover,
.sidr .sidr-class-menu-item:first-child span:hover { color: " . $mobmenu_linkHoverColor."; }

.sidr .sidr-class-menu-item ul li a:hover,
.sidr .sidr-class-menu-item ul li span:hover,
.sidr .sidr-class-menu-item ul li:first-child a:hover,
.sidr .sidr-class-menu-item ul li:first-child span:hover { color: " . $mob_rgb_linkHoverColor_submenu."; }

.sidr ul li > a:hover,
.sidr ul li > span:hover,
.sidr > div > ul > li:first-child > a:hover,
.sidr > div > ul > li:first-child > span:hover,
.sidr ul li ul li:hover > a,
.sidr ul li ul li:hover > span {
  background: " . $mobmenu_linkHoverBckColor.";

  }

/* Shadows and Separators */

.sidr ul li > a,
.sidr ul li > span,
#sidr-id-header-button-container-inner > * {
  -webkit-box-shadow: inset 0 -1px rgba( " . $shad_r." ,".$shad_g." ,".$shad_b." , 0.2);
  -moz-box-shadow: inset 0 -1px rgba( " . $shad_r." ,".$shad_g." ,".$shad_b." , 0.2);
  box-shadow: inset 0 -1px rgba( " . $shad_r." ,".$shad_g." ,".$shad_b." , 0.2);
}

.sidr > div > ul > li:last-of-type > a,
.sidr > div > ul > li:last-of-type > span,
#sidr-id-header-button-container-inner > *:last-of-type {
  box-shadow: none;
  }

.sidr ul.sidr-class-hr-social li a,
.sidr ul.sidr-class-hr-social li a:first-child {
  -webkit-box-shadow: 0 1px 0 0px rgba( " . $shad_r." ,".$shad_g." ,".$shad_b.", .25);
  -moz-box-shadow: 0 1px 0 0px rgba( " . $shad_r." ,".$shad_g." ,".$shad_b.", .25);
  box-shadow: 0 1px 0 0px rgba( " . $shad_r." ,".$shad_g." ,".$shad_b.", .25);
}

/* Header Right side content */

.sidr-class-search-field,
.sidr-class-search-form input[type='search'] {
  background: " . $mobmenu_searchBckColor.";
  color: " . $mobmenu_searchColor.";
}

.sidr-class-hr-social {
  background: " . $mobmenu_socialBckColor.";
}

#sidr-id-header-button-container-inner,
#sidr-id-header-button-container-inner > h1,
#sidr-id-header-button-container-inner > h2,
#sidr-id-header-button-container-inner > h3,
#sidr-id-header-button-container-inner > h4,
#sidr-id-header-button-container-inner > h5,
#sidr-id-header-button-container-inner > h6 {
  background: " . $mobmenu_buttonsBckColor.";
  color: " . $mobmenu_buttons_textColor.";
}

#sidr-id-header-button-container-inner a,
#sidr-id-header-button-container-inner button {
  color: " . $mobmenu_buttons_linkColor.";
}

#sidr-id-header-button-container-inner a:hover,
#sidr-id-header-button-container-inner button:hover {
  color: " . $mobmenu_buttons_linkHoverColor.";
}

/*
.sidr ul li > a,
.sidr ul li > span,
#header-button-container *,
#sidr-id-header-button-container-inner button {
  -webkit-box-shadow: " . $mobmenu_buttons_maxbtnSepColor.";
  -moz-box-shadow: " . $mobmenu_buttons_maxbtnSepColor.";
  box-shadow: " . $mobmenu_buttons_maxbtnSepColor.";
}
*/
";

wp_add_inline_style('tesseract-sidr-style', $dynamic_styles_mobmenu);

// HEADER & HEADER LOGO HEIGHT, HEADER WIDTH PROPS
$header_logoHeight = get_theme_mod('tesseract_header_logo_height') ? get_theme_mod('tesseract_header_logo_height') : 40;

$headerHeightInit = get_theme_mod('tesseract_header_height');
$headerHeight = is_numeric($headerHeightInit) ? $headerHeightInit : 10;

$headerWidthProp = is_integer(get_theme_mod('tesseract_header_blocks_width_prop')) ? get_theme_mod('tesseract_header_blocks_width_prop') : 60;

$dynamic_styles_header = ".site-header,
.main-navigation ul ul a,
#header-right-menu ul ul a,
.site-header .cart-content-details { background-color: " . $header_bckColor."; }
.site-header .cart-content-details:after { border-bottom-color: " . $header_bckColor."; }

.home .site-header,
.home .main-navigation ul ul a,
.home #header-right ul ul a,
.home .site-header .cart-content-details { background-color: " . $header_bckColor_home."; }
.home .site-header .cart-content-details:after { border-bottom-color: " . $header_bckColor_home."; }

.site-header,
.site-header h1,
.site-header h2,
.site-header h3,
.site-header h4,
.site-header h5,
.site-header h6 { color: " . $header_textColor."!important; }

#masthead .search-field { color: " . $header_textColor."; }
#masthead .search-field.watermark { color: #ccc; }

.site-header a,
.main-navigation ul ul a,
#header-right-menu ul ul a,
.menu-open,
.dashicons.menu-open,
.menu-close,
.dashicons.menu-close { color: " . $header_linkColor."; }

.site-header a:hover,
.main-navigation ul ul a:hover,
#header-right-menu ul ul a:hover,
.menu-open:hover,
.dashicons.menu-open:hover,
.menu-close:hover,
.dashicons.menu-open:hover { color: " . $header_linkHoverColor."; }

/* Header logo height */

#site-banner .site-logo img {
  height: " . $header_logoHeight."px;
  }

#masthead {
  padding-top: " . $headerHeight."px;
  padding-bottom: " . $headerHeight."px;
  }

/* Header width props */

#site-banner-left {
  width: " . $headerWidthProp."%;
  }

#site-banner-right {
  width: " . (100-$headerWidthProp)."%;
  }
";
$hcContent = get_theme_mod('tesseract_header_right_content');
$wooCart = get_theme_mod('tesseract_woocommerce_headercart');
$displayWooCart = (is_plugin_active('woocommerce/woocommerce.php') && ($wooCart == 1));
$cartColor = get_theme_mod('tesseract_woocommerce_cartcolor') ? get_theme_mod('tesseract_woocommerce_cartcolor') : '#fff';
$hcContent = ( ! $displayWooCart && ($hcContent == 'nothing'));

if (true == $hcContent) {
  $dynamic_styles_header .= "#site-banner-left {
      width: 100%;
    }

    #site-banner-right {
      display: none;
      padding: 0;
      margin: 0;
    }
  ";
}

//Horizontal - fullwidth header
if (get_theme_mod('tesseract_header_width') == 'fullwidth') {

  $dynamic_styles_header .= "#site-banner {
    max-width: 100%;
    padding-left: 0;
    padding-right: 0;
  }
  ";
}

$dynamic_styles_header .= "
  .icon-shopping-cart, .woocart-header .cart-arrow, .woocart-header .cart-contents {
    color: {$cartColor};
  }
";

wp_add_inline_style('tesseract-site-banner', $dynamic_styles_header);

// FOOTER & FOOTER LOGO HEIGHT, FOOTER WIDTH PROPS
$footerWidthProp = get_theme_mod('tesseract_footer_blocks_width_prop') ? get_theme_mod('tesseract_footer_blocks_width_prop') : 60;

$footer_logoHeight = get_theme_mod('tesseract_footer_logo_height') ? get_theme_mod('tesseract_footer_logo_height') : 40;

$footerHeightInit = get_theme_mod('tesseract_footer_height');
$footerHeight = is_numeric($footerHeightInit) ? $footerHeightInit : 10;

$dynamic_styles_footer = "#colophon {
  background-color: " . $footer_bckColor.";
  color: " . $footer_textColor."
}

#colophon .search-field { color: " . $footer_textColor."; }
#colophon .search-field.watermark { color: #ccc; }

#colophon h1,
#colophon h2,
#colophon h3,
#colophon h4,
#colophon h5,
#colophon h6 { color: " . $footer_headingColor."; }

#colophon a { color: " . $footer_linkColor."; }

#colophon a:hover { color: " . $footer_linkHoverColor."; }

#horizontal-menu-before,
#horizontal-menu-after { border-color: rgba(" . $add_content_borderColor.", 0.25); }

#footer-banner.footbar-active { border-color: rgba(" . $add_content_borderColor.", 0.15); }

#footer-banner .site-logo img { height: " . $footer_logoHeight."px; }

#colophon {
  padding-top: " . $footerHeight."px;
  padding-bottom: " . $footerHeight."px;
  }

#horizontal-menu-wrap {
  width: " . $footerWidthProp."%;
  }

#footer-banner-right	{
  width: " . (100-intval($footerWidthProp))."%;
  }

";

//Horizontal - fullwidth footer
if (get_theme_mod('tesseract_footer_width') == 'fullwidth') {
  $dynamic_styles_footer .= "#footer-banner {
    max-width: 100%;
    padding: 0 20px;
  }";
}

wp_add_inline_style('tesseract-footer-banner', $dynamic_styles_footer);
