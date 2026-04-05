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

  pll_register_string('404 Description', 'The page you are looking for does not exist or may have been moved.', 'Theme');
  pll_register_string('Address One', 'Address One', 'Theme');
  pll_register_string('Address Two', 'Address Two', 'Theme');
  pll_register_string('Addresses', 'Addresses', 'Theme');
  pll_register_string('Additional information', 'Additional information', 'Theme');
  pll_register_string('All products', 'All products', 'Theme');
  pll_register_string('Apartment, unit, etc.', 'Apartment, unit, etc.', 'Theme');
  pll_register_string('Apply coupon', 'Apply coupon', 'Theme');
  pll_register_string('Area', 'Area', 'Theme');
  pll_register_string('Back to home', 'Back to home', 'Theme');
  pll_register_string('Billing & Shipping', 'Billing &amp; Shipping', 'Theme');
  pll_register_string('Billing details', 'Billing details', 'Theme');
  pll_register_string('Checkout', 'Checkout', 'Theme');
  pll_register_string('Checkout Login Required', 'You must be logged in to checkout.', 'Theme');
  pll_register_string('Checkout Review Hint', 'Review your details and confirm your order.', 'Theme');
  pll_register_string('Choose a payment method.', 'Choose a payment method.', 'Theme');
  pll_register_string('Contact Information', 'Contact Information', 'Theme');
  pll_register_string('Coupon code', 'Coupon code', 'Theme');
  pll_register_string('Coupon:', 'Coupon:', 'Theme');
  pll_register_string('Create account hint', 'Create an account to track your orders and manage your payment history.', 'Theme');
  pll_register_string('Enter product dimensions', 'Enter product dimensions', 'Theme');
  pll_register_string('Follow Us', 'Follow Us', 'Theme');
  pll_register_string('Information', 'Information', 'Theme');
  pll_register_string('Length (m)', 'Length (m)', 'Theme');
  pll_register_string('Login helper text', 'If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing section.', 'Theme');
  pll_register_string('No payment methods', 'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'Theme');
  pll_register_string('On Sale', 'On Sale', 'Theme');
  pll_register_string('Opening Hours', 'Opening Hours', 'Theme');
  pll_register_string('Order summary', 'Order summary', 'Theme');
  pll_register_string('Other Services', 'Other Services', 'Theme');
  pll_register_string('Page not found', 'Page not found', 'Theme');
  pll_register_string('Payment', 'Payment', 'Theme');
  pll_register_string('Payment details required', 'Please fill in your details above to see available payment methods.', 'Theme');
  pll_register_string('Payment summary hint', 'A final look at your items before payment.', 'Theme');
  pll_register_string('Read more', 'Read more', 'Theme');
  pll_register_string('Returning customer', 'Returning customer', 'Theme');
  pll_register_string('Review checkout items', 'Review items and continue to checkout.', 'Theme');
  pll_register_string('Services', 'Services', 'Theme');
  pll_register_string('Ship to a different address?', 'Ship to a different address?', 'Theme');
  pll_register_string('Shipping method', 'Shipping method', 'Theme');
  pll_register_string('Shipment', 'Shipment', 'Theme');
  pll_register_string('Sign in to speed up checkout and reuse saved details.', 'Sign in to speed up checkout and reuse saved details.', 'Theme');
  pll_register_string('Subtotal', 'Subtotal', 'Theme');
  pll_register_string('Thank you page subtitle', 'Thank you for your purchase. Your order details are below.', 'Theme');
  pll_register_string('Total', 'Total', 'Theme');
  pll_register_string('Update totals', 'Update totals', 'Theme');
  pll_register_string('Update totals browser notice', 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'Theme');
  pll_register_string('VAT', 'VAT', 'Theme');
  pll_register_string('View services', 'View services', 'Theme');
  pll_register_string('Width (m)', 'Width (m)', 'Theme');
}
add_action('init', 'reonet_register_polylang_strings');
