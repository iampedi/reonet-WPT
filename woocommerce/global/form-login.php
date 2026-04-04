<?php

/**
 * Login form
 *
 * Theme override for WooCommerce global login form layout.
 *
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

if (!defined('ABSPATH')) {
	exit;
}

if (is_user_logged_in()) {
	return;
}
?>
<form class="woocommerce-form woocommerce-form-login _reonet_login_form space-y-3" method="post" <?php echo ($hidden) ? 'style="display:none;"' : ''; ?>>
	<?php do_action('woocommerce_login_form_start'); ?>

	<?php if ($message) : ?>
		<div class="_reonet_login_message text-gray-600 leading-tight">
			<?php echo wpautop(wptexturize($message)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
			?>
		</div>
	<?php endif; ?>

	<div class="flex items-end gap-4">
		<div class="form-row form-row-first flex flex-col gap-1 flex-1">
			<label for="username" class="font-medium">
				<?php esc_html_e('Email', 'woocommerce'); ?>
				<span class="required" aria-hidden="true">*</span>
				<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
			</label>
			<input type="text" class="<?php echo esc_attr(reonet_flowbite_input_class_string()); ?>" name="username" id="username" autocomplete="username" required aria-required="true" />
		</div>

		<div class="form-row form-row-last flex flex-col gap-1 flex-1">
			<label for="password" class="font-medium">
				<?php esc_html_e('Password', 'woocommerce'); ?>
				<span class="required" aria-hidden="true">*</span>
				<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
			</label>
			<input class="<?php echo esc_attr(reonet_flowbite_input_class_string()); ?>" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
		</div>

		<div class="pt-1">
			<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
			<input type="hidden" name="redirect" value="<?php echo esc_url($redirect); ?>" />
			<button type="submit" class="woocommerce-button woocommerce-form-login__submit <?php echo esc_attr(reonet_flowbite_button_class_string()); ?>" name="login" value="<?php esc_attr_e('Login', 'woocommerce'); ?>">
				<?php esc_html_e('Login', 'woocommerce'); ?>
			</button>
		</div>
	</div>

	<?php do_action('woocommerce_login_form'); ?>

	<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme inline-flex items-center gap-2">
			<input class="<?php echo esc_attr(reonet_flowbite_checkbox_class_string()); ?>" name="rememberme" type="checkbox" id="rememberme" value="forever" />
			<span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
		</label>

		<a class="lost_password text-primary underline underline-offset-4 hover:text-green duration-300" href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
	</div>

	<?php do_action('woocommerce_login_form_end'); ?>
</form>