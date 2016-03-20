<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tesseract
 */
get_header();
?>
<div id="primary" class="full-width-page">
	<main id="main" class="site-main" role="main">
    <h1 class="page-title"><?php the_title(); ?></h1>
    <?php if (is_tag() || is_category() || is_tax()) { ?>
    	<div class="archive-description"><?php echo term_description(); ?></div>
		<?php } ?>

		<?php
		if (have_posts()) {
			while (have_posts()) : the_post();

				/* Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part('content', get_post_format());

			endwhile;

			tesseract_paging_nav();

		} else {
			get_template_part('content', 'none');
		}
		?>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();

get_footer();
?>
