<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if (! defined('ABSPATH')) {
	exit;
}
do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}
?>

<div class="_reonet_checkout_page mb-8 space-y-6">
	<header class="_reonet_checkout_header flex items-center justify-between border-y border-dashed border-primary/20 bg-blue-50/35 px-3 py-2.5">
		<h1 class="flex items-center gap-3 text-2xl font-medium text-primary">
			<i class="ph-duotone ph-credit-card text-3xl text-green"></i>
			<?php reonet_esc_html_tr_e('Checkout'); ?>
		</h1>
		<p class="text-gray-600"><?php reonet_esc_html_tr_e('Review your details and confirm your order.'); ?></p>
	</header>

	<section class="_reonet_checkout_login_wrapper">
		<?php woocommerce_checkout_login_form(); ?>
	</section>

	<form name="checkout" method="post" class="checkout woocommerce-checkout reonet-checkout-form" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data" aria-label="<?php echo reonet_esc_attr_tr('Checkout'); ?>">
		<div class="_reonet-checkout-content-layout grid grid-cols-1 items-start gap-6 lg:grid-cols-12">
			<section class="_reonet_checkout_details space-y-4 lg:col-span-8">
				<?php if ($checkout->get_checkout_fields()) : ?>

					<?php do_action('woocommerce_checkout_before_customer_details'); ?>

					<div id="customer_details">
						<section class="reonet-checkout-panel reonet-checkout-billing">
							<?php do_action('woocommerce_checkout_billing'); ?>
						</section>

						<section class="_reonet_checkout_panel _reonet_checkout_shipping space-y-4">
							<?php do_action('woocommerce_checkout_shipping'); ?>
						</section>
					</div>

					<?php do_action('woocommerce_checkout_after_customer_details'); ?>

				<?php endif; ?>
			</section>

			<aside class="reonet-checkout-summary space-y-4 lg:col-span-4">
				<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

				<?php do_action('woocommerce_checkout_before_order_review'); ?>

				<div id="order_review" class="woocommerce-checkout-review-order _reonet_checkout_order_review space-y-4">
					<?php do_action('woocommerce_checkout_order_review'); ?>
				</div>

				<?php do_action('woocommerce_checkout_after_order_review'); ?>
			</aside>
		</div>
	</form>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>