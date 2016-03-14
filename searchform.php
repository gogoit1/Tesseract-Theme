<?php
/**
 * The template for displaying search results pages.
 *
 * @package Tesseract
 */
?>

<div class="search-wrapper">
  <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
      <span class="screen-reader-text"><?php _e( 'Search for:', 'tesseract' ); ?></span>
      <input type="search" class="search-field placeholdit" value="<?php echo get_search_query() ?>" name="s" title="<?php _e( 'Search for:', 'tesseract' ); ?>" />
    </label>
    <input type="submit" class="search-submit" value="<?php _e( 'Search', 'tesseract' ); ?>" />
  </form>
</div>
