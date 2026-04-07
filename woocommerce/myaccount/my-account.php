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
<div class="container">
	<div class="grid grid-cols-1 items-start lg:grid-cols-[260px_minmax(0,1fr)] gap-6">
		<?php do_action('woocommerce_account_navigation'); ?>

		<div class="woocommerce-my-account-content rounded-2xl border border-gray-200 bg-white">
			<?php do_action('woocommerce_account_content'); ?>
		</div>
	</div>
</div>