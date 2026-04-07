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
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'reonet_woocommerce_setup_theme_support');

/**
 * Stabilize WooCommerce single-product carousel behavior across RTL/LTR.
 *
 * @param array $options Flexslider options.
 * @return array
 */
function reonet_woocommerce_single_product_carousel_options($options)
{
  if (!is_array($options)) {
    return $options;
  }

  $options['rtl'] = false;
  $options['animationLoop'] = false;
  $options['smoothHeight'] = false;

  return $options;
}
add_filter('woocommerce_single_product_carousel_options', 'reonet_woocommerce_single_product_carousel_options', 20);

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
 * Replace WooCommerce default related-products output with theme-controlled output.
 */
function reonet_woocommerce_override_related_products_output()
{
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
  add_action('woocommerce_after_single_product_summary', 'reonet_woocommerce_render_related_products', 20);
}
add_action('init', 'reonet_woocommerce_override_related_products_output', 30);

/**
 * Render related-products section via theme template for full markup control.
 */
function reonet_woocommerce_render_related_products()
{
  global $product;

  if (!$product instanceof WC_Product) {
    return;
  }

  $limit = (int) apply_filters('reonet_related_products_limit', 4, $product);
  if ($limit <= 0) {
    return;
  }

  $exclude_ids = array_unique(
    array_filter(
      array_merge(array($product->get_id()), (array) $product->get_upsell_ids())
    )
  );

  $related_ids = wc_get_related_products($product->get_id(), $limit, $exclude_ids);
  if (empty($related_ids)) {
    return;
  }

  $related_products = wc_get_products(
    array(
      'include' => $related_ids,
      'status'  => 'publish',
      'limit'   => count($related_ids),
      'orderby' => 'include',
    )
  );

  if (empty($related_products)) {
    return;
  }

  wc_get_template(
    'single-product/related.php',
    array(
      'related_products' => $related_products,
      'section_title'    => function_exists('reonet_tr') ? reonet_tr('Related products') : __('Related products', 'woocommerce'),
    )
  );
}

/**
 * Render title + sale badge in one custom row.
 */
function reonet_woocommerce_render_sale_and_title()
{
  echo '<div class="_product-sale-title flex items-center justify-between gap-3">';
  woocommerce_template_single_title();
  woocommerce_show_product_sale_flash();
  echo '</div>';
}
add_action('woocommerce_single_product_summary', 'reonet_woocommerce_render_sale_and_title', 4);

/**
 * Check whether Reonet measurement pricing is enabled for a product.
 *
 * Supports direct meta and backward-compatible pricing model meta.
 */
function reonet_is_measurement_pricing_enabled_for_product($product)
{
  if (!$product instanceof WC_Product) {
    return false;
  }

  $product_id = $product->get_id();
  if (!$product_id) {
    return false;
  }

  $enabled = get_post_meta($product_id, '_reonet_measurement_enabled', true);
  if ($enabled === 'yes') {
    return true;
  }

  $pricing_model = get_post_meta($product_id, '_reonet_pricing_model', true);
  if ($pricing_model === 'measurement') {
    return true;
  }

  return false;
}

/**
 * Render single-product price for non-variable products.
 */
function reonet_woocommerce_render_single_product_price_default_position()
{
  global $product;

  if (!$product instanceof WC_Product) {
    return;
  }

  if ($product->is_type('variable')) {
    return;
  }

  if (reonet_is_measurement_pricing_enabled_for_product($product)) {
    return;
  }

  woocommerce_template_single_price();
}
add_action('woocommerce_single_product_summary', 'reonet_woocommerce_render_single_product_price_default_position', 10);

/**
 * Render variable-product range/selected price under variation dropdowns.
 */
function reonet_woocommerce_render_variable_price_below_dropdowns()
{
  global $product;

  if (!$product instanceof WC_Product || !$product->is_type('variable')) {
    return;
  }

  if (reonet_is_measurement_pricing_enabled_for_product($product)) {
    return;
  }

  echo '<div class="_variable-range-price price-fileds">';
  echo '<div class="price-per-unit">';
  echo '<span class="label">' . reonet_esc_html_tr('Price range') . '</span>';
  woocommerce_template_single_price();
  echo '</div>';
  echo '</div>';
}
add_action('woocommerce_after_variations_table', 'reonet_woocommerce_render_variable_price_below_dropdowns', 20);

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
    '<div class="posted_in _product-categories">' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'woocommerce') . ' ',
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
 * Ensure variation payload always contains price_html for frontend rendering.
 *
 * Some WooCommerce configurations can return empty price_html for a selected
 * variation; this guarantees the single-product JS can always render a price.
 */
function reonet_woocommerce_ensure_available_variation_price_html($data, $product, $variation)
{
  if (!is_array($data) || !$variation instanceof WC_Product_Variation) {
    return $data;
  }

  $existing_price_html = isset($data['price_html']) ? trim((string) $data['price_html']) : '';
  if ($existing_price_html !== '') {
    return $data;
  }

  $variation_price_html = (string) $variation->get_price_html();

  if ($variation_price_html === '' && array_key_exists('display_price', $data)) {
    $variation_price_html = wc_price((float) $data['display_price']);
  }

  if ($variation_price_html !== '') {
    $data['price_html'] = '<span class="price">' . $variation_price_html . '</span>';
  }

  return $data;
}
add_filter('woocommerce_available_variation', 'reonet_woocommerce_ensure_available_variation_price_html', 20, 3);

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
 * Append classes to a DOM element without duplicating existing classes.
 *
 * @param DOMElement $element DOM element to update.
 * @param string     $classes Space-separated class list.
 * @return void
 */
function reonet_woocommerce_append_dom_element_classes($element, $classes)
{
  if (!$element instanceof DOMElement || !is_string($classes) || trim($classes) === '') {
    return;
  }

  $existing_classes = preg_split('/\s+/', trim((string) $element->getAttribute('class')));
  $new_classes = preg_split('/\s+/', trim($classes));
  $merged_classes = array_values(
    array_unique(
      array_filter(
        array_merge($existing_classes, $new_classes)
      )
    )
  );

  if (!empty($merged_classes)) {
    $element->setAttribute('class', implode(' ', $merged_classes));
  }
}

/**
 * Enrich WooCommerce gallery item HTML with direct utility classes.
 *
 * @param string $html Gallery item HTML from wc_get_gallery_image_html().
 * @param bool   $is_thumbnail True when item is a gallery thumbnail item.
 * @return string
 */
function reonet_woocommerce_prepare_gallery_image_html($html, $is_thumbnail = false)
{
  if (!is_string($html) || trim($html) === '' || !class_exists('DOMDocument')) {
    return $html;
  }

  $internal_errors_previous = libxml_use_internal_errors(true);

  $dom = new DOMDocument('1.0', 'UTF-8');
  $wrapped_html = '<!DOCTYPE html><html><body><div id="_reonet_gallery_root">' . $html . '</div></body></html>';
  $loaded = $dom->loadHTML($wrapped_html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

  if (!$loaded) {
    libxml_clear_errors();
    libxml_use_internal_errors($internal_errors_previous);
    return $html;
  }

  $root = $dom->getElementById('_reonet_gallery_root');
  if (!$root instanceof DOMElement) {
    libxml_clear_errors();
    libxml_use_internal_errors($internal_errors_previous);
    return $html;
  }

  $xpath = new DOMXPath($dom);
  $wrapper_nodes = $xpath->query('.//*[contains(concat(" ", normalize-space(@class), " "), " woocommerce-product-gallery__image ")]', $root);

  if ($wrapper_nodes) {
    foreach ($wrapper_nodes as $wrapper_node) {
      if (!$wrapper_node instanceof DOMElement) {
        continue;
      }

      reonet_woocommerce_append_dom_element_classes($wrapper_node, 'box-border relative w-full aspect-square overflow-hidden rounded-3xl bg-white');
      if ($is_thumbnail) {
        reonet_woocommerce_append_dom_element_classes($wrapper_node, '_product-gallery-thumb');
      }
    }
  }

  $anchor_nodes = $xpath->query('.//a', $root);
  if ($anchor_nodes) {
    foreach ($anchor_nodes as $anchor_node) {
      if ($anchor_node instanceof DOMElement) {
        reonet_woocommerce_append_dom_element_classes($anchor_node, 'flex w-full h-full items-center justify-center cursor-zoom-in');
      }
    }
  }

  $image_nodes = $xpath->query('.//img', $root);
  if ($image_nodes) {
    foreach ($image_nodes as $image_node) {
      if ($image_node instanceof DOMElement) {
        reonet_woocommerce_append_dom_element_classes($image_node, 'block w-full rounded-3xl h-full object-cover object-center');
      }
    }
  }

  $prepared_html = '';
  foreach ($root->childNodes as $child_node) {
    $prepared_html .= $dom->saveHTML($child_node);
  }

  libxml_clear_errors();
  libxml_use_internal_errors($internal_errors_previous);

  return $prepared_html !== '' ? $prepared_html : $html;
}

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
      'class'  => '',
      'before' => '<div class="woocommerce _woocommerce-page _woocommerce-page-cart"><div class="container">',
      'after'  => '</div></div>',
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
      'before' => '<div class="woocommerce _woocommerce-page _woocommerce-page-checkout _checkout-wrapper"><div class="container space-y-6">',
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
      'class' => 'woocommerce _reonet_woocommerce_page _reonet_woocommerce_page_my_account py-8 sm:py-16',
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
      'class' => 'woocommerce _woocommerce-page _woocommerce-page-order-tracking',
    )
  );
}

/**
 * Hide "Downloads" endpoint item from My Account navigation.
 *
 * @param array $items My Account menu items.
 * @return array
 */
function reonet_woocommerce_hide_downloads_menu_item($items)
{
  if (isset($items['downloads'])) {
    unset($items['downloads']);
  }

  return $items;
}
add_filter('woocommerce_account_menu_items', 'reonet_woocommerce_hide_downloads_menu_item', 99);

/**
 * Redirect direct access to /my-account/downloads/ back to My Account dashboard.
 *
 * @return void
 */
function reonet_woocommerce_redirect_downloads_endpoint()
{
  if (is_admin() || wp_doing_ajax()) {
    return;
  }

  if (!function_exists('is_account_page') || !is_account_page()) {
    return;
  }

  if (!function_exists('is_wc_endpoint_url') || !is_wc_endpoint_url('downloads')) {
    return;
  }

  $target_url = wc_get_page_permalink('myaccount');
  if (!$target_url) {
    $target_url = home_url('/');
  }

  wp_safe_redirect($target_url);
  exit;
}
add_action('template_redirect', 'reonet_woocommerce_redirect_downloads_endpoint', 20);

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
 * Remove default checkout login and coupon placement.
 */
function reonet_woocommerce_reposition_checkout_coupon_form()
{
  remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);
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
  foreach (array('billing', 'shipping', 'order', 'account') as $section) {
    if (! isset($fields[$section]) || ! is_array($fields[$section])) {
      continue;
    }

    foreach ($fields[$section] as $key => $field) {
      $fields[$section][$key]['placeholder'] = '';
    }
  }

  if (isset($fields['billing']['billing_country'])) {
    $fields['billing']['billing_country']['type'] = 'hidden';
    $fields['billing']['billing_country']['default'] = 'FI';
    $fields['billing']['billing_country']['required'] = false;
    $fields['billing']['billing_country']['priority'] = 1;
    $fields['billing']['billing_country']['class'] = array('hidden');
    $fields['billing']['billing_country']['label_class'] = array('hidden');
    $fields['billing']['billing_country']['input_class'] = array('hidden');
  }

  if (isset($fields['shipping']['shipping_country'])) {
    $fields['shipping']['shipping_country']['type'] = 'hidden';
    $fields['shipping']['shipping_country']['default'] = 'FI';
    $fields['shipping']['shipping_country']['required'] = false;
    $fields['shipping']['shipping_country']['priority'] = 1;
    $fields['shipping']['shipping_country']['class'] = array('hidden');
    $fields['shipping']['shipping_country']['label_class'] = array('hidden');
    $fields['shipping']['shipping_country']['input_class'] = array('hidden');
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

  if (isset($fields['billing']['billing_phone'])) {
    $fields['billing']['billing_phone']['required'] = true;
  }

  if (isset($fields['order']['order_comments'])) {
    $fields['order']['order_comments']['custom_attributes']['rows'] = 4;
  }

  if (isset($fields['billing']['billing_address_2'])) {
    $fields['billing']['billing_address_2']['label'] = reonet_tr('Apartment, unit, etc.');
    $fields['billing']['billing_address_2']['label_class'] = array();
  }

  if (isset($fields['shipping']['shipping_address_2'])) {
    $fields['shipping']['shipping_address_2']['label'] = reonet_tr('Apartment, unit, etc.');
    $fields['shipping']['shipping_address_2']['label_class'] = array();
  }

  return $fields;
}
add_filter('woocommerce_checkout_fields', 'reonet_woocommerce_limit_checkout_location_fields', 20);

/**
 * Return a checkout payment-method icon class by gateway id.
 *
 * @param string $gateway_id WooCommerce gateway id.
 * @return string
 */
function reonet_woocommerce_payment_method_icon_class($gateway_id)
{
  $gateway_id = strtolower((string) $gateway_id);

  $map = array(
    'stripe' => 'ph-stripe-logo',
    'pediland_stripe_checkout' => 'ph-stripe-logo',
    'paypal' => 'ph-paypal-logo',
    'bacs' => 'ph-bank',
    'cod' => 'ph-money',
    'cheque' => 'ph-receipt',
  );

  return isset($map[$gateway_id]) ? $map[$gateway_id] : 'ph-wallet';
}

/**
 * Return tax/VAT label with VAT token routed through theme translation.
 *
 * @return string
 */
function reonet_woocommerce_tax_or_vat_label()
{
  if (!function_exists('WC') || !WC() || !WC()->countries) {
    return reonet_tr('VAT');
  }

  $label = (string) WC()->countries->tax_or_vat();
  if ($label === '') {
    return reonet_tr('VAT');
  }

  return preg_replace('/\bVAT\b/u', reonet_tr('VAT'), $label);
}

/**
 * Translate VAT token inside order-total HTML (includes_tax text) for cart and checkout.
 *
 * @param string $value WooCommerce order total HTML.
 * @return string
 */
function reonet_woocommerce_translate_vat_in_order_total_html($value)
{
  if (!is_string($value) || $value === '') {
    return $value;
  }

  return preg_replace('/\bVAT\b/ui', reonet_tr('VAT'), $value);
}
add_filter('woocommerce_cart_totals_order_total_html', 'reonet_woocommerce_translate_vat_in_order_total_html', 10);

/**
 * Apply Flowbite-like classes to WooCommerce generated form fields.
 */
function reonet_woocommerce_apply_flowbite_field_classes($args, $key, $value)
{
  $input_base_classes = explode(' ', reonet_flowbite_input_class_string());
  $textarea_base_classes = explode(' ', reonet_flowbite_textarea_class_string());
  $checkbox_radio_classes = explode(' ', reonet_flowbite_checkbox_class_string());

  if (in_array($args['type'], array('checkbox', 'radio'), true)) {
    $args['input_class'] = array_values(array_unique(array_merge((array) $args['input_class'], $checkbox_radio_classes)));
  } elseif ($args['type'] === 'textarea') {
    $args['input_class'] = array_values(array_unique(array_merge((array) $args['input_class'], $textarea_base_classes)));
  } else {
    $args['input_class'] = array_values(array_unique(array_merge((array) $args['input_class'], $input_base_classes)));
  }

  $args['label_class'] = array_values(array_unique(array_merge((array) $args['label_class'], array('mb-1', 'inline-block', 'text-sm', 'font-medium', 'text-gray-900'))));

  return $args;
}
add_filter('woocommerce_form_field_args', 'reonet_woocommerce_apply_flowbite_field_classes', 10, 3);

/**
 * Apply Flowbite classes to WooCommerce quantity inputs.
 */
function reonet_woocommerce_quantity_input_classes($classes)
{
  return array_values(array_unique(array_merge((array) $classes, explode(' ', reonet_flowbite_input_class_string()))));
}
add_filter('woocommerce_quantity_input_classes', 'reonet_woocommerce_quantity_input_classes');

/**
 * Keep "Ship to a different address?" unchecked by default.
 */
function reonet_woocommerce_ship_to_different_address_unchecked_by_default()
{
  return false;
}
add_filter('woocommerce_ship_to_different_address_checked', 'reonet_woocommerce_ship_to_different_address_unchecked_by_default');

/**
 * Translate cart/checkout shipping package name via theme translation layer.
 *
 * @param string $package_name Original package name.
 * @param int    $index        Package index.
 * @param array  $package      Shipping package data.
 * @return string
 */
function reonet_woocommerce_translate_shipping_package_name($package_name, $index, $package)
{
  if (!is_string($package_name) || $package_name === '') {
    return $package_name;
  }

  if (preg_match('/^Shipping(\s+\d+)?$/i', trim($package_name), $matches)) {
    $translated_base = reonet_tr('Shipping');
    $suffix = isset($matches[1]) ? $matches[1] : '';
    return $translated_base . $suffix;
  }

  return reonet_tr($package_name);
}
add_filter('woocommerce_shipping_package_name', 'reonet_woocommerce_translate_shipping_package_name', 10, 3);

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
  return '<span class="_header-cart-count absolute -right-1 -top-1 inline-flex min-w-5 items-center justify-center rounded-full bg-primary px-1.5 text-[11px] font-medium leading-5 text-white">' . esc_html(reonet_woocommerce_get_cart_item_count()) . '</span>';
}

/**
 * Keep header cart count in sync after AJAX add-to-cart updates.
 *
 * @param array $fragments Existing fragments.
 * @return array
 */
function reonet_woocommerce_update_header_cart_badge_fragment($fragments)
{
  $fragments['._header-cart-count'] = reonet_woocommerce_get_header_cart_count_badge_html();
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

/**
 * --------------------------------------------------------------------------
 * WooCommerce: Hide SKU and Product Type Tabs
 * --------------------------------------------------------------------------
 */

/**
 * Disable SKU output site-wide.
 */
add_filter('wc_product_sku_enabled', '__return_false');

/**
 * Remove frontend "Additional information" tab (attributes/product type details).
 *
 * @param array $tabs Product tabs.
 * @return array
 */
function reonet_remove_additional_information_tab($tabs)
{
  if (isset($tabs['additional_information'])) {
    unset($tabs['additional_information']);
  }

  return $tabs;
}
add_filter('woocommerce_product_tabs', 'reonet_remove_additional_information_tab', 98);

/**
 * Keep all default WooCommerce product types available in admin.
 *
 * @param array $types Registered product types.
 * @return array
 */
function reonet_keep_all_product_types_in_selector($types)
{
  return $types;
}
add_filter('product_type_selector', 'reonet_keep_all_product_types_in_selector');

/**
 * Default product type for newly created products.
 *
 * @return string
 */
function reonet_default_product_type_simple()
{
  return 'simple';
}
add_filter('default_product_type', 'reonet_default_product_type_simple');

/**
 * Prevent POST resubmission on refresh after add-to-cart (PRG flow).
 *
 * Redirect to a clean product URL without add-to-cart query args.
 *
 * @param string $url Redirect URL from WooCommerce.
 * @return string
 */
function reonet_woocommerce_add_to_cart_prg_redirect($url)
{
  if (is_admin() || wp_doing_ajax()) {
    return $url;
  }

  $product_id = isset($_REQUEST['add-to-cart']) ? absint(wp_unslash($_REQUEST['add-to-cart'])) : 0;
  $fallback_url = wp_get_referer();

  if (!$fallback_url && $product_id > 0) {
    $fallback_url = get_permalink($product_id);
  }

  if (!$fallback_url) {
    $fallback_url = home_url('/');
  }

  return remove_query_arg(
    array('add-to-cart', 'quantity', 'variation_id'),
    $fallback_url
  );
}
add_filter('woocommerce_add_to_cart_redirect', 'reonet_woocommerce_add_to_cart_prg_redirect', 10);

/**
 * Store short-lived auth toast intent in a cookie after login/logout.
 *
 * @param string $state Either "login" or "logout".
 * @return void
 */
function reonet_set_auth_toast_cookie($state)
{
  if (!in_array($state, array('login', 'logout'), true)) {
    return;
  }

  $secure   = is_ssl();
  $httponly = false; // JS must read this cookie to render toast.
  $expires  = time() + 120;
  $path     = defined('COOKIEPATH') && COOKIEPATH ? COOKIEPATH : '/';
  $domain   = defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN : '';

  setcookie('reonet_auth_toast', $state, $expires, $path, $domain, $secure, $httponly);
  $_COOKIE['reonet_auth_toast'] = $state;
}

/**
 * Mark successful frontend login with a toast cookie.
 *
 * @return void
 */
function reonet_mark_login_for_toast($user_login, $user)
{
  if (is_admin()) {
    return;
  }

  reonet_set_auth_toast_cookie('login');
}
add_action('wp_login', 'reonet_mark_login_for_toast', 10, 2);

/**
 * Mark logout with a toast cookie.
 *
 * @return void
 */
function reonet_mark_logout_for_toast()
{
  reonet_set_auth_toast_cookie('logout');
}
add_action('wp_logout', 'reonet_mark_logout_for_toast');

/**
 * --------------------------------------------------------------------------
 * WooCommerce: Variation Gallery Images (Admin)
 * --------------------------------------------------------------------------
 */

/**
 * Normalize and return stored variation gallery image IDs.
 *
 * @param int $variation_id Variation post ID.
 * @return int[]
 */
function reonet_woocommerce_get_variation_gallery_image_ids($variation_id)
{
  $raw_value = get_post_meta($variation_id, '_reonet_variation_gallery_ids', true);

  if (is_array($raw_value)) {
    $raw_ids = $raw_value;
  } else {
    $raw_string = is_string($raw_value) ? $raw_value : '';
    $raw_ids = $raw_string === '' ? array() : explode(',', $raw_string);
  }

  $image_ids = array_values(
    array_unique(
      array_filter(
        array_map('absint', $raw_ids)
      )
    )
  );

  return $image_ids;
}

/**
 * Render variation gallery picker field in variable product admin panel.
 *
 * @param int     $loop           Variation loop index.
 * @param array   $variation_data Variation data from WooCommerce.
 * @param WP_Post $variation      Variation post object.
 * @return void
 */
function reonet_woocommerce_render_variation_gallery_admin_field($loop, $variation_data, $variation)
{
  if (!$variation instanceof WP_Post) {
    return;
  }

  $variation_id = (int) $variation->ID;
  $image_ids = reonet_woocommerce_get_variation_gallery_image_ids($variation_id);
  $ids_value = implode(',', $image_ids);

  echo '<div class="form-row form-row-full _variation-gallery-admin-field">';
  echo '<label>' . esc_html__('Variation Gallery', 'reonet') . '</label>';
  echo '<input type="hidden" class="_variation-gallery-ids" name="reonet_variation_gallery_ids[' . esc_attr($variation_id) . ']" value="' . esc_attr($ids_value) . '" />';
  echo '<div class="_variation-gallery-preview">';

  foreach ($image_ids as $image_id) {
    $thumb_html = wp_get_attachment_image($image_id, 'thumbnail', false, array('class' => '_variation-gallery-preview-image'));
    if ($thumb_html) {
      echo $thumb_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
  }

  echo '</div>';
  echo '<p class="description">' . esc_html__('Upload additional gallery images for this specific variation.', 'reonet') . '</p>';
  echo '<p>';
  echo '<button type="button" class="button _variation-gallery-upload">' . esc_html__('Add / Edit Gallery Images', 'reonet') . '</button> ';
  echo '<button type="button" class="button-link-delete _variation-gallery-clear">' . esc_html__('Clear Gallery', 'reonet') . '</button>';
  echo '</p>';
  echo '</div>';
}
add_action('woocommerce_product_after_variable_attributes', 'reonet_woocommerce_render_variation_gallery_admin_field', 30, 3);

/**
 * Persist variation gallery field value.
 *
 * @param int $variation_id Variation post ID.
 * @param int $loop         Variation loop index.
 * @return void
 */
function reonet_woocommerce_save_variation_gallery_admin_field($variation_id, $loop)
{
  if (!current_user_can('edit_post', $variation_id)) {
    return;
  }

  $posted_ids = isset($_POST['reonet_variation_gallery_ids']) && is_array($_POST['reonet_variation_gallery_ids'])
    ? wp_unslash($_POST['reonet_variation_gallery_ids'])
    : array();

  $raw_value = isset($posted_ids[$variation_id]) ? (string) $posted_ids[$variation_id] : '';
  $image_ids = array_values(
    array_unique(
      array_filter(
        array_map('absint', explode(',', $raw_value))
      )
    )
  );

  if (empty($image_ids)) {
    delete_post_meta($variation_id, '_reonet_variation_gallery_ids');
    return;
  }

  update_post_meta($variation_id, '_reonet_variation_gallery_ids', implode(',', $image_ids));
}
add_action('woocommerce_save_product_variation', 'reonet_woocommerce_save_variation_gallery_admin_field', 10, 2);

/**
 * Expose variation gallery image IDs in variation JSON payload.
 *
 * @param array                $data      Variation payload.
 * @param WC_Product_Variable  $product   Parent variable product.
 * @param WC_Product_Variation $variation Variation object.
 * @return array
 */
function reonet_woocommerce_add_variation_gallery_data($data, $product, $variation)
{
  if (!is_array($data) || !$variation instanceof WC_Product_Variation) {
    return $data;
  }

  $variation_gallery_ids = reonet_woocommerce_get_variation_gallery_image_ids($variation->get_id());
  $data['reonet_variation_gallery_image_ids'] = $variation_gallery_ids;

  $variation_image_id = $variation->get_image_id();
  $all_gallery_ids = array_values(
    array_unique(
      array_filter(
        array_map(
          'absint',
          array_merge(array($variation_image_id), $variation_gallery_ids)
        )
      )
    )
  );

  $gallery_items_html = '';

  if (function_exists('wc_get_gallery_image_html') && !empty($all_gallery_ids)) {
    foreach ($all_gallery_ids as $index => $image_id) {
      $gallery_image_html = wc_get_gallery_image_html($image_id, 0 === $index, $index);

      if (!$gallery_image_html) {
        continue;
      }

      if (function_exists('reonet_woocommerce_prepare_gallery_image_html')) {
        $gallery_image_html = reonet_woocommerce_prepare_gallery_image_html($gallery_image_html, $index > 0);
      }

      $gallery_items_html .= $gallery_image_html;
    }
  }

  if ($gallery_items_html !== '') {
    $data['reonet_variation_gallery_html'] = $gallery_items_html;
  }

  return $data;
}
add_filter('woocommerce_available_variation', 'reonet_woocommerce_add_variation_gallery_data', 30, 3);

/**
 * Load variation gallery media picker script in product edit admin screens.
 *
 * @param string $hook_suffix Current WP admin page hook.
 * @return void
 */
function reonet_woocommerce_enqueue_variation_gallery_admin_assets($hook_suffix)
{
  if (!in_array($hook_suffix, array('post.php', 'post-new.php'), true)) {
    return;
  }

  $screen = function_exists('get_current_screen') ? get_current_screen() : null;
  if (!$screen || $screen->id !== 'product') {
    return;
  }

  wp_enqueue_media();

  $script_path = get_template_directory() . '/assets/js/admin-variation-gallery.js';
  $script_url = get_template_directory_uri() . '/assets/js/admin-variation-gallery.js';

  wp_enqueue_script(
    'reonet-admin-variation-gallery',
    $script_url,
    array('jquery'),
    file_exists($script_path) ? filemtime($script_path) : null,
    true
  );
}
add_action('admin_enqueue_scripts', 'reonet_woocommerce_enqueue_variation_gallery_admin_assets');
