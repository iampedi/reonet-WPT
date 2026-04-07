<?php

/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_account_navigation');

$account_menu_icon_map = array(
	'dashboard'       => 'ph-house',
	'orders'          => 'ph-package',
	'downloads'       => 'ph-download-simple',
	'edit-address'    => 'ph-map-pin-line',
	'payment-methods' => 'ph-credit-card',
	'edit-account'    => 'ph-user-circle-gear',
	'customer-logout' => 'ph-sign-out',
);
?>

<nav class="woocommerce-MyAccount-navigation rounded-2xl border border-gray-200 bg-white p-4" aria-label="<?php esc_html_e('Account pages', 'woocommerce'); ?>">
	<ul class="m-0 list-none space-y-2 p-0">
		<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
			<?php
			$is_current   = wc_is_current_account_menu_item($endpoint);
			$item_classes = wc_get_account_menu_item_classes($endpoint);
			$link_classes = 'flex h-11 items-center gap-3 rounded-lg px-3 duration-200';
			$link_classes .= $is_current ? ' bg-primary text-white' : ' text-primary hover:bg-gray-100';
			$icon_class = isset($account_menu_icon_map[$endpoint]) ? $account_menu_icon_map[$endpoint] : 'ph-circle';
			?>
			<li class="<?php echo esc_attr($item_classes); ?>">
				<a class="<?php echo esc_attr($link_classes); ?>" href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" <?php echo $is_current ? 'aria-current="page"' : ''; ?>>
					<i class="ph-duotone <?php echo esc_attr($icon_class); ?> text-2xl" aria-hidden="true"></i>
					<span class="flex leading-none"><?php echo esc_html($label); ?></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>