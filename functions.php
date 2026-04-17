<?php
/*
** /functions.php
*/

if (!defined('ABSPATH')) {
  exit;
}

$base = get_template_directory();

$modules = [
  '/inc/setup.php',
  '/inc/flowbite-components.php',
  '/inc/woocommerce.php',
  '/inc/menu-walker.php',
  '/inc/translations.php',
  '/inc/order-statuses.php',
  '/inc/enqueue.php',
  '/inc/cpt-service.php',
  '/inc/acf.php',
  '/inc/seo.php',
];

foreach ($modules as $m) {
  $path = $base . $m;

  if (file_exists($path)) {
    require_once $path;
  } else {
    if (defined('WP_DEBUG') && WP_DEBUG) {
      error_log('[Theme] Missing module: ' . $path);
    }
  }
}

// Admin: enable media uploader
add_action('admin_enqueue_scripts', function () {
  wp_enqueue_media();
});
