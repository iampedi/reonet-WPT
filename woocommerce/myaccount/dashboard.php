<?php

/**
 * My Account Dashboard
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (!defined('ABSPATH')) {
	exit;
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>

<div class="space-y-4 p-5">
	<h2 class="text-xl font-semibold text-primary"><?php esc_html_e('My account', 'woocommerce'); ?></h2>

	<p class="_after-notices-p mt-3 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm leading-relaxed text-gray-700 [&_a]:font-medium [&_a]:text-primary [&_a]:underline [&_a]:underline-offset-4">
		<?php
		printf(
			wp_kses(__('Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce'), $allowed_html),
			'<strong>' . esc_html($current_user->display_name) . '</strong>',
			esc_url(wc_logout_url())
		);
		?>
	</p>

	<p class="leading-relaxed text-gray-700 [&_a]:text-primary [&_a]:underline">
		<?php
		$dashboard_desc = __('From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce');
		if (wc_shipping_enabled()) {
			$dashboard_desc = __('From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce');
		}

		printf(
			wp_kses($dashboard_desc, $allowed_html),
			esc_url(wc_get_endpoint_url('orders')),
			esc_url(wc_get_endpoint_url('edit-address')),
			esc_url(wc_get_endpoint_url('edit-account'))
		);
		?>
	</p>
</div>

<?php
do_action('woocommerce_account_dashboard');
do_action('woocommerce_before_my_account');
do_action('woocommerce_after_my_account');
