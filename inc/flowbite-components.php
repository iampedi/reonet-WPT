<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!function_exists('reonet_flowbite_input_class_string')) {
  function reonet_flowbite_input_class_string()
  {
    return 'block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 h-11.5 text-[15px] text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20';
  }
}

if (!function_exists('reonet_flowbite_textarea_class_string')) {
  function reonet_flowbite_textarea_class_string()
  {
    return 'block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-3 min-h-32 text-[15px] text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20';
  }
}

if (!function_exists('reonet_flowbite_input_small_class_string')) {
  function reonet_flowbite_input_small_class_string()
  {
    return 'block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20';
  }
}

if (!function_exists('reonet_flowbite_checkbox_class_string')) {
  function reonet_flowbite_checkbox_class_string()
  {
    return 'h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500/30';
  }
}

if (!function_exists('reonet_flowbite_button_class_string')) {
  function reonet_flowbite_button_class_string($variant = 'primary', $size = 'md')
  {
    $initial_classes = 'inline-flex items-center justify-center rounded-full duration-300 focus:outline-none';
    $size_classes = 'px-6 h-11.5 text-[15px]';

    if ($size === 'sm') {
      $size_classes = 'px-4 py-2 text-xs';
    } elseif ($size === 'lg') {
      $size_classes = 'px-6 py-3 text-base';
    } elseif ($size === 'icon') {
      $size_classes = 'size-11.5 rounded-lg';
    }

    if ($variant === 'secondary') {
      return "{$initial_classes} border border-primary/50 bg-white {$size_classes} font-medium text-gray-900 hover:bg-primary/5 focus:ring-4 focus:ring-gray-100";
    }

    return "{$initial_classes} bg-primary {$size_classes} font-medium text-white hover:bg-green focus:ring-4 focus:ring-blue-300";
  }
}

if (!function_exists('reonet_flowbite_order_status_badge_class_string')) {
  function reonet_flowbite_order_status_badge_class_string($status)
  {
    $status = sanitize_html_class((string) $status);
    $base = 'inline-flex items-center whitespace-nowrap rounded-full border px-2.5 py-1 text-[13px]';

    $variants = array(
      'pending'    => 'border-amber-300 bg-amber-100 text-amber-800',
      'processing' => 'border-blue-300 bg-blue-100 text-blue-800',
      'on-hold'    => 'border-gray-300 bg-gray-100 text-gray-700',
      'completed'  => 'border-green-300 bg-green-100 text-green-800',
      'cancelled'  => 'border-red-300 bg-red-100 text-red-700',
      'canceled'   => 'border-red-300 bg-red-100 text-red-700',
      'refunded'   => 'border-slate-300 bg-slate-100 text-slate-700',
      'failed'     => 'border-rose-300 bg-rose-100 text-rose-700',
    );

    return $base . ' ' . (isset($variants[$status]) ? $variants[$status] : 'border-gray-300 bg-gray-100 text-gray-700');
  }
}
