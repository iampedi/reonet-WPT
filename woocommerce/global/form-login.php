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
<form class="woocommerce-form woocommerce-form-login login reonet-login-form space-y-5 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6" method="post" <?php echo ($hidden) ? 'style="display:none;"' : ''; ?>>
	<?php do_action('woocommerce_login_form_start'); ?>

	<?php if ($message) : ?>
		<div class="reonet-login-message text-gray-600 leading-tight">
			<?php echo wpautop(wptexturize($message)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php endif; ?>

	<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
		<p class="form-row form-row-first space-y-1">
			<label for="username" class="font-medium">
				<?php esc_html_e('Username or email', 'woocommerce'); ?>
				<span class="required" aria-hidden="true">*</span>
				<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
			</label>
			<input type="text" class="input-text w-full" name="username" id="username" autocomplete="username" required aria-required="true" />
		</p>

		<p class="form-row form-row-last space-y-1">
			<label for="password" class="font-medium">
				<?php esc_html_e('Password', 'woocommerce'); ?>
				<span class="required" aria-hidden="true">*</span>
				<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
			</label>
			<input class="input-text woocommerce-Input w-full" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
		</p>
	</div>

	<?php do_action('woocommerce_login_form'); ?>

	<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme inline-flex items-center gap-2">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
			<span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
		</label>

		<p class="lost_password text-sm">
			<a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
		</p>
	</div>

	<div class="pt-1">
		<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
		<input type="hidden" name="redirect" value="<?php echo esc_url($redirect); ?>" />
		<button type="submit" class="woocommerce-button woocommerce-form-login__submit btn btn-md btn-primary" name="login" value="<?php esc_attr_e('Login', 'woocommerce'); ?>">
			<?php esc_html_e('Login', 'woocommerce'); ?>
		</button>
	</div>

	<?php do_action('woocommerce_login_form_end'); ?>
</form>
