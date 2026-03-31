<?php
/**
 * Lost password confirmation text.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/lost-password-confirmation.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.9.0
 */

defined('ABSPATH') || exit;

wc_print_notice(esc_html__('Password reset email has been sent.', 'woocommerce'));
?>

<?php do_action('woocommerce_before_lost_password_confirmation_message'); ?>

<div class="mx-auto w-full max-w-xl rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">
	<p class="m-0 text-sm leading-relaxed text-gray-600">
		<?php
		echo esc_html(
			apply_filters(
				'woocommerce_lost_password_confirmation_message',
				esc_html__('A password reset email has been sent to your account email. It may take a few minutes to appear in your inbox.', 'woocommerce')
			)
		);
		?>
	</p>
</div>

<?php do_action('woocommerce_after_lost_password_confirmation_message'); ?>

