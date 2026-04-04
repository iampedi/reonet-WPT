<?php

/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-billing-fields card">
	<div class="card-head">
		<?php if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>
			<h3><?php esc_html_e('Billing &amp; Shipping', 'woocommerce'); ?></h3>
		<?php else : ?>
			<h3><?php esc_html_e('Billing details', 'woocommerce'); ?></h3>
		<?php endif; ?>
	</div>


	<?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

	<div class="woocommerce-billing-fields__field-wrapper card-body">
		<?php
		$fields = $checkout->get_checkout_fields('billing');

		foreach ($fields as $key => $field) {
			woocommerce_form_field($key, $field, $checkout->get_value($key));
		}
		?>
	</div>

	<?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if (! is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
	<div class="woocommerce-account-fields card mt-4 p-4 sm:p-5">
		<?php if (! $checkout->is_registration_required()) : ?>
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox flex items-center gap-3 text-[15px] text-primary font-medium">
				<input class="<?php echo esc_attr(reonet_flowbite_checkbox_class_string()); ?>" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> type="checkbox" name="createaccount" value="1" /> <span><?php reonet_esc_html_tr_e('Create an account to track your orders and manage your payment history.'); ?></span>
			</label>
		<?php endif; ?>

		<?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

		<?php if ($checkout->get_checkout_fields('account')) : ?>

			<div class="create-account grid grid-cols-1 gap-4 sm:grid-cols-2">
				<?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
					<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
				<?php endforeach; ?>
			</div>

		<?php endif; ?>

		<?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
	</div>
<?php endif; ?>