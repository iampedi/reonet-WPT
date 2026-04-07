<?php

/**
 * Custom Related Products Section
 *
 * Theme-controlled related products renderer for full markup customization.
 *
 * @package WooCommerce\Templates
 */

defined('ABSPATH') || exit;

if (empty($related_products) || !is_array($related_products)) {
	return;
}

global $product;
$previous_product = $product;
?>
<section class="_related-products mt-8 space-y-4 sm:mt-12 col-span-7">
	<div class="flex items-center justify-between gap-3">
		<h2 class="text-2xl font-semibold text-primary">
			<?php echo esc_html(isset($section_title) && $section_title ? $section_title : __('Related products', 'woocommerce')); ?>
		</h2>
	</div>

	<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
		<?php foreach ($related_products as $related_product) : ?>
			<?php
			if (!$related_product instanceof WC_Product || !$related_product->is_visible()) {
				continue;
			}

			$product   = $related_product;
			$permalink = $product->get_permalink();
			$image_html = $product->get_image(
				'woocommerce_thumbnail',
				array('class' => 'h-full w-full object-cover duration-300 group-hover:scale-105')
			);
			$title      = $product->get_name();
			$price_html = $product->get_price_html();

			ob_start();
			woocommerce_template_loop_add_to_cart(
				array(
					'class' => 'button inline-flex h-10 items-center justify-center rounded-full bg-primary px-4 text-sm font-medium text-white duration-300 hover:bg-green',
				)
			);
			$add_to_cart_html = ob_get_clean();
			?>
			<article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white">
				<a href="<?php echo esc_url($permalink); ?>" class="relative block aspect-[4/3] overflow-hidden bg-gray-100">
					<?php if ($product->is_on_sale()) : ?>
						<span class="absolute left-3 top-3 z-10 rounded-full bg-rose-500 px-2 py-1 text-xs font-semibold text-white">
							<?php esc_html_e('Sale', 'woocommerce'); ?>
						</span>
					<?php endif; ?>
					<?php echo wp_kses_post($image_html); ?>
				</a>

				<div class="space-y-3 p-4">
					<h3 class="text-lg font-semibold leading-tight">
						<a href="<?php echo esc_url($permalink); ?>" class="duration-200 hover:text-green">
							<?php echo esc_html($title); ?>
						</a>
					</h3>

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
		<?php endforeach; ?>
	</div>
</section>
<?php
$product = $previous_product;
?>