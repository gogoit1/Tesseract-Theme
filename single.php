<?php
/**
 * The template for displaying all single posts.
 *
 * @package Tesseract
 */

get_header();

$bplayout = get_theme_mod('tesseract_blog_post_layout');

switch ($bplayout) {
	case 'fullwidth':
		$primary_class = 'full-width-page no-sidebar';

		break;
	case 'sidebar-right':
		$primary_class = 'content-area sidebar-right';

		break;
	default:
		// sidebar-left
		$primary_class = 'content-area';
}
?>
	<div id="primary" class="<?php echo $primary_class; ?>">
		<main id="main" class="site-main" role="main">
		<?php
		if (have_posts()) {
			while (have_posts()) : the_post();

				get_template_part('content', 'single');

				// If comments are open or we have at least one comment, load up the comment template
				if (comments_open() || get_comments_number()) :
					comments_template();
				endif;

			endwhile; // end of the loop.
		}
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
if ( ! $bplayout || ($bplayout == 'sidebar-left') || ($bplayout == 'sidebar-right')) {
	get_sidebar();
}

get_footer();
