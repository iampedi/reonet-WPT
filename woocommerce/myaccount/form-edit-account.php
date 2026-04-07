<?php

/**
 * Edit account form
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.5.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_edit_account_form');

$input_class = function_exists('reonet_flowbite_input_class_string')
	? reonet_flowbite_input_class_string()
	: 'block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 h-11.5 text-[15px] text-gray-900';

$button_class = function_exists('reonet_flowbite_button_class_string')
	? reonet_flowbite_button_class_string('primary', 'md')
	: 'inline-flex items-center justify-center rounded-full bg-primary px-6 h-11.5 text-[15px] font-medium text-white';
?>

<form class="woocommerce_edit_account_form p-5 space-y-5" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>
	<?php do_action('woocommerce_edit_account_form_start'); ?>

	<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
		<div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first m-0">
			<label for="account_first_name" class="mb-1 inline-block text-sm font-medium text-gray-900">
				<?php esc_html_e('First name', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span>
			</label>
			<input type="text" class="<?php echo esc_attr($input_class); ?>" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>" aria-required="true" />
		</div>

		<div class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last m-0">
			<label for="account_last_name" class="mb-1 inline-block text-sm font-medium text-gray-900">
				<?php esc_html_e('Last name', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span>
			</label>
			<input type="text" class="<?php echo esc_attr($input_class); ?>" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>" aria-required="true" />
		</div>

		<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide m-0">
			<label for="account_display_name" class="mb-1 inline-block text-sm font-medium text-gray-900">
				<?php esc_html_e('Display name', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span>
			</label>
			<input type="text" class="<?php echo esc_attr($input_class); ?>" name="account_display_name" id="account_display_name" aria-describedby="account_display_name_description" value="<?php echo esc_attr($user->display_name); ?>" aria-required="true" />
			<span id="account_display_name_description" class="mt-1 inline-block text-xs text-gray-500">
				<?php esc_html_e('This will be how your name will be displayed in the account section and in reviews', 'woocommerce'); ?>
			</span>
		</div>

		<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide m-0">
			<label for="account_email" class="mb-1 inline-block text-sm font-medium text-gray-900">
				<?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span>
			</label>
			<input type="email" class="<?php echo esc_attr($input_class); ?>" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>" aria-required="true" />
		</div>
	</div>

	<?php do_action('woocommerce_edit_account_form_fields'); ?>

	<fieldset class="account_password_fieldset rounded-xl border border-dashed border-gray-200 p-4 sm:p-5">
		<legend class="px-1.5 font-semibold text-primary"><?php esc_html_e('Password change', 'woocommerce'); ?></legend>

		<div class="space-y-3">
			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide m-0">
				<label for="password_current" class="mb-1 inline-block text-sm font-medium text-gray-900">
					<?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?>
				</label>
				<input type="password" class="<?php echo esc_attr($input_class); ?>" name="password_current" id="password_current" autocomplete="current-password" />
			</div>

			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide m-0">
				<label for="password_1" class="mb-1 inline-block text-sm font-medium text-gray-900">
					<?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?>
				</label>
				<input type="password" class="<?php echo esc_attr($input_class); ?>" name="password_1" id="password_1" autocomplete="new-password" />
			</div>

			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide m-0">
				<label for="password_2" class="mb-1 inline-block text-sm font-medium text-gray-900">
					<?php esc_html_e('Confirm new password', 'woocommerce'); ?>
				</label>
				<input type="password" class="<?php echo esc_attr($input_class); ?>" name="password_2" id="password_2" autocomplete="new-password" />
			</div>
		</div>
	</fieldset>

	<?php do_action('woocommerce_edit_account_form'); ?>

	<p class="m-0 pt-1">
		<?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
		<button type="submit" class="<?php echo esc_attr($button_class); ?>" name="save_account_details" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>">
			<?php esc_html_e('Save changes', 'woocommerce'); ?>
		</button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action('woocommerce_edit_account_form_end'); ?>
</form>

<?php do_action('woocommerce_after_edit_account_form'); ?>