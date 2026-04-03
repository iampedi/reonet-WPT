<?php

/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined('ABSPATH') || exit;

?>
<div class="cart_totals rounded-2xl border border-primary/20 border-dashed bg-white sticky top-4 <?php echo (WC()->customer->has_calculated_shipping()) ? 'calculated_shipping' : ''; ?>">

	<?php do_action('woocommerce_before_cart_totals'); ?>

	<h2 class="text-xl px-4 py-3 font-medium text-primary border-b-2 border-primary/10">
		<?php esc_html_e('Cart totals', 'woocommerce'); ?>
	</h2>

	<div class="shop_table shop_table_responsive overflow-hidden divide-y divide-primary/20 border-b border-primary/20">
		<div class="cart-subtotal flex items-center justify-between gap-3 px-4 py-3">
			<div class="font-medium text-gray-700"><?php esc_html_e('Subtotal', 'woocommerce'); ?></div>
			<div class="text-right"><?php wc_cart_totals_subtotal_html(); ?></div>
		</div>

		<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?> flex items-start justify-between gap-3 p-3">
				<div class="font-medium text-gray-700"><?php wc_cart_totals_coupon_label($coupon); ?></div>
				<div class="text-right"><?php wc_cart_totals_coupon_html($coupon); ?></div>
			</div>
		<?php endforeach; ?>

		<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
			<?php do_action('woocommerce_cart_totals_before_shipping'); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action('woocommerce_cart_totals_after_shipping'); ?>
		<?php endif; ?>

		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<div class="fee flex flex-col items-start justify-between gap-3 p-3">
				<div class="font-medium text-gray-700"><?php echo esc_html($fee->name); ?></div>
				<div class="text-right"><?php wc_cart_totals_fee_html($fee); ?></div>
			</div>
		<?php endforeach; ?>

		<?php
		if (wc_tax_enabled() && ! WC()->cart->display_prices_including_tax()) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if (WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()) {
				/* translators: %s location. */
				$estimated_text = sprintf(' <small>' . esc_html__('(estimated for %s)', 'woocommerce') . '</small>', WC()->countries->estimated_for_prefix($taxable_address[0]) . WC()->countries->countries[$taxable_address[0]]);
			}

			if ('itemized' === get_option('woocommerce_tax_total_display')) {
				foreach (WC()->cart->get_tax_totals() as $code => $tax) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		?>
					<div class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?> flex items-start justify-between gap-3 p-3">
						<div class="font-medium text-gray-700"><?php echo esc_html($tax->label) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																										?></div>
						<div class="text-right"><?php echo wp_kses_post($tax->formatted_amount); ?></div>
					</div>
				<?php
				}
			} else {
				?>
				<div class="tax-total flex items-start justify-between gap-3 p-3">
					<div class="font-medium text-gray-700"><?php echo esc_html(WC()->countries->tax_or_vat()) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																									?></div>
					<div class="text-right"><?php wc_cart_totals_taxes_total_html(); ?></div>
				</div>
		<?php
			}
		}
		?>

		<?php do_action('woocommerce_cart_totals_before_order_total'); ?>

		<div class="order-total flex items-start justify-between gap-3 bg-primary/5 p-3 text-base font-semibold text-primary">
			<div><?php esc_html_e('Total', 'woocommerce'); ?></div>
			<div class="text-right flex flex-col items-end leading-tight [&_small]:font-normal [&_strong]:text-primary [&_.woocommerce-Price-amount]:font-normal [&_.includes_tax]:mt-1 [&_.includes_tax]:text-xs [&_.includes_tax]:font-normal [&_.includes_tax]:text-gray-500">
				<?php wc_cart_totals_order_total_html(); ?>
			</div>
		</div>

		<?php do_action('woocommerce_cart_totals_after_order_total'); ?>
	</div>

	<div class="wc-proceed-to-checkout p-4">
		<?php do_action('woocommerce_proceed_to_checkout'); ?>
	</div>

	<?php do_action('woocommerce_after_cart_totals'); ?>

</div>
