<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_reset_password_form');
?>

<form method="post" class="woocommerce-ResetPassword lost_reset_password mx-auto w-full max-w-xl space-y-5 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">
	<div class="space-y-2">
		<h2 class="text-2xl font-semibold"><?php esc_html_e('Create a new password', 'woocommerce'); ?></h2>
		<p class="text-sm leading-relaxed text-gray-600">
			<?php
			echo wp_kses_post(
				apply_filters(
					'woocommerce_reset_password_message',
					esc_html__('Enter a new password below.', 'woocommerce')
				)
			);
			?>
		</p>
	</div>

	<div class="grid grid-cols-1 gap-4">
		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first space-y-1">
			<label for="password_1" class="font-medium">
				<?php esc_html_e('New password', 'woocommerce'); ?>
				<span class="required" aria-hidden="true">*</span>
				<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
			</label>
			<input type="password" class="woocommerce-Input woocommerce-Input--text input-text w-full" name="password_1" id="password_1" autocomplete="new-password" required aria-required="true" />
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last space-y-1">
			<label for="password_2" class="font-medium">
				<?php esc_html_e('Re-enter new password', 'woocommerce'); ?>
				<span class="required" aria-hidden="true">*</span>
				<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
			</label>
			<input type="password" class="woocommerce-Input woocommerce-Input--text input-text w-full" name="password_2" id="password_2" autocomplete="new-password" required aria-required="true" />
		</p>
	</div>

	<input type="hidden" name="reset_key" value="<?php echo esc_attr($args['key']); ?>" />
	<input type="hidden" name="reset_login" value="<?php echo esc_attr($args['login']); ?>" />

	<?php do_action('woocommerce_resetpassword_form'); ?>

	<div class="pt-1">
		<input type="hidden" name="wc_reset_password" value="true" />
		<button type="submit" class="woocommerce-Button button btn btn-md btn-primary" value="<?php esc_attr_e('Save', 'woocommerce'); ?>">
			<?php esc_html_e('Save', 'woocommerce'); ?>
		</button>
	</div>

	<?php wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce'); ?>
</form>

<?php do_action('woocommerce_after_reset_password_form'); ?>

