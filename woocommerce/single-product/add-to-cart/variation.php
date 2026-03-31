<?php
/**
 * Single variation display
 *
 * Theme override to keep the selected variation price in the main price block.
 *
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined('ABSPATH') || exit;
?>
<script type="text/template" id="tmpl-variation-template">
	<div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
</script>
<script type="text/template" id="tmpl-unavailable-variation-template">
	<p role="alert"><?php esc_html_e('Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce'); ?></p>
</script>
