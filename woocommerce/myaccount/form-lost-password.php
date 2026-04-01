<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_lost_password_form');
?>

<form method="post" class="woocommerce-ResetPassword lost_reset_password mx-auto w-full max-w-xl space-y-5 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">
	<div class="space-y-2">
		<h2 class="text-2xl font-semibold"><?php esc_html_e('Reset password', 'woocommerce'); ?></h2>
		<p class="text-sm leading-relaxed text-gray-600">
			<?php
			echo wp_kses_post(
				apply_filters(
					'woocommerce_lost_password_message',
					esc_html__('Lost your password? Enter your username or email address and we will send you a reset link.', 'woocommerce')
				)
			);
			?>
		</p>
	</div>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first space-y-1">
		<label for="user_login" class="font-medium">
			<?php esc_html_e('Username or email', 'woocommerce'); ?>
			<span class="required" aria-hidden="true">*</span>
			<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
		</label>
		<input class="<?php echo esc_attr(reonet_flowbite_input_class_string()); ?>" type="text" name="user_login" id="user_login" autocomplete="username" required aria-required="true" />
	</p>

	<?php do_action('woocommerce_lostpassword_form'); ?>

	<div class="pt-1">
		<input type="hidden" name="wc_reset_password" value="true" />
		<button type="submit" class="woocommerce-Button button <?php echo esc_attr(reonet_flowbite_button_class_string()); ?>" value="<?php esc_attr_e('Reset password', 'woocommerce'); ?>">
			<?php esc_html_e('Reset password', 'woocommerce'); ?>
		</button>
	</div>

	<p class="text-sm">
		<a class="font-medium text-primary underline-offset-4 hover:underline" href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
			<?php esc_html_e('Back to login', 'reonet'); ?>
		</a>
	</p>

	<?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>
</form>

<?php do_action('woocommerce_after_lost_password_form'); ?>
