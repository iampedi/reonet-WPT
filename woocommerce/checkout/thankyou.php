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

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order reonet-order-received-page space-y-6 py-8 sm:py-12">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>
			<div class="space-y-4 rounded-2xl border border-danger/30 bg-rose-50 p-4 sm:p-6">
				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions m-0 flex flex-wrap gap-3">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay inline-flex h-10 items-center justify-center rounded-full border-0 bg-primary px-5 text-white duration-300 hover:bg-green"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay inline-flex h-10 items-center justify-center rounded-full border-0 bg-primary px-5 text-white duration-300 hover:bg-green"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
					<?php endif; ?>
				</p>
			</div>

		<?php else : ?>
			<div class="rounded-2xl border border-green/30 bg-green-50 p-4 sm:p-6">
				<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>
			</div>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details grid grid-cols-1 gap-4 rounded-2xl border border-gray-200 bg-white p-4 sm:grid-cols-2 sm:p-6 xl:grid-cols-5">
				<li class="woocommerce-order-overview__order order list-none rounded-xl border border-gray-200 bg-gray-50 p-3">
					<span class="text-xs uppercase tracking-wide text-gray-500"><?php esc_html_e( 'Order number:', 'woocommerce' ); ?></span>
					<strong class="text-sm sm:text-base"><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date list-none rounded-xl border border-gray-200 bg-gray-50 p-3">
					<span class="text-xs uppercase tracking-wide text-gray-500"><?php esc_html_e( 'Date:', 'woocommerce' ); ?></span>
					<strong class="text-sm sm:text-base"><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email list-none rounded-xl border border-gray-200 bg-gray-50 p-3">
						<span class="text-xs uppercase tracking-wide text-gray-500"><?php esc_html_e( 'Email:', 'woocommerce' ); ?></span>
						<strong class="text-sm sm:text-base"><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total list-none rounded-xl border border-gray-200 bg-gray-50 p-3">
					<span class="text-xs uppercase tracking-wide text-gray-500"><?php esc_html_e( 'Total:', 'woocommerce' ); ?></span>
					<strong class="text-sm sm:text-base"><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method list-none rounded-xl border border-gray-200 bg-gray-50 p-3">
						<span class="text-xs uppercase tracking-wide text-gray-500"><?php esc_html_e( 'Payment method:', 'woocommerce' ); ?></span>
						<strong class="text-sm sm:text-base"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>
			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
