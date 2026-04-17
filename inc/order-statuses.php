<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Return custom order statuses that should be registered in WooCommerce.
 *
 * @return array<string, string>
 */
function reonet_woocommerce_custom_order_statuses()
{
  return array(
    'paid'              => __('Paid', 'reonet'),
    'awaiting-pickup'   => __('Awaiting Pickup', 'reonet'),
    'received'          => __('Received', 'reonet'),
    'service-completed' => __('Service Completed', 'reonet'),
    'packed'            => __('Packed', 'reonet'),
    'out-for-delivery'  => __('Out for Delivery', 'reonet'),
  );
}

/**
 * Register Reonet custom WooCommerce order statuses.
 *
 * @return void
 */
function reonet_woocommerce_register_custom_order_statuses()
{
  $custom_statuses = reonet_woocommerce_custom_order_statuses();

  foreach ($custom_statuses as $status_slug => $status_label) {
    register_post_status(
      'wc-' . $status_slug,
      array(
        'label'                     => $status_label,
        'public'                    => false,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop(
          $status_label . ' <span class="count">(%s)</span>',
          $status_label . ' <span class="count">(%s)</span>',
          'reonet'
        ),
      )
    );
  }
}
add_action('init', 'reonet_woocommerce_register_custom_order_statuses', 9);

/**
 * Replace and reorder WooCommerce order statuses to match business flow.
 *
 * @param array<string, string> $statuses Existing order statuses.
 * @return array<string, string>
 */
function reonet_woocommerce_override_order_statuses($statuses)
{
  $ordered_statuses = array(
    'wc-paid'              => __('Paid', 'reonet'),
    'wc-failed'            => __('Failed', 'reonet'),
    'wc-pending'           => __('Pending Payment', 'reonet'),
    'wc-awaiting-pickup'   => __('Awaiting Pickup', 'reonet'),
    'wc-received'          => __('Received', 'reonet'),
    'wc-on-hold'           => __('On Hold', 'reonet'),
    'wc-processing'        => __('In Processing', 'reonet'),
    'wc-service-completed' => __('Service Completed', 'reonet'),
    'wc-packed'            => __('Packed', 'reonet'),
    'wc-out-for-delivery'  => __('Out for Delivery', 'reonet'),
    'wc-completed'         => __('Delivered', 'reonet'),
    'wc-cancelled'         => __('Canceled', 'reonet'),
    'wc-refunded'          => __('Refunded', 'reonet'),
  );

  foreach ($statuses as $status_key => $status_label) {
    if (!isset($ordered_statuses[$status_key])) {
      $ordered_statuses[$status_key] = $status_label;
    }
  }

  return $ordered_statuses;
}
add_filter('wc_order_statuses', 'reonet_woocommerce_override_order_statuses', 20);

/**
 * Treat operational custom statuses as paid statuses.
 *
 * @param string[] $paid_statuses Existing paid statuses without "wc-" prefix.
 * @return string[]
 */
function reonet_woocommerce_extend_paid_statuses($paid_statuses)
{
  $paid_like_statuses = array(
    'paid',
    'awaiting-pickup',
    'received',
    'service-completed',
    'packed',
    'out-for-delivery',
  );

  foreach ($paid_like_statuses as $status) {
    if (!in_array($status, $paid_statuses, true)) {
      $paid_statuses[] = $status;
    }
  }

  return $paid_statuses;
}
add_filter('woocommerce_order_is_paid_statuses', 'reonet_woocommerce_extend_paid_statuses', 20);

