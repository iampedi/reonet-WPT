<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined('ABSPATH') || exit;

?>
<div class="container py-8 sm:py-12">
	<div class="grid grid-cols-1 lg:grid-cols-[260px_minmax(0,1fr)] gap-6">
	<?php do_action('woocommerce_account_navigation'); ?>

	<div class="woocommerce-MyAccount-content space-y-5 rounded-2xl border border-gray-200 bg-white p-4 sm:p-6">
		<?php do_action('woocommerce_account_content'); ?>
	</div>
	</div>
</div>
