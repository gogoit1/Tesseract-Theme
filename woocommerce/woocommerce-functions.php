<?php
global $layout_loop, $layout_product, $isloop;

$layout_loop = get_theme_mod('tesseract_woocommerce_loop_layout');
$isloop = (function_exists('WC') && (is_shop() || is_product_category() || is_product_tag())) ? true : false;

// Basic integration config
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'tesseract_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'tesseract_woocommerce_wrapper_end', 10);

function tesseract_woocommerce_wrapper_start() {
	$layout_loop = get_theme_mod('tesseract_woocommerce_loop_layout');
	$layout_product = get_theme_mod('tesseract_woocommerce_product_layout');

	if (function_exists('WC') && (is_shop() || is_product_category() || is_product_tag())) {
		if (($layout_loop == 'sidebar-left') || ($layout_loop == 'sidebar-right')) {
			$primclass = 'with-sidebar';
			$primclass .= ($layout_loop == 'sidebar-left') ? ' sidebar-left' : ' sidebar-right';
		} else if (($layout_loop == 'fullwidth') || ( ! $layout_loop)) {
			$primclass = 'no-sidebar';
		}
	} else if (is_product()) {
		if (($layout_product == 'sidebar-left') || ($layout_product == 'sidebar-right')) {
			$primclass = 'with-sidebar';
			$primclass .= ($layout_product == 'sidebar-left') ? ' sidebar-left' : ' sidebar-right';
		} else if (($layout_product == 'fullwidth') || ( ! $layout_product)) {
			$primclass = 'no-sidebar';
		}
	} else { $primclass = 'sidebar-default'; }

	echo '<div id="primary" class="content-area '.$primclass.'">';
} // END if tesseract_woocommerce_wrapper_start()

// Update number of columns on shop/pr. category/pr. tag pages when a layout with sidebar is active
function tesseract_woocommerce_wrapper_end() {
	echo '</div>';
} // END tesseract_woocommerce_wrapper_end()

if (( ! function_exists('loop_shop_columns')) &&
   (($layout_loop == 'sidebar-left') || ($layout_loop == 'sidebar-right'))) {

	// Change number or products per row to 2
	add_filter('loop_shop_columns', 'tesseract_loop_columns');

	function tesseract_loop_columns() {
		return 2; // 3 products per row
	}
}

// Ensure cart contents update when products are added to the cart via AJAX
add_filter('woocommerce_add_to_cart_fragments', 'tesseract_wc_header_add_to_cart_fragment');

function tesseract_wc_header_add_to_cart_fragment($fragments) {
	ob_start();
	?>
	<div class="woocart-header">
		<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>">
			<span class="dashicons dashicons-arrow-down cart-arrow"></span>
			<span class="cart-contents-counter"><?php echo WC()->cart->cart_contents_count; ?></span>
			<span class="icon-shopping-cart"></span>
		</a>

		<div class="cart-content-details-wrap">
			<div class="cart-content-details">
				<?php if (WC()->cart->cart_contents_count == 0) { ?>
					<span><?php _e( 'Your Shopping Cart is empty.', 'tesseract' ); ?></span>
				<?php } else { ?>
					<table class="cart-content-details-table">
						<thead>
							<tr>
								<th><?php _e( 'Product Name', 'tesseract' ); ?></th>
								<th><?php _e( 'Quantity', 'tesseract' ); ?></th>
								<th class="right"><?php _e( 'Price', 'tesseract' ); ?></th>
							</tr>
						</thead>
						<tfoot>
							<td></td>
							<td><?php echo WC()->cart->cart_contents_count; ?></td>
							<td class="right"><?php echo WC()->cart->get_cart_total(); ?></td>
						</tfoot>
						<tbody>
							<?php
							foreach (WC()->cart->cart_contents as $product) {
								echo '<tr>'.
								'<td>'.$product['data']->post->post_name.'</td>'.
								'<td>'.$product['quantity'].'</td>'.
								'<td class="right">' . intval( $product['quantity'] ) * intval( $product['data']->price ) . get_woocommerce_currency() . '</td>'.
								'</tr>';
							}
							?>
						</tbody>
					</table>
				<?php } ?>
				<a href="<?php echo WC()->cart->get_cart_url(); ?>"><?php _e( 'View Cart', 'tessearact' ); ?> (<?php echo WC()->cart->cart_contents_count; ?> <?php _e( 'Items', 'tesseract' ); ?>)</a>
			</div>
		</div>
	</div>
	<?php
	$fragments['.woocart-header'] = ob_get_clean();

	return $fragments;
} // END tesseract_wc_header_add_to_cart_fragment()

// Output shopping cart in header
function tesseract_wc_output_cart() {
	ob_start();
	?>
	<div class="woocart-header">
		<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>">
			<span class="dashicons dashicons-arrow-down cart-arrow"></span>
			<span class="cart-contents-counter"><?php echo WC()->cart->cart_contents_count; ?></span>
			<span class="icon-shopping-cart"></span>
		</a>
		<div class="cart-content-details-wrap">
			<div class="cart-content-details">
				<?php if (WC()->cart->cart_contents_count == 0) { ?>
					<span><?php _e( 'Your Shopping Cart is empty.', 'tesseract' ); ?></span>
				<?php } else { ?>
					<table class="cart-content-details-table">
						<thead>
							<tr>
								<th><?php _e( 'Product Name', 'tesseract' ); ?></th>
								<th><?php _e( 'Quantity', 'tesseract' ); ?></th>
								<th class="right"><?php _e( 'Price', 'tesseract' ); ?></th>
							</tr>
						</thead>
						<tfoot>
							<td></td>
							<td><?php echo WC()->cart->cart_contents_count; ?></td>
							<td class="right"><?php echo WC()->cart->get_cart_total(); ?></td>
						</tfoot>
						<tbody>
							<?php
							foreach (WC()->cart->cart_contents as $product) {
								echo '<tr>'.
								'<td>'.$product['data']->post->post_name.'</td>'.
								'<td>'.$product['quantity'].'</td>'.
								'<td class="right">' . intval( $product['quantity'] ) * intval( $product['data']->price ) . get_woocommerce_currency() . '</td>'.
								'</tr>';
							}
							?>
						</tbody>
					</table>
				<?php } ?>
				<a href="<?php echo WC()->cart->get_cart_url(); ?>"><?php _e( 'View Cart', 'tesseract' ); ?> (<?php echo WC()->cart->cart_contents_count; ?> <?php _e( 'Items', 'tesseract' ); ?>)</a>
			</div>
		</div>
	</div>
	<?php
	$output = ob_get_contents();

	ob_end_clean();

	echo $output;
} // END tesseract_wc_output_cart()

// Display 12 products per page.
add_filter('loop_shop_per_page', create_function('$cols', 'return 12;'), 20);
