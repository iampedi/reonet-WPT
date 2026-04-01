<?php

/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! $notices) {
	return;
}
?>
<?php foreach ($notices as $notice) : ?>
	<?php
	$notice_content = wc_kses_notice($notice['notice']);
	$notice_content = preg_replace(
		'/class=(["\'])button wc-forward\1/',
		'class=$1wc-forward font-medium hover:underline underline-offset-4 text-green-700$1',
		$notice_content
	);
	$notice_content = preg_replace(
		'/class=(["\'])restore-item\1/',
		'class=$1restore-item wc-forward font-medium hover:underline underline-offset-4 text-green-700$1',
		$notice_content
	);
	$forward_button = '';
	$message_text = $notice_content;

	if (preg_match('/<a\b[^>]*\b(?:wc-forward|restore-item)\b[^>]*>.*?<\/a>/s', $notice_content, $matches)) {
		$forward_button = $matches[0];
		$message_text = trim(preg_replace('/<a\b[^>]*\b(?:wc-forward|restore-item)\b[^>]*>.*?<\/a>\s*/s', '', $notice_content, 1));
	}
	?>

	<div class="woocommerce-message mb-4 flex items-start justify-between gap-4 rounded-lg border border-green-300 bg-green-50 p-4 text-sm text-green-800" <?php echo wc_get_notice_data_attr($notice); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																																																						?> role="alert">
		<div class="woocommerce-message-content flex items-center gap-2">
			<i class="ph-duotone ph-basket text-green-600 text-2xl"></i>
			<div><?php echo wp_kses_post($message_text); ?></div>
		</div>

		<?php if ($forward_button) : ?>
			<?php echo wp_kses_post($forward_button); ?>
		<?php endif; ?>
	</div>
<?php endforeach; ?>
