<?php
/**
 * Template Name: Full Width Page
 *
 * @package Tesseract
 */

get_header();
?>
	<div id="primary" class="full-width-page no-sidebar">
		<main id="main" class="site-main" role="main">

		<?php
		if (have_posts()) {
			while (have_posts()) : the_post();

				/* Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part('content', 'page');

				// If comments are open or we have at least one comment, load up the comment template
				if (comments_open() || get_comments_number()) {
					comments_template();
				}

			endwhile;

		} else {
			get_template_part('content', 'none');
		}
		?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php $layout_default = get_theme_mod('tesseract_woocommerce_default_layout'); ?>

	<?php
	if ((is_plugin_active('woocommerce/woocommerce.php') &&
	(($layout_default == 'sidebar-left') ||
	($layout_default == 'sidebar-right')))) {
		get_sidebar();
	}
	?>

<?php get_footer(); ?>
