<?php

/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);

if (! $short_description) {
	return;
}

?>

<div class="_variation-notice hidden mb-4 flex items-center gap-2 rounded-lg border border-red-300 bg-red-50 p-3 text-sm text-red-800" role="alert" aria-live="polite">
	<i class="_variation-notice-icon ph-duotone ph-warning-octagon text-xl text-red-600"></i>
	<span class="_variation-notice-text"></span>
</div>

<div class="woocommerce-product-details__short-description text-gray-600 leading-tight">
	<?php echo $short_description; // WPCS: XSS ok. 
	?>
</div>