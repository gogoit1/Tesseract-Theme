<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Tesseract
 */
get_header();
?>
	<div id="primary" class="content-area sidebar-left">
		<main id="main" class="site-main" role="main">
			<?php
			if (have_posts()) {

				while ( have_posts() ) : the_post();

					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}

				endwhile; // end of the loop.
			}
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	if ( !is_plugin_active('woocommerce/woocommerce.php') ||
	( is_plugin_active('woocommerce/woocommerce.php') &&
	( !isset( $layout_default ) ||
	!$layout_default ||
	( $layout_default == 'sidebar-left' ) ||
	( $layout_default == 'sidebar-right' ) ) ) ) {
		get_sidebar();
	}
	?>

<?php get_footer(); ?>
