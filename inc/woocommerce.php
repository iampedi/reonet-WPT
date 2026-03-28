<?php
if (!defined('ABSPATH')) {
  exit;
}
/**
 * WooCommerce Includes
 */

function reonet_woocommerce_setup_theme_support()
{
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'reonet_woocommerce_setup_theme_support');

add_filter('woocommerce_enqueue_styles', '__return_empty_array');

function reonet_woocommerce_dequeue_styles()
{
  wp_dequeue_style('woocommerce-general');
  wp_dequeue_style('woocommerce-layout');
  wp_dequeue_style('woocommerce-smallscreen');
  wp_dequeue_style('wc-blocks-style');
  wp_dequeue_style('wc-blocks-vendors-style');
  wp_dequeue_style('woocommerce-inline');
}
add_action('wp_enqueue_scripts', 'reonet_woocommerce_dequeue_styles', 100);

function reonet_woocommerce_adjust_single_product_hooks()
{
  remove_action(
    'woocommerce_before_single_product_summary',
    'woocommerce_show_product_sale_flash',
    10
  );
  remove_action('woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 3);
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
}
add_action('init', 'reonet_woocommerce_adjust_single_product_hooks');

function reonet_woocommerce_render_sale_and_title()
{
  echo '<div class="reonet-product-sale-title flex items-center justify-between gap-3">';
  woocommerce_template_single_title();
  woocommerce_show_product_sale_flash();
  echo '</div>';
}
add_action('woocommerce_single_product_summary', 'reonet_woocommerce_render_sale_and_title', 4);

function reonet_woocommerce_render_categories_before_excerpt()
{
  global $product;

  if (! $product instanceof WC_Product) {
    return;
  }

  $categories = wc_get_product_category_list(
    $product->get_id(),
    ', ',
    '<div class="posted_in reonet-product-categories">' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'woocommerce') . ' ',
    '</div>'
  );

  if ($categories) {
    echo wp_kses_post($categories);
  }
}
add_action('woocommerce_single_product_summary', 'reonet_woocommerce_render_categories_before_excerpt', 19);

function reonet_woocommerce_price_state_class($price_html, $product)
{
  if (! $product instanceof WC_Product) {
    return $price_html;
  }

  $state_class = $product->is_on_sale()
    ? 'price-onsale'
    : 'price-regular';

  return '<span class="' . esc_attr($state_class) . '">' . $price_html . '</span>';
}
add_filter('woocommerce_get_price_html', 'reonet_woocommerce_price_state_class', 100, 2);
