<?php

/**
 * Order Customer Details
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined('ABSPATH') || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce_customer_details sm:col-span-3">
	<?php if ($show_shipping) : ?>
		<div class="woocommerce-columns_addresses grid sm:grid-cols-2 gap-6">
			<div class="card woocommerce_column_billing_address overflow-hidden">
			<?php else : ?>
				<div class="card wa-inline-card woocommerce-column_billing_address overflow-hidden">
				<?php endif; ?>

				<div class="card-head">
					<h2 class="woocommerce-column__title"><?php esc_html_e('Billing address', 'woocommerce'); ?></h2>
				</div>
				<address class="card-body space-y-2 leading-relaxed not-italic text-gray-700">
					<?php echo wp_kses_post($order->get_formatted_billing_address(esc_html__('N/A', 'woocommerce'))); ?>

					<?php if ($order->get_billing_phone()) : ?>
						<p class="woocommerce-customer-details--phone m-0"><?php echo esc_html($order->get_billing_phone()); ?></p>
					<?php endif; ?>

					<?php if ($order->get_billing_email()) : ?>
						<p class="woocommerce-customer-details--email m-0"><?php echo esc_html($order->get_billing_email()); ?></p>
					<?php endif; ?>

					<?php do_action('woocommerce_order_details_after_customer_address', 'billing', $order); ?>
				</address>
				</div>

				<?php if ($show_shipping) : ?>
					<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2 overflow-hidden card">
						<div class="card-head">
							<h2 class="woocommerce-column__title"><?php esc_html_e('Shipping address', 'woocommerce'); ?></h2>
						</div>
						<address class="card-body space-y-2 text-sm leading-relaxed not-italic text-gray-700">
							<?php echo wp_kses_post($order->get_formatted_shipping_address(esc_html__('N/A', 'woocommerce'))); ?>

							<?php if ($order->get_shipping_phone()) : ?>
								<p class="woocommerce-customer-details--phone m-0"><?php echo esc_html($order->get_shipping_phone()); ?></p>
							<?php endif; ?>

							<?php do_action('woocommerce_order_details_after_customer_address', 'shipping', $order); ?>
						</address>
					</div>
			</div>
		<?php endif; ?>

		<?php do_action('woocommerce_order_details_after_customer_details', $order); ?>
</section>