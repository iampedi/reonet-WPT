<?php

/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.8.0
 */

defined('ABSPATH') || exit;

if (! wc_coupons_enabled()) { // @codingStandardsIgnoreLine.
	return;
}

?>
<form class="checkout_coupon woocommerce-form-coupon _checkout-coupon-form flex flex-col gap-2 sm:flex-row sm:items-center" method="post" id="woocommerce-checkout-form-coupon">
	<div class="form-row form-row-first m-0 flex-1">
		<label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
		<input type="text" name="coupon_code" class="text-center <?php echo esc_attr(reonet_flowbite_input_class_string()); ?>" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" id="coupon_code" value="" />
	</div>

	<button type="submit" class="<?php echo esc_attr(reonet_flowbite_button_class_string('secondary', 'icon')); ?>" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><i class="ph-bold ph-check text-xl"></i></button>
</form>