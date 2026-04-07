<?php
/**
 * Single Product Thumbnails
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.8.0
 */

defined('ABSPATH') || exit;

if (!function_exists('wc_get_gallery_image_html')) {
	return;
}

global $product;

if (!$product || !$product instanceof WC_Product) {
	return;
}

$attachment_ids = $product->get_gallery_image_ids();

if ($attachment_ids && $product->get_image_id()) {
	foreach ($attachment_ids as $key => $attachment_id) {
		$thumbnail_html = wc_get_gallery_image_html($attachment_id, false, $key);
		if (function_exists('reonet_woocommerce_prepare_gallery_image_html')) {
			$thumbnail_html = reonet_woocommerce_prepare_gallery_image_html($thumbnail_html, true);
		}

		echo apply_filters('woocommerce_single_product_image_thumbnail_html', $thumbnail_html, $attachment_id); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
