<?php

/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_shipping_calculator'); ?>

<form class="woocommerce-shipping-calculator" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

	<?php printf('<a href="#" class="shipping-calculator-button text-primary underline underline-offset-4 hover:text-green" aria-expanded="false" aria-controls="shipping-calculator-form" role="button">%s</a>', esc_html(! empty($button_text) ? $button_text : __('Calculate shipping', 'woocommerce'))); ?>

	<section class="shipping-calculator-form space-y-2" id="shipping-calculator-form" style="display:none;">

		<?php if (apply_filters('woocommerce_shipping_calculator_enable_country', false)) : ?>
			<p class="form-row form-row-wide" id="calc_shipping_country_field">
				<label for="calc_shipping_country"><?php esc_html_e('Country / region', 'woocommerce'); ?></label>
				<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select <?php echo esc_attr(reonet_flowbite_input_class_string()); ?>" rel="calc_shipping_state">
					<option value="default"><?php esc_html_e('Select a country / region&hellip;', 'woocommerce'); ?></option>
					<?php
					foreach (WC()->countries->get_shipping_countries() as $key => $value) {
						echo '<option value="' . esc_attr($key) . '"' . selected(WC()->customer->get_shipping_country(), esc_attr($key), false) . '>' . esc_html($value) . '</option>';
					}
					?>
				</select>
			</p>
		<?php endif; ?>

		<?php if (apply_filters('woocommerce_shipping_calculator_enable_state', true)) : ?>
			<p class="form-row form-row-wide" id="calc_shipping_state_field">
				<?php
				$current_cc = WC()->customer->get_shipping_country();
				$current_r  = WC()->customer->get_shipping_state();
				$states     = WC()->countries->get_states($current_cc);

				if (is_array($states) && empty($states)) {
				?>
					<input type="hidden" name="calc_shipping_state" id="calc_shipping_state" />
				<?php
				} elseif (is_array($states)) {
				?>
					<span>
						<label for="calc_shipping_state"><?php esc_html_e('State / County', 'woocommerce'); ?></label>
						<select name="calc_shipping_state" class="state_select <?php echo esc_attr(reonet_flowbite_input_class_string()); ?>" id="calc_shipping_state">
							<option value=""><?php esc_html_e('Select an option&hellip;', 'woocommerce'); ?></option>
							<?php
							foreach ($states as $ckey => $cvalue) {
								echo '<option value="' . esc_attr($ckey) . '" ' . selected($current_r, $ckey, false) . '>' . esc_html($cvalue) . '</option>';
							}
							?>
						</select>
					</span>
				<?php
				} else {
				?>
					<label for="calc_shipping_state"><?php esc_html_e('State / County', 'woocommerce'); ?></label>
					<input type="text" class="<?php echo esc_attr(reonet_flowbite_input_class_string()); ?>" value="<?php echo esc_attr($current_r); ?>" name="calc_shipping_state" id="calc_shipping_state" />
				<?php
				}
				?>
			</p>
		<?php endif; ?>

		<?php if (apply_filters('woocommerce_shipping_calculator_enable_city', true)) : ?>
			<p class="form-row form-row-wide" id="calc_shipping_city_field">
				<label for="calc_shipping_city"><?php esc_html_e('City:', 'woocommerce'); ?></label>
				<?php
				$current_city = WC()->customer->get_shipping_city();
				$city_options = function_exists('reonet_woocommerce_checkout_city_options') ? reonet_woocommerce_checkout_city_options() : array();
				?>
				<?php if (is_array($city_options) && ! empty($city_options)) : ?>
					<?php
					if ($current_city !== '' && ! isset($city_options[$current_city])) {
						$city_options = array($current_city => $current_city) + $city_options;
					}
					?>
					<select name="calc_shipping_city" id="calc_shipping_city" class="<?php echo esc_attr(reonet_flowbite_input_class_string()); ?>">
						<?php foreach ($city_options as $city_value => $city_label) : ?>
							<option value="<?php echo esc_attr($city_value); ?>" <?php selected($current_city, (string) $city_value); ?>>
								<?php echo esc_html($city_label); ?>
							</option>
						<?php endforeach; ?>
					</select>
				<?php else : ?>
					<input type="text" class="<?php echo esc_attr(reonet_flowbite_input_class_string()); ?>" value="<?php echo esc_attr($current_city); ?>" name="calc_shipping_city" id="calc_shipping_city" />
				<?php endif; ?>
			</p>
		<?php endif; ?>

		<?php if (apply_filters('woocommerce_shipping_calculator_enable_postcode', true)) : ?>
			<p class="form-row form-row-wide" id="calc_shipping_postcode_field">
				<label for="calc_shipping_postcode"><?php esc_html_e('Postcode / ZIP:', 'woocommerce'); ?></label>
				<input type="text" class="<?php echo esc_attr(reonet_flowbite_input_class_string()); ?>" value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
			</p>
		<?php endif; ?>

		<p><button type="submit" name="calc_shipping" value="1" class="<?php echo esc_attr(reonet_flowbite_button_class_string()); ?>"><?php esc_html_e('Update', 'woocommerce'); ?></button></p>
		<?php wp_nonce_field('woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce'); ?>
	</section>
</form>

<?php do_action('woocommerce_after_shipping_calculator'); ?>
