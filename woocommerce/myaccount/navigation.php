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
?>

<nav class="woocommerce-MyAccount-navigation rounded-2xl border border-gray-200 bg-white p-4 sm:p-6" aria-label="<?php esc_html_e('Account pages', 'woocommerce'); ?>">
	<ul class="m-0 list-none space-y-2 p-0">
		<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
			<?php
			$is_current   = wc_is_current_account_menu_item($endpoint);
			$item_classes = wc_get_account_menu_item_classes($endpoint);
			$link_classes = 'flex h-10 items-center rounded-lg px-3 duration-200';
			$link_classes .= $is_current ? ' bg-primary text-white' : ' text-primary hover:bg-gray-100';
			?>
			<li class="<?php echo esc_attr($item_classes); ?>">
				<a class="<?php echo esc_attr($link_classes); ?>" href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" <?php echo $is_current ? 'aria-current="page"' : ''; ?>>
					<?php echo esc_html($label); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
