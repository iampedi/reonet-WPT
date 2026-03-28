<?php

/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

use Automattic\WooCommerce\Enums\ProductType;

if (! defined('ABSPATH')) {
	exit;
}

global $product;
$start_meta = '';
ob_start();
do_action('woocommerce_product_meta_start');
$start_meta = trim(ob_get_clean());

$sku_html = '';
if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type(ProductType::VARIABLE))) {
	$sku = $product->get_sku();
	$sku_html = '<span class="sku_wrapper">' . esc_html__('SKU:', 'woocommerce') . ' <span class="sku">' . ($sku ? $sku : esc_html__('N/A', 'woocommerce')) . '</span></span>';
}

$tags_html = wc_get_product_tag_list(
	$product->get_id(),
	', ',
	'<span class="tagged_as">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'woocommerce') . ' ',
	'</span>'
);

$end_meta = '';
ob_start();
do_action('woocommerce_product_meta_end');
$end_meta = trim(ob_get_clean());

$has_content = '' !== trim(wp_strip_all_tags($start_meta . $sku_html . $tags_html . $end_meta));

if (! $has_content) {
	return;
}
?>
<div class="product_meta">
	<?php echo $start_meta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php echo wp_kses_post($sku_html); ?>
	<?php echo wp_kses_post($tags_html); ?>
	<?php echo $end_meta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
