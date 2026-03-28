<?php
/*
** /inc/translations.php
*/

if (!defined('ABSPATH')) {
  exit;
}

function reonet_register_polylang_strings()
{
  if (!function_exists('pll_register_string')) {
    return;
  }

  pll_register_string('Address One', 'Address One', 'Theme');
  pll_register_string('Address Two', 'Address Two', 'Theme');
  pll_register_string('Addresses', 'Addresses', 'Theme');
  pll_register_string('Contact Information', 'Contact Information', 'Theme');
  pll_register_string('Enter product dimensions', 'Enter product dimensions', 'Theme');
  pll_register_string('Follow Us', 'Follow Us', 'Theme');
  pll_register_string('Information', 'Information', 'Theme');
  pll_register_string('Length (m)', 'Length (m)', 'Theme');
  pll_register_string('On Sale', 'On Sale', 'Theme');
  pll_register_string('Opening Hours', 'Opening Hours', 'Theme');
  pll_register_string('Other Services', 'Other Services', 'Theme');
  pll_register_string('Price per m²', 'Price per m²', 'Theme');
  pll_register_string('Read more', 'Read more', 'Theme');
  pll_register_string('Services', 'Services', 'Theme');
  pll_register_string('Width (m)', 'Width (m)', 'Theme');
  pll_register_string('Area', 'Area', 'Theme');
}
add_action('init', 'reonet_register_polylang_strings');
