<?php

/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if (! defined('ABSPATH')) {
	exit;
}

$gateway_id          = (string) $gateway->id;
$leading_icon_class  = function_exists('reonet_woocommerce_payment_method_icon_class') ? reonet_woocommerce_payment_method_icon_class($gateway_id) : 'ph-wallet';
$payment_brand_icons = $gateway->get_icon();
?>
<div class="wc_payment_method reonet-payment-method payment_method_<?php echo esc_attr($gateway_id); ?>">
	<label for="payment_method_<?php echo esc_attr($gateway_id); ?>" class="_reonet_payment_method_label flex cursor-pointer items-center gap-3 pb-2">
		<span class="reonet-payment-method-content flex min-w-0 flex-1 items-center justify-between gap-3">
			<span class="reonet-payment-method-main flex min-w-0 items-center gap-2.5">
				<i class="ph-duotone <?php echo esc_attr($leading_icon_class); ?> reonet-payment-method-leading-icon text-3xl text-green"></i>
				<span class="truncate font-medium text-gray-900"><?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></span>
			</span>
			<span class="reonet-payment-method-brand-icons shrink-0"><?php echo $payment_brand_icons; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></span>
		</span>
		<input id="payment_method_<?php echo esc_attr($gateway_id); ?>" type="radio" class="<?php echo esc_attr(reonet_flowbite_checkbox_class_string()); ?>" name="payment_method" value="<?php echo esc_attr($gateway_id); ?>" <?php checked($gateway->chosen, true); ?> data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>" />
	</label>
	<?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
		<div class="payment_box text-[15px] border-t border-gray-200 pt-2 text-gray-500 leading-tight payment_method_<?php echo esc_attr($gateway_id); ?>" <?php if (! $gateway->chosen) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;" <?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>
</div>