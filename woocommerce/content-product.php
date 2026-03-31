<?php
/**
 * Product card in loops.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined('ABSPATH') || exit;

global $product;

if (!is_a($product, WC_Product::class) || !$product->is_visible()) {
	return;
}

$product_id  = $product->get_id();
$permalink   = $product->is_visible() ? $product->get_permalink() : '';
$image_html  = $product->get_image('woocommerce_thumbnail', array('class' => 'h-full w-full object-cover duration-300 group-hover:scale-105'));
$title       = $product->get_name();
$price_html  = $product->get_price_html();
$rating_html = wc_get_rating_html($product->get_average_rating());

ob_start();
woocommerce_template_loop_add_to_cart(
	array(
		'class' => 'button inline-flex h-10 items-center justify-center rounded-full bg-primary px-4 text-sm font-medium text-white duration-300 hover:bg-green',
	)
);
$add_to_cart_html = ob_get_clean();
?>
<li <?php wc_product_class('group list-none', $product); ?>>
	<article class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
		<a href="<?php echo esc_url($permalink); ?>" class="relative block aspect-[4/3] overflow-hidden bg-gray-100">
			<?php if ($product->is_on_sale()) : ?>
				<span class="absolute left-3 top-3 z-10 rounded-full bg-rose-500 px-2 py-1 text-xs font-semibold text-white">
					<?php esc_html_e('Sale', 'woocommerce'); ?>
				</span>
			<?php endif; ?>
			<?php echo wp_kses_post($image_html); ?>
		</a>

		<div class="space-y-3 p-4">
			<h2 class="text-lg font-semibold leading-tight">
				<a href="<?php echo esc_url($permalink); ?>" class="hover:text-green duration-200">
					<?php echo esc_html($title); ?>
				</a>
			</h2>

			<?php if ($rating_html) : ?>
				<div class="woocommerce-product-rating text-sm">
					<?php echo wp_kses_post($rating_html); ?>
				</div>
			<?php endif; ?>

			<?php if ($price_html) : ?>
				<div class="price text-lg font-semibold">
					<?php echo wp_kses_post($price_html); ?>
				</div>
			<?php endif; ?>

			<div class="pt-1">
				<?php echo wp_kses_post($add_to_cart_html); ?>
			</div>
		</div>
	</article>
</li>

