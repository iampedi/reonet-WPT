<?php

/**
 * Cart item data (when outputting non-flat)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-item-data.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.4.0
 */
if (! defined('ABSPATH')) {
	exit;
}
?>
<dl class="variation flex items-center gap-4 text-gray-500">
	<?php foreach ($item_data as $data) : ?>
		<?php
		$meta_key_label = isset($data['key']) ? strtolower(trim(wp_strip_all_tags((string) $data['key']))) : '';
		$meta_key_label = str_replace(':', '', $meta_key_label);

		$hidden_meta_labels = array(
			'quantity',
			'qty',
			'total price',
			'total',
			'calculated total',
			'calculated total price',
			'maara',
			'määrä',
			'yhteensa',
			'yhteensä',
		);

		if (in_array($meta_key_label, $hidden_meta_labels, true)) {
			continue;
		}

		$display_value = isset($data['display']) ? (string) $data['display'] : '';
		$display_value = preg_replace('/\bm2\b/u', 'm²', $display_value);
		?>
		<div class="flex items-center gap-1">
			<dt class="<?php echo sanitize_html_class('variation-' . $data['key']); ?>"><?php echo wp_kses_post($data['key']); ?>:</dt>
			<dd class="<?php echo sanitize_html_class('variation-' . $data['key']); ?>"><?php echo wp_kses_post(wpautop($display_value)); ?></dd>
		</div>
	<?php endforeach; ?>
</dl>