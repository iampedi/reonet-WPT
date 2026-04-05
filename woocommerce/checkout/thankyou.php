<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order reonet-order-received-page space-y-6">
	<header class="_reonet_checkout_header flex flex-wrap items-center justify-between gap-3 border-y border-dashed border-primary/20 bg-blue-50/35 px-3 py-2.5">
		<h1 class="flex items-center gap-3 text-2xl font-medium text-primary">
			<i class="ph-duotone ph-check-circle text-3xl text-green"></i>
			<?php esc_html_e('Order received', 'woocommerce'); ?>
		</h1>
		<p class="text-gray-600"><?php reonet_esc_html_tr_e('Thank you for your purchase. Your order details are below.', 'woocommerce'); ?></p>
	</header>

	<?php
	if ($order) :

		do_action('woocommerce_before_thankyou', $order->get_id());
	?>
		<div class="grid sm:grid-cols-3 gap-6 items-start">

			<?php if ($order->has_status('failed')) : ?>
				<div class="space-y-4 rounded-2xl border border-danger/30 bg-rose-50 p-4 sm:p-6">
					<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

					<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions m-0 flex flex-wrap gap-3">
						<a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay inline-flex h-10 items-center justify-center rounded-full border-0 bg-primary px-5 text-white duration-300 hover:bg-green"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
						<?php if (is_user_logged_in()) : ?>
							<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay inline-flex h-10 items-center justify-center rounded-full border-0 bg-primary px-5 text-white duration-300 hover:bg-green"><?php esc_html_e('My account', 'woocommerce'); ?></a>
						<?php endif; ?>
					</p>
				</div>

			<?php else : ?>

				<div>
					<?php wc_get_template('checkout/order-received.php', array('order' => $order)); ?>

					<section class="_reonet_order_overview_panel overflow-hidden card">
						<div class="card-head">
							<h2><?php esc_html_e('Order summary', 'woocommerce'); ?></h2>
						</div>

						<div class="woocommerce-order-overview woocommerce-thankyou-order-details order_details card-body py-2! [&>div]:border-b [&>div]:border-dashed [&>div]:last:border-b-0 [&>div]:border-gray-200 [&>div]:py-2.5 flex flex-col text-[15px]">
							<div class="flex items-center gap-2">
								<span class="inline-flex items-center gap-2.5 text-gray-500"><i class="ph-duotone ph-hash text-2xl"></i><?php esc_html_e('Order number:', 'woocommerce'); ?></span>
								<span><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
											?></span>
							</div>

							<div class="flex items-center gap-2">
								<span class="inline-flex items-center gap-2.5 text-gray-500"><i class="ph-duotone ph-calendar-blank text-2xl"></i><?php esc_html_e('Date:', 'woocommerce'); ?></span>
								<span><?php echo wc_format_datetime($order->get_date_created()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
											?></span>
							</div>

							<?php if ($order->get_formatted_billing_full_name()) : ?>
								<div class="flex items-center gap-2">
									<span class="inline-flex items-center gap-2.5 text-gray-500"><i class="ph-duotone ph-user text-2xl"></i><?php esc_html_e('Name', 'woocommerce'); ?>:</span>
									<span><?php echo esc_html($order->get_formatted_billing_full_name()); ?></span>
								</div>
							<?php endif; ?>

							<?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
								<div class="flex items-center gap-2">
									<span class="inline-flex items-center gap-2.5 text-gray-500"><i class="ph-duotone ph-envelope-simple text-2xl"></i><?php esc_html_e('Email', 'woocommerce'); ?>:</span>
									<span><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
												?></span>
								</div>
							<?php endif; ?>

							<?php if ($order->get_billing_phone()) : ?>
								<div class="flex items-center gap-2">
									<span class="inline-flex items-center gap-2.5 text-gray-500"><i class="ph-duotone ph-phone text-2xl"></i><?php esc_html_e('Phone', 'woocommerce'); ?>:</span>
									<span><?php echo esc_html($order->get_billing_phone()); ?></span>
								</div>
							<?php endif; ?>

							<?php if ($order->get_payment_method_title()) : ?>
								<div class="woocommerce-order-overview__payment-method method flex items-center gap-2">
									<span class="inline-flex items-center gap-2.5 text-gray-500"><i class="ph-duotone ph-credit-card text-2xl"></i><?php esc_html_e('Payment method', 'woocommerce'); ?>:</span>
									<span><?php echo wp_kses_post($order->get_payment_method_title()); ?></span>
								</div>
							<?php endif; ?>

							<?php if ($order->get_shipping_method()) : ?>
								<div class="woocommerce-order-overview__shipping-method shipping flex items-center gap-2">
									<span class="inline-flex items-center gap-2.5 text-gray-500"><i class="ph-duotone ph-truck text-2xl"></i><?php reonet_esc_html_tr_e('Shipping method'); ?>:</span>
									<span><?php echo wp_kses_post($order->get_shipping_method()); ?></span>
								</div>
							<?php endif; ?>

							<?php
							$formatted_billing_address  = (string) $order->get_formatted_billing_address();
							$formatted_shipping_address = (string) $order->get_formatted_shipping_address();
							$billing_full_name          = trim((string) $order->get_formatted_billing_full_name());
							$shipping_full_name         = trim((string) $order->get_formatted_shipping_full_name());

							$remove_name_from_address = static function ($address_html, $full_name) {
								$address_html = (string) $address_html;
								$full_name    = trim((string) $full_name);

								if ($address_html === '' || $full_name === '') {
									return $address_html;
								}

								$address_lines = preg_split('/<br\s*\/?>/i', $address_html);
								if (! is_array($address_lines) || ! isset($address_lines[0])) {
									return $address_html;
								}

								$first_line = trim(wp_strip_all_tags($address_lines[0]));
								if (strcasecmp($first_line, $full_name) !== 0) {
									return $address_html;
								}

								array_shift($address_lines);

								return implode('<br/>', $address_lines);
							};

							$display_billing_address  = $remove_name_from_address($formatted_billing_address, $billing_full_name);
							$display_shipping_address = $remove_name_from_address(
								$formatted_shipping_address,
								$shipping_full_name ? $shipping_full_name : $billing_full_name
							);

							$normalized_billing_address = strtolower(trim(wp_strip_all_tags(str_replace(array('<br/>', '<br>', '<br />'), ' ', $display_billing_address))));
							$normalized_shipping_address = strtolower(trim(wp_strip_all_tags(str_replace(array('<br/>', '<br>', '<br />'), ' ', $display_shipping_address))));
							$is_same_shipping_as_billing = $normalized_billing_address !== '' && $normalized_billing_address === $normalized_shipping_address;
							?>

							<?php if ($display_billing_address) : ?>
								<div class="woocommerce-order-overview__billing-address billing flex items-start gap-2">
									<span class="inline-flex items-center gap-2.5 text-gray-500"><i class="ph-duotone ph-house text-2xl"></i><?php esc_html_e('Billing address', 'woocommerce'); ?>:</span>
									<span class="leading-relaxed [&_br]:block"><?php echo wp_kses_post($display_billing_address); ?></span>
								</div>
							<?php endif; ?>

							<?php if (! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && $display_shipping_address && ! $is_same_shipping_as_billing) : ?>
								<div class="woocommerce-order-overview__shipping-address shipping flex items-start gap-2">
									<span class="inline-flex items-center gap-2.5 text-gray-500"><i class="ph-duotone ph-map-pin-line text-2xl"></i><?php esc_html_e('Shipping address', 'woocommerce'); ?>:</span>
									<span class="leading-relaxed [&_br]:block"><?php echo wp_kses_post($display_shipping_address); ?></span>
								</div>
							<?php endif; ?>

							<div class="woocommerce-order-overview__total total flex items-center gap-2">
								<span class="inline-flex items-center gap-2.5 text-gray-500"><i class="ph-duotone ph-coins text-2xl"></i><?php esc_html_e('Total', 'woocommerce'); ?>:</span>
								<span><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
											?></span>
							</div>
						</div>
					</section>



				</div>
				<?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>

				<?php do_action('woocommerce_thankyou', $order->get_id()); ?>
			<?php endif; ?>



		</div>

	<?php else : ?>
		<?php wc_get_template('checkout/order-received.php', array('order' => false)); ?>
	<?php endif; ?>
</div>