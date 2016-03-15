<?php
/**
 * Enqueue Google fonts style to admin screen for custom header display.
 */
function tesseract_admin_fonts() {
	wp_enqueue_style('tesseract-font', tesseract_fonts_url(), array(), '1.0.0');
}
add_action('admin_print_scripts-appearance_page_custom-header', 'tesseract_admin_fonts');

function display_notice() {
  echo '<script type="text/javascript">
    jQuery(function($){
        $("a").each(function(){
            strhref = $(this).attr("href");
            if(typeof strhref != "undefined" && strhref.toLowerCase().indexOf("wpbeaverbuilder.com") >= 0){
                $(this).attr("href","https://www.wpbeaverbuilder.com/pricing/?fla=50&campaign=tesseracttheme");
            }
        });
    });
    </script>';
	if ( ! class_exists('Tesseract_Remove_Branding')) {
		if (false === ($dismissed = get_transient('dismiss_unbranding'))) {
?>
	<div id="unbranding-plugin-notice" class="updated notice">
		<a href="http://tesseracttheme.com/unbranding-plugin-2-2/" ><img src="https://s3.amazonaws.com/tesseracttheme/tesseract_team.jpg" alt="Tesseract Team" /></a>
      <p><?php _e('To edit the "Theme by Tesseract" at the bottom of your website you can get the Unbranding Plugin. <b>Thanks for your support!</b>', 'tesseract'); ?></p>
      <p><span>-<?php _e('The Tesseract Team', 'tesseract'); ?></span> <a id="dismiss-unbranding" href="javascript:void(0);"><?php _e('maybe later', 'tesseract'); ?></a> <a id="get-unbranding" href="http://tesseracttheme.com/unbranding-plugin-2/" target="_blank"><?php _e('check it out', 'tesseract'); ?></a></p>
	</div>
<?php
		}
	}
}
add_action('admin_notices', 'display_notice');

function dismiss_unbranding() {
	set_transient('dismiss_unbranding', true, 3*DAY_IN_SECONDS); // dismissed for 3 days
}
add_action('wp_ajax_dismiss_unbranding', 'dismiss_unbranding');

/* load custom admin scripts and styles */
function tesseract_enqueue_custom_scripts() {
	wp_enqueue_script('tesseract-custom', get_template_directory_uri().'/importer/js/custom.js', array('jquery'));
	wp_enqueue_style('tesseract-custom', get_template_directory_uri().'/importer/css/custom.css');
}
add_action('admin_enqueue_scripts', 'tesseract_enqueue_custom_scripts');
