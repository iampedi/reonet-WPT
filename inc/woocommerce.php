<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * --------------------------------------------------------------------------
 * WooCommerce: Theme Support and Base Styling
 * --------------------------------------------------------------------------
 */

/**
 * Enable WooCommerce support in the theme.
 */
function reonet_woocommerce_setup_theme_support()
{
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'reonet_woocommerce_setup_theme_support');

/**
 * Disable WooCommerce default stylesheet registration.
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Dequeue WooCommerce frontend styles so only theme styles are used.
 */
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

/**
 * --------------------------------------------------------------------------
 * WooCommerce: Single Product Summary Structure
 * --------------------------------------------------------------------------
 */

/**
 * Remove default single-product summary pieces to replace with custom layout.
 */
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

/**
 * Render title + sale badge in one custom row.
 */
function reonet_woocommerce_render_sale_and_title()
{
  echo '<div class="reonet-product-sale-title flex items-center justify-between gap-3">';
  woocommerce_template_single_title();
  woocommerce_show_product_sale_flash();
  echo '</div>';
}
add_action('woocommerce_single_product_summary', 'reonet_woocommerce_render_sale_and_title', 4);

/**
 * Render product categories before the short description.
 */
function reonet_woocommerce_render_categories_before_excerpt()
{
  global $product;

  if (!$product instanceof WC_Product) {
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

/**
 * Wrap price HTML to expose sale/regular state classes for styling.
 */
function reonet_woocommerce_price_state_class($price_html, $product)
{
  if (!$product instanceof WC_Product) {
    return $price_html;
  }

  $state_class = $product->is_on_sale() ? 'price-onsale' : 'price-regular';

  return '<span class="' . esc_attr($state_class) . '">' . $price_html . '</span>';
}
add_filter('woocommerce_get_price_html', 'reonet_woocommerce_price_state_class', 100, 2);

/**
 * Remove wrapping quote characters from variation option labels.
 */
function reonet_woocommerce_clean_variation_option_name($name)
{
  if (!is_string($name) || $name === '') {
    return $name;
  }

  $trimmed_name = trim($name);
  if (preg_match('/^(["\'\x{2018}\x{2019}\x{201C}\x{201D}])(.*)(["\'\x{2018}\x{2019}\x{201C}\x{201D}])$/u', $trimmed_name, $matches)) {
    return trim($matches[2]);
  }

  return $name;
}
add_filter('woocommerce_variation_option_name', 'reonet_woocommerce_clean_variation_option_name');

/**
 * --------------------------------------------------------------------------
 * WooCommerce: Checkout Wrapper and Notices
 * --------------------------------------------------------------------------
 */

/**
 * Replace core WooCommerce page shortcodes with theme wrappers.
 */
function reonet_woocommerce_override_woocommerce_page_shortcodes()
{
  if (!class_exists('WC_Shortcodes')) {
    return;
  }

  remove_shortcode('woocommerce_cart');
  remove_shortcode('woocommerce_checkout');
  remove_shortcode('woocommerce_my_account');
  remove_shortcode('woocommerce_order_tracking');

  add_shortcode('woocommerce_cart', 'reonet_woocommerce_cart_shortcode');
  add_shortcode('woocommerce_checkout', 'reonet_woocommerce_checkout_shortcode');
  add_shortcode('woocommerce_my_account', 'reonet_woocommerce_my_account_shortcode');
  add_shortcode('woocommerce_order_tracking', 'reonet_woocommerce_order_tracking_shortcode');
}
add_action('init', 'reonet_woocommerce_override_woocommerce_page_shortcodes', 20);

/**
 * Cart shortcode callback with page-specific wrapper class.
 */
function reonet_woocommerce_cart_shortcode($atts)
{
  if (is_null(WC()->cart)) {
    return '';
  }

  return WC_Shortcodes::shortcode_wrapper(
    array('WC_Shortcode_Cart', 'output'),
    $atts,
    array(
      'class' => 'woocommerce reonet-woocommerce-page reonet-woocommerce-page-cart',
    )
  );
}

/**
 * Checkout shortcode callback with custom wrapper markup.
 */
function reonet_woocommerce_checkout_shortcode($atts)
{
  return WC_Shortcodes::shortcode_wrapper(
    array('WC_Shortcode_Checkout', 'output'),
    $atts,
    array(
      'class'  => '',
      'before' => '<div class="woocommerce reonet-woocommerce-page reonet-woocommerce-page-checkout reonet-checkout-wrapper"><div class="container space-y-6">',
      'after'  => '</div></div>',
    )
  );
}

/**
 * My account shortcode callback with page-specific wrapper class.
 */
function reonet_woocommerce_my_account_shortcode($atts)
{
  return WC_Shortcodes::shortcode_wrapper(
    array('WC_Shortcode_My_Account', 'output'),
    $atts,
    array(
      'class' => 'woocommerce reonet-woocommerce-page reonet-woocommerce-page-my-account',
    )
  );
}

/**
 * Order tracking shortcode callback with page-specific wrapper class.
 */
function reonet_woocommerce_order_tracking_shortcode($atts)
{
  return WC_Shortcodes::shortcode_wrapper(
    array('WC_Shortcode_Order_Tracking', 'output'),
    $atts,
    array(
      'class' => 'woocommerce reonet-woocommerce-page reonet-woocommerce-page-order-tracking',
    )
  );
}

/**
 * Count all WooCommerce notice types.
 */
function reonet_woocommerce_notice_count_all_types()
{
  if (!function_exists('wc_notice_count')) {
    return 0;
  }

  return (int) wc_notice_count('error') + (int) wc_notice_count('success') + (int) wc_notice_count('notice');
}

/**
 * Output notices only when at least one notice exists.
 */
function reonet_woocommerce_output_notices_when_present()
{
  if (reonet_woocommerce_notice_count_all_types() <= 0) {
    return;
  }

  woocommerce_output_all_notices();
}

/**
 * Replace default checkout notice hooks to avoid rendering empty wrappers.
 */
function reonet_woocommerce_replace_empty_notice_wrapper_output()
{
  remove_action('woocommerce_before_checkout_form_cart_notices', 'woocommerce_output_all_notices', 10);
  remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);

  add_action('woocommerce_before_checkout_form_cart_notices', 'reonet_woocommerce_output_notices_when_present', 10);
  add_action('woocommerce_before_checkout_form', 'reonet_woocommerce_output_notices_when_present', 10);
}
add_action('init', 'reonet_woocommerce_replace_empty_notice_wrapper_output', 30);

/**
 * Remove default checkout coupon placement.
 */
function reonet_woocommerce_reposition_checkout_coupon_form()
{
  remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
}
add_action('init', 'reonet_woocommerce_reposition_checkout_coupon_form', 30);

/**
 * --------------------------------------------------------------------------
 * WooCommerce: Checkout Field Rules (Finland-Only Flow)
 * --------------------------------------------------------------------------
 */

/**
 * City dropdown options for checkout.
 *
 * @return array
 */
function reonet_woocommerce_checkout_city_options()
{
  return array(
    ''           => __('Valitse kaupunki', 'reonet'),
    'Helsinki'   => 'Helsinki',
    'Espoo'      => 'Espoo',
    'Vantaa'     => 'Vantaa',
    'Kauniainen' => 'Kauniainen',
    'Kerava'     => 'Kerava',
    'Tuusula'    => 'Tuusula',
    'Sipoo'      => 'Sipoo',
  );
}

/**
 * Restrict and reorder checkout location fields for billing and shipping.
 */
function reonet_woocommerce_limit_checkout_location_fields($fields)
{
  if (isset($fields['billing']['billing_country'])) {
    $fields['billing']['billing_country']['type'] = 'hidden';
    $fields['billing']['billing_country']['default'] = 'FI';
    $fields['billing']['billing_country']['required'] = false;
    $fields['billing']['billing_country']['priority'] = 1;
  }

  if (isset($fields['shipping']['shipping_country'])) {
    $fields['shipping']['shipping_country']['type'] = 'hidden';
    $fields['shipping']['shipping_country']['default'] = 'FI';
    $fields['shipping']['shipping_country']['required'] = false;
    $fields['shipping']['shipping_country']['priority'] = 1;
  }

  if (isset($fields['billing']['billing_city'])) {
    $fields['billing']['billing_city']['type'] = 'select';
    $fields['billing']['billing_city']['options'] = reonet_woocommerce_checkout_city_options();
    $fields['billing']['billing_city']['label'] = __('Kaupunki', 'reonet');
    $fields['billing']['billing_city']['required'] = true;
    $fields['billing']['billing_city']['priority'] = 50;
    $fields['billing']['billing_city']['class'] = array('form-row-wide');
    $fields['billing']['billing_city']['input_class'] = array();
  }

  if (isset($fields['shipping']['shipping_city'])) {
    $fields['shipping']['shipping_city']['type'] = 'select';
    $fields['shipping']['shipping_city']['options'] = reonet_woocommerce_checkout_city_options();
    $fields['shipping']['shipping_city']['label'] = __('Kaupunki', 'reonet');
    $fields['shipping']['shipping_city']['required'] = true;
    $fields['shipping']['shipping_city']['priority'] = 50;
    $fields['shipping']['shipping_city']['class'] = array('form-row-wide');
    $fields['shipping']['shipping_city']['input_class'] = array();
  }

  if (isset($fields['billing']['billing_address_1'])) {
    $fields['billing']['billing_address_1']['label'] = __('Katuosoite', 'reonet');
    $fields['billing']['billing_address_1']['priority'] = 60;
  }

  if (isset($fields['shipping']['shipping_address_1'])) {
    $fields['shipping']['shipping_address_1']['label'] = __('Katuosoite', 'reonet');
    $fields['shipping']['shipping_address_1']['priority'] = 60;
  }

  return $fields;
}
add_filter('woocommerce_checkout_fields', 'reonet_woocommerce_limit_checkout_location_fields', 20);

/**
 * Keep "Ship to a different address?" unchecked by default.
 */
function reonet_woocommerce_ship_to_different_address_unchecked_by_default()
{
  return false;
}
add_filter('woocommerce_ship_to_different_address_checked', 'reonet_woocommerce_ship_to_different_address_unchecked_by_default');

/**
 * Replace default <p> wrappers with <div> wrappers for checkout form fields.
 */
function reonet_woocommerce_checkout_use_div_field_wrappers($field, $key, $args, $value)
{
  if ((is_admin() && !wp_doing_ajax()) || !function_exists('is_checkout') || !is_checkout()) {
    return $field;
  }

  if (strpos($field, '<p class="form-row') === false) {
    return $field;
  }

  $field = preg_replace('/^(\s*)<p(\b[^>]*)>/m', '$1<div$2>', $field, 1);
  $field = preg_replace('/<\/p>\s*$/', '</div>', $field, 1);

  return $field;
}
add_filter('woocommerce_form_field', 'reonet_woocommerce_checkout_use_div_field_wrappers', 20, 4);

/**
 * --------------------------------------------------------------------------
 * WooCommerce: Header Cart Badge
 * --------------------------------------------------------------------------
 */

/**
 * Return current cart item count for header badge.
 *
 * @return int
 */
function reonet_woocommerce_get_cart_item_count()
{
  if (!function_exists('WC') || !WC()->cart) {
    return 0;
  }

  return (int) WC()->cart->get_cart_contents_count();
}

/**
 * Return header cart badge HTML.
 *
 * @return string
 */
function reonet_woocommerce_get_header_cart_count_badge_html()
{
  return '<span class="reonet-header-cart-count absolute -right-1 -top-1 inline-flex min-w-5 items-center justify-center rounded-full bg-primary px-1.5 text-[11px] font-medium leading-5 text-white">' . esc_html(reonet_woocommerce_get_cart_item_count()) . '</span>';
}

/**
 * Keep header cart count in sync after AJAX add-to-cart updates.
 *
 * @param array $fragments Existing fragments.
 * @return array
 */
function reonet_woocommerce_update_header_cart_badge_fragment($fragments)
{
  $fragments['.reonet-header-cart-count'] = reonet_woocommerce_get_header_cart_count_badge_html();
  return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'reonet_woocommerce_update_header_cart_badge_fragment');

/**
 * --------------------------------------------------------------------------
 * WooCommerce: Product Category -> Service Matching
 * --------------------------------------------------------------------------
 */

/**
 * Find a published service post matching a WooCommerce product category term.
 *
 * Match order:
 * 1) service post_name == product_cat slug
 * 2) service post_title == product_cat name (case-insensitive)
 *
 * @param WP_Term $term Product category term.
 * @return WP_Post|null
 */
function reonet_find_service_by_product_cat_term($term)
{
  if (!$term instanceof WP_Term || $term->taxonomy !== 'product_cat') {
    return null;
  }

  $service_by_slug = get_page_by_path($term->slug, OBJECT, 'service');
  if ($service_by_slug instanceof WP_Post && $service_by_slug->post_status === 'publish') {
    return $service_by_slug;
  }

  static $services_by_title = null;

  if (!is_array($services_by_title)) {
    $services_by_title = array();
    $services = get_posts(array(
      'post_type' => 'service',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'fields' => 'all',
      'no_found_rows' => true,
    ));

    foreach ($services as $service) {
      $service_title = get_the_title($service);
      $normalized_service_title = function_exists('mb_strtolower') ? mb_strtolower(trim((string) $service_title)) : strtolower(trim((string) $service_title));

      if ($normalized_service_title !== '' && !isset($services_by_title[$normalized_service_title])) {
        $services_by_title[$normalized_service_title] = $service;
      }
    }
  }

  $term_name = function_exists('mb_strtolower') ? mb_strtolower(trim((string) $term->name)) : strtolower(trim((string) $term->name));
  if (isset($services_by_title[$term_name]) && $services_by_title[$term_name] instanceof WP_Post) {
    return $services_by_title[$term_name];
  }

  return null;
}

/**
 * Replace WooCommerce category links with matching service links when available.
 *
 * @param string $termlink Generated term link.
 * @param WP_Term $term Term object.
 * @param string $taxonomy Taxonomy name.
 * @return string
 */
function reonet_map_product_cat_link_to_service($termlink, $term, $taxonomy)
{
  if ($taxonomy !== 'product_cat') {
    return $termlink;
  }

  $service = reonet_find_service_by_product_cat_term($term);
  if (!$service instanceof WP_Post) {
    return $termlink;
  }

  $service_link = get_permalink($service);
  return $service_link ? $service_link : $termlink;
}
add_filter('term_link', 'reonet_map_product_cat_link_to_service', 10, 3);

/**
 * Redirect product category archive to matching service post when found.
 */
function reonet_redirect_product_cat_to_service()
{
  if (is_admin() || wp_doing_ajax()) {
    return;
  }

  if (!is_tax('product_cat')) {
    return;
  }

  $term = get_queried_object();
  if (!$term instanceof WP_Term || $term->taxonomy !== 'product_cat') {
    return;
  }

  $service = reonet_find_service_by_product_cat_term($term);
  if (!$service instanceof WP_Post) {
    return;
  }

  $target_url = get_permalink($service);
  if (!$target_url) {
    return;
  }

  wp_safe_redirect($target_url, 301);
  exit;
}
add_action('template_redirect', 'reonet_redirect_product_cat_to_service');
