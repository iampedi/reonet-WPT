<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
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
