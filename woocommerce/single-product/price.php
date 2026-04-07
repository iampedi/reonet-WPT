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

// Fallback for variable products: if parent price HTML is empty, build a
// default display price (range or single) from variation min/max prices.
if ($price_html === '' && $product->is_type('variable')) {
	$variation_prices = $product->get_variation_prices(true);
	$variation_price_values = array();

	if (isset($variation_prices['price']) && is_array($variation_prices['price'])) {
		foreach ($variation_prices['price'] as $raw_price) {
			if ($raw_price === '' || $raw_price === null) {
				continue;
			}

			$variation_price_values[] = (float) $raw_price;
		}
	}

	if (!empty($variation_price_values)) {
		$min_price = min($variation_price_values);
		$max_price = max($variation_price_values);

		if (abs($min_price - $max_price) > 0.00001) {
			$price_html = wc_format_price_range(wc_price($min_price), wc_price($max_price));
		} else {
			$price_html = wc_price($min_price);
		}

		$price_html .= $product->get_price_suffix();
		$price_html = apply_filters('woocommerce_get_price_html', $price_html, $product);
	}
}

if ($price_html === '') {
	return;
}
?>
<div class="_product-price" data-default-price="<?php echo esc_attr(wp_json_encode($price_html)); ?>">
	<p class="<?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>">
		<?php echo wp_kses_post($price_html); ?>
	</p>
</div>
