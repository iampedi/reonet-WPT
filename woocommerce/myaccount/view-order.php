<?php

/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.6.0
 */

defined('ABSPATH') || exit;

$notes = $order->get_customer_order_notes();
?>
<div class="_view_order_status flex items-center justify-between px-5 py-4.5">
	<p class="leading-relaxed text-gray-700 [&_.order-number]:font-semibold [&_.order-date]:font-medium [&_.order-status]:font-semibold [&_.order-status]:text-primary">
		<?php
		echo wp_kses_post(
			/**
			 * Filter to modify order details status text.
			 *
			 * @param string $order_status The order status text.
			 *
			 * @since 10.1.0
			 */
			apply_filters(
				'woocommerce_order_details_status',
				sprintf(
					/* translators: 1: order number 2: order date 3: order status */
					esc_html__('Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce'),
					'<mark class="order-number">' . $order->get_order_number() . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<mark class="order-date">' . wc_format_datetime($order->get_date_created()) . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<mark class="order-status">' . wc_get_order_status_name($order->get_status()) . '</mark>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				),
				$order
			)
		);
		?>
	</p>

	<a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" aria-label="<?php esc_attr_e('Back to orders', 'woocommerce'); ?>">
		<i class="ph ph-arrow-right text-xl text-muted-forground hover:text-primary duration-300"></i>
	</a>
</div>

<?php if ($notes) : ?>
	<h2><?php esc_html_e('Order updates', 'woocommerce'); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ($notes as $note) : ?>
			<li class="woocommerce-OrderUpdate comment note">
				<div class="woocommerce-OrderUpdate-inner comment_container">
					<div class="woocommerce-OrderUpdate-text comment-text">
						<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n(esc_html__('l jS \o\f F Y, h:ia', 'woocommerce'), strtotime($note->comment_date)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																													?></p>
						<div class="woocommerce-OrderUpdate-description description">
							<?php echo wp_kses_post(wpautop(wptexturize($note->comment_content))); ?>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action('woocommerce_view_order', $order_id); ?>
