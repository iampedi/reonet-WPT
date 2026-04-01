<?php

/**
 * Single variation cart button
 *
 * Theme override that removes WooCommerce's default quantity field for variable products.
 *
 * @package WooCommerce\Templates
 * @version 10.5.2
 */

defined('ABSPATH') || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	<div class="pt-4">
		<button type="submit" class="single_add_to_cart_button <?php echo esc_attr(reonet_flowbite_button_class_string()); ?>"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
	</div>

	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
