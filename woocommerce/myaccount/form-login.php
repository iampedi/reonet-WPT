<?php
/**
 * Login Form
 *
 * Theme override for WooCommerce my-account login/register page.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_customer_login_form');

$registration_enabled = 'yes' === get_option('woocommerce_enable_myaccount_registration');
?>

<div class="<?php echo $registration_enabled ? 'grid grid-cols-1 xl:grid-cols-2 gap-6' : 'mx-auto max-w-xl'; ?>" id="customer_login">
	<div class="space-y-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">
		<h2 class="text-2xl font-semibold"><?php esc_html_e('Log in', 'woocommerce'); ?></h2>

		<form class="woocommerce-form woocommerce-form-login login space-y-4" method="post" novalidate>
			<?php do_action('woocommerce_login_form_start'); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide space-y-1">
				<label for="username" class="font-medium">
					<?php esc_html_e('Username or email address', 'woocommerce'); ?>
					<span class="required" aria-hidden="true">*</span>
					<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
				</label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text w-full" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username']) && is_string($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required aria-required="true" /><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</p>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide space-y-1">
				<label for="password" class="font-medium">
					<?php esc_html_e('Password', 'woocommerce'); ?>
					<span class="required" aria-hidden="true">*</span>
					<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
				</label>
				<input class="woocommerce-Input woocommerce-Input--text input-text w-full" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
			</p>

			<?php do_action('woocommerce_login_form'); ?>

			<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme inline-flex items-center gap-2">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
					<span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
				</label>

				<p class="woocommerce-LostPassword lost_password text-sm">
					<a class="font-medium text-primary underline-offset-4 hover:underline" href="<?php echo esc_url(wc_lostpassword_url()); ?>">
						<?php esc_html_e('Forgot password?', 'woocommerce'); ?>
					</a>
				</p>
			</div>

			<div class="pt-1">
				<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
				<button type="submit" class="woocommerce-button woocommerce-form-login__submit btn btn-md btn-primary" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>">
					<?php esc_html_e('Log in', 'woocommerce'); ?>
				</button>
			</div>

			<?php do_action('woocommerce_login_form_end'); ?>
		</form>
	</div>

	<?php if ($registration_enabled) : ?>
		<div class="space-y-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">
			<h2 class="text-2xl font-semibold"><?php esc_html_e('Register', 'woocommerce'); ?></h2>

			<form method="post" class="woocommerce-form woocommerce-form-register register space-y-4" <?php do_action('woocommerce_register_form_tag'); ?>>
				<?php do_action('woocommerce_register_form_start'); ?>

				<?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide space-y-1">
						<label for="reg_username" class="font-medium">
							<?php esc_html_e('Username', 'woocommerce'); ?>
							<span class="required" aria-hidden="true">*</span>
							<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
						</label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text w-full" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required aria-required="true" /><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</p>
				<?php endif; ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide space-y-1">
					<label for="reg_email" class="font-medium">
						<?php esc_html_e('Email address', 'woocommerce'); ?>
						<span class="required" aria-hidden="true">*</span>
						<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
					</label>
					<input type="email" class="woocommerce-Input woocommerce-Input--text input-text w-full" name="email" id="reg_email" autocomplete="email" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" required aria-required="true" /><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</p>

				<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide space-y-1">
						<label for="reg_password" class="font-medium">
							<?php esc_html_e('Password', 'woocommerce'); ?>
							<span class="required" aria-hidden="true">*</span>
							<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
						</label>
						<input type="password" class="woocommerce-Input woocommerce-Input--text input-text w-full" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" />
					</p>
				<?php else : ?>
					<p class="text-sm leading-relaxed text-gray-600"><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>
				<?php endif; ?>

				<?php do_action('woocommerce_register_form'); ?>

				<div class="pt-1">
					<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
					<button type="submit" class="woocommerce-Button woocommerce-button woocommerce-form-register__submit btn btn-md btn-primary" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>">
						<?php esc_html_e('Register', 'woocommerce'); ?>
					</button>
				</div>

				<?php do_action('woocommerce_register_form_end'); ?>
			</form>
		</div>
	<?php endif; ?>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>

