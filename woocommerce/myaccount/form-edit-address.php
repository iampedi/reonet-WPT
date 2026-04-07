<?php

/**
 * Edit address form
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined('ABSPATH') || exit;

$page_title = ('billing' === $load_address) ? esc_html__('Billing address', 'woocommerce') : esc_html__('Shipping address', 'woocommerce');

do_action('woocommerce_before_edit_account_address_form');
?>

<?php if (!$load_address) : ?>
	<?php wc_get_template('myaccount/my-address.php'); ?>
<?php else : ?>
	<?php
	$save_button_class = function_exists('reonet_flowbite_button_class_string')
		? reonet_flowbite_button_class_string('primary', 'md')
		: 'inline-flex items-center justify-center rounded-full bg-primary px-6 h-11.5 text-[15px] font-medium text-white';
	?>

	<form method="post" novalidate class="woocommerce-address-fields _edit-address-form space-y-5 p-5">
		<h2 class="text-2xl font-semibold text-primary">
			<?php echo wp_kses_post(apply_filters('woocommerce_my_account_edit_address_title', $page_title, $load_address)); ?>
		</h2>

		<?php do_action("woocommerce_before_edit_address_form_{$load_address}"); ?>

		<div class="woocommerce-address-fields__field-wrapper grid grid-cols-1 gap-3 sm:grid-cols-2 [&_.form-row]:m-0 [&_.form-row-wide]:sm:col-span-2">
			<?php
			foreach ($address as $key => $field) {
				$field['class'] = array_values(array_unique(array_merge((array) $field['class'], array('mb-0'))));
				woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
			}
			?>
		</div>

		<?php do_action("woocommerce_after_edit_address_form_{$load_address}"); ?>

		<p class="m-0 pt-1">
			<button type="submit" class="<?php echo esc_attr($save_button_class); ?>" name="save_address" value="<?php esc_attr_e('Save address', 'woocommerce'); ?>">
				<?php esc_html_e('Save address', 'woocommerce'); ?>
			</button>
			<?php wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
			<input type="hidden" name="action" value="edit_address" />
		</p>
	</form>
<?php endif; ?>

<?php do_action('woocommerce_after_edit_account_address_form'); ?>