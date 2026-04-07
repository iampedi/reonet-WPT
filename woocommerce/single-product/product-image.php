<?php

/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.5.0
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (! function_exists('wc_get_gallery_image_html')) {
	return;
}

global $product;

$columns           = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
		'woocommerce-product-gallery--columns-' . absint($columns),
		'images',
	)
);
?>
<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?> _product-gallery sm:col-span-3 [&_.woocommerce-product-gallery__trigger]:hidden [&_.flex-control-thumbs]:mt-3 [&_.flex-control-thumbs]:grid [&_.flex-control-thumbs]:grid-cols-4 [&_.flex-control-thumbs]:gap-2 [&_.flex-control-thumbs_li]:overflow-hidden [&_.flex-control-thumbs_li]:rounded-xl [&_.flex-control-thumbs_img]:aspect-square [&_.flex-control-thumbs_img]:w-full [&_.flex-control-thumbs_img]:rounded-xl [&_.flex-control-thumbs_img]:border-[3px] [&_.flex-control-thumbs_img]:border-gray-200 [&_.flex-control-thumbs_img]:hover:border-green [&_.flex-control-thumbs_img]:object-cover [&_.flex-control-thumbs_img]:cursor-pointer [&_.flex-control-thumbs_img]:duration-200 [&_.flex-control-thumbs_.flex-active]:border-green" dir="ltr" data-columns="<?php echo esc_attr($columns); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<div class="woocommerce-product-gallery__wrapper _product-gallery-wrapper rounded-3xl overflow-hidden">
		<?php
		if ($post_thumbnail_id) {
			$html = wc_get_gallery_image_html($post_thumbnail_id, true);
		} else {
			$wrapper_classname = 'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder overflow-hidden rounded-2xl';
			$html              = sprintf('<div class="%s">', esc_attr($wrapper_classname));
			$html             .= sprintf('<img src="%s" alt="%s" class="wp-post-image w-full h-full object-cover object-center" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'woocommerce'));
			$html             .= '</div>';
		}

		if (function_exists('reonet_woocommerce_prepare_gallery_image_html')) {
			$html = reonet_woocommerce_prepare_gallery_image_html($html, false);
		}

		echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

		do_action('woocommerce_product_thumbnails');
		?>
	</div>
</div>