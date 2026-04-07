<?php

/**
 * Single variation cart button
 *
 * Theme override for variable add-to-cart button.
 *
 * @package WooCommerce\Templates
 * @version 10.5.2
 */

defined('ABSPATH') || exit;

global $product;

$is_measurement_pricing = function_exists('reonet_is_measurement_pricing_enabled_for_product')
	? reonet_is_measurement_pricing_enabled_for_product($product)
	: false;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	<?php if ($is_measurement_pricing) : ?>
		<?php
		do_action('woocommerce_before_add_to_cart_quantity');

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
				'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
				'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
			)
		);

		do_action('woocommerce_after_add_to_cart_quantity');
		?>
	<?php else : ?>
		<div class="_variable-total-price total-price mt-3">
			<?php
			do_action('woocommerce_before_add_to_cart_quantity');

			woocommerce_quantity_input(
				array(
					'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
					'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
					'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
				)
			);

			do_action('woocommerce_after_add_to_cart_quantity');
			?>
			<div class="calculated-price-wrap">
				<span><?php echo reonet_esc_html_tr('Calculated Price'); ?>:</span>
				<span class="_variable-calculated-price calculated-price" data-currency-symbol="<?php echo esc_attr(get_woocommerce_currency_symbol()); ?>" data-price-decimals="<?php echo esc_attr((string) wc_get_price_decimals()); ?>">-</span>
			</div>
		</div>
	<?php endif; ?>

	<div class="pt-6">
		<button type="submit" class="single_add_to_cart_button <?php echo esc_attr(reonet_flowbite_button_class_string()); ?>"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
	</div>

	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>