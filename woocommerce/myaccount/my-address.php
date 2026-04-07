<?php

/**
 * My Addresses
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined('ABSPATH') || exit;

$customer_id = get_current_user_id();

if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __('Billing address', 'woocommerce'),
			'shipping' => __('Shipping address', 'woocommerce'),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __('Billing address', 'woocommerce'),
		),
		$customer_id
	);
}

$oldcol = 1;
$col = 1;
?>

<div class="p-5">
	<p class="_my_addresses_description mb-5 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 leading-relaxed text-gray-700">
		<?php echo wp_kses_post(apply_filters('woocommerce_my_account_my_address_description', esc_html__('The following addresses will be used on the checkout page by default.', 'woocommerce'))); ?>
	</p>

	<div class="woocommerce_addresses grid grid-cols-1 gap-4 sm:gap-5 <?php echo (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) ? 'lg:grid-cols-2' : ''; ?>">
		<?php foreach ($get_addresses as $name => $address_title) : ?>
			<?php
			$address = wc_get_account_formatted_address($name);
			$col = $col * -1;
			$oldcol = $oldcol * -1;
			$action_label = $address
				? sprintf(/* translators: %s: Address title */esc_html__('Edit', 'woocommerce'), esc_html($address_title))
				: sprintf(/* translators: %s: Address title */esc_html__('Add', 'woocommerce'), esc_html($address_title));
			$edit_button_class = function_exists('reonet_flowbite_button_class_string')
				? reonet_flowbite_button_class_string('secondary', 'sm')
				: 'inline-flex items-center justify-center rounded-full border border-gray-300 px-4 py-2 text-xs font-medium text-gray-700';
			?>

			<div class="u-column<?php echo $col < 0 ? 1 : 2; ?> col-<?php echo $oldcol < 0 ? 1 : 2; ?> woocommerce-Address space-y-3 rounded-xl border border-gray-200 bg-white p-4 sm:p-5">
				<header class="woocommerce-Address-title title flex items-center justify-between gap-3">
					<h2 class="text-lg font-semibold text-primary"><?php echo esc_html($address_title); ?></h2>
					<a href="<?php echo esc_url(wc_get_endpoint_url('edit-address', $name)); ?>" class="<?php echo esc_attr($edit_button_class); ?>">
						<?php echo esc_html($action_label); ?>
					</a>
				</header>

				<address class="not-italic leading-relaxed text-gray-700 [&_p]:m-0">
					<?php
					if ($address) {
						echo wp_kses_post($address);
					} else {
						esc_html_e('You have not set up this type of address yet.', 'woocommerce');
					}

					do_action('woocommerce_my_account_after_my_address', $name);
					?>
				</address>
			</div>
		<?php endforeach; ?>
	</div>
</div>