<?php

/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-checkout-review-order-table _reonet_checkout_review_card card">
	<div class="card-head">
		<h3 id="order_review_heading"><?php reonet_esc_html_tr_e('Order summary'); ?></h3>
		<p><?php reonet_esc_html_tr_e('A final look at your items before payment.'); ?></p>
	</div>

	<div class="reonet-checkout-review-items card-body p-0! divide-y divide-primary/10">
		<?php
		do_action('woocommerce_review_order_before_cart_contents');

		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

			if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
		?>
				<div class="cart_item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', '', $cart_item, $cart_item_key)); ?> px-5 py-3">

					<div class="product-item min-w-0">
						<div class="flex items-center justify-between gap-3">
							<div class="font-medium text-primary truncate flex-1">
								<?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)); ?>
							</div>
							<div class="flex items-center gap-3">
								<div class="text-sm text-gray-500">
									<?php echo apply_filters('woocommerce_checkout_cart_item_quantity', '<span class="product-quantity">' . sprintf('&times;&nbsp;%s', $cart_item['quantity']) . '</span>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?>
								</div>
								<div class="product-total [&_bdi]:font-medium! [&_bdi]:text-[15px]! min-w-15 ">
									<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?>
								</div>
							</div>
						</div>
					</div>

				</div>
		<?php
			}
		}

		do_action('woocommerce_review_order_after_cart_contents');
		?>
	</div>

	<div class="reonet-checkout-review-totals divide-y divide-primary/20 border-t border-primary/20">
		<div class="cart-subtotal flex items-center justify-between gap-3 px-5 py-3">
			<div class="font-medium text-gray-700"><?php reonet_esc_html_tr_e('Subtotal'); ?></div>
			<div class="text-right"><?php wc_cart_totals_subtotal_html(); ?></div>
		</div>

		<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?> flex items-start justify-between gap-3 px-4 py-3">
				<div class="font-medium text-gray-700"><?php wc_cart_totals_coupon_label($coupon); ?></div>
				<div class="text-right"><?php wc_cart_totals_coupon_html($coupon); ?></div>
			</div>
		<?php endforeach; ?>

		<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
			<?php do_action('woocommerce_review_order_before_shipping'); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action('woocommerce_review_order_after_shipping'); ?>
		<?php endif; ?>

		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<div class="fee flex items-start justify-between gap-3 px-4 py-3">
				<div class="font-medium text-gray-700"><?php echo esc_html($fee->name); ?></div>
				<div class="text-right"><?php wc_cart_totals_fee_html($fee); ?></div>
			</div>
		<?php endforeach; ?>

		<?php if (wc_tax_enabled() && ! WC()->cart->display_prices_including_tax()) : ?>
			<?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
				<?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited 
				?>
					<div class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?> flex items-start justify-between gap-3 px-4 py-3">
						<div class="font-medium text-gray-700"><?php echo esc_html($tax->label); ?></div>
						<div class="text-right"><?php echo wp_kses_post($tax->formatted_amount); ?></div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="tax-total flex items-start justify-between gap-3 px-4 py-3">
					<div class="font-medium text-gray-700"><?php echo esc_html(reonet_woocommerce_tax_or_vat_label()); ?></div>
					<div class="text-right"><?php wc_cart_totals_taxes_total_html(); ?></div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if (wc_coupons_enabled()) : ?>
			<div class="reonet-checkout-coupon-row p-3">
				<?php wc_get_template('checkout/form-coupon.php'); ?>
			</div>
		<?php endif; ?>

		<?php do_action('woocommerce_review_order_before_order_total'); ?>

		<div class="order-total flex items-start justify-between gap-3 bg-primary/5 px-4 py-3 text-base font-semibold text-primary">
			<div><?php reonet_esc_html_tr_e('Total'); ?></div>
			<div class="text-right flex flex-col items-end leading-tight [&_small]:font-normal [&_strong]:text-primary [&_.woocommerce-Price-amount]:font-normal [&_.includes_tax]:mt-1 [&_.includes_tax]:text-xs [&_.includes_tax]:font-normal [&_.includes_tax]:text-gray-500">
				<?php wc_cart_totals_order_total_html(); ?>
			</div>
		</div>

		<?php do_action('woocommerce_review_order_after_order_total'); ?>
	</div>
</div>