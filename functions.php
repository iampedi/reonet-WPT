<?php
if (!defined('ABSPATH')) {
  exit;
}

$base = get_template_directory();
$modules = [
  '/inc/setup.php',
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
    error_log('[Theme] Missing module: ' . $path);
  }
}

// Admin: enable media uploader
add_action('admin_enqueue_scripts', function () {
  wp_enqueue_media();
});

// Remove "Archive:" prefix in archive titles
add_filter('get_the_archive_title', function ($title) {
  if (is_category()) return single_cat_title('', false);
  if (is_tag()) return single_tag_title('', false);
  if (is_author()) return '<span class="vcard">' . get_the_author() . '</span>';
  if (is_tax()) return single_term_title('', false);
  if (is_post_type_archive()) return post_type_archive_title('', false);
  return $title;
});
