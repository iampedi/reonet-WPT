<?php
/**
 * Single Product Price
 *
 * Theme override for the main summary price.
 *
 * @package WooCommerce\Templates
 * @version 1.6.4
 */

defined('ABSPATH') || exit;

global $product;

if (! $product instanceof WC_Product) {
	exit;
}

$price_html = $product->get_price_html();

if ($price_html === '') {
	return;
}
?>
<div class="reonet-product-price" data-default-price="<?php echo esc_attr(wp_json_encode($price_html)); ?>">
	<p class="<?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>">
		<?php echo wp_kses_post($price_html); ?>
	</p>
</div>
