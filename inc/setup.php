<?php
if (!defined('ABSPATH')) {
    exit;
}

// Theme support + image sizes
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_image_size('blog', 612, 416, true);
    add_image_size('service', 300, 240, true);
    add_image_size('service-first', 320, 340, true);
});

// Menus
add_action('init', function () {
    register_nav_menus([
        'main-menu'   => __('main menu'),
        'mobile-menu' => __('mobile menu'),
        'footer-menu' => __('footer menu'),
    ]);
});

// Rename "Posts" to "Blog" in admin menu
add_action('admin_menu', function () {
    global $menu;
    if (isset($menu[5][0])) {
        $menu[5][0] = 'Blog';
    }
});

// Add custom class to <li> items in wp_nav_menu
add_filter('nav_menu_css_class', function ($classes, $item, $args) {
    if (isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}, 10, 3);

// Excerpt helper
function reonet_get_excerpt($limit, $source = null)
{
    $excerpt = ($source === 'content') ? get_the_content() : get_the_excerpt();
    $excerpt = preg_replace(" (\[.*?\])", '', $excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = wp_strip_all_tags($excerpt);
    $excerpt = mb_substr($excerpt, 0, $limit);
    $excerpt = mb_substr($excerpt, 0, mb_strrpos($excerpt, " "));
    return trim(preg_replace('/\s+/', ' ', $excerpt));
}

// Simple translation helper (EN/FI)
function _tr($en, $fi)
{
    echo (get_language_attributes() === 'lang="en-US"') ? $en : $fi;
}

// WPML floating language switcher
function wpml_floating_language_switcher()
{
    echo '<div class="wpml-floating-language-switcher">';
    do_action('wpml_add_language_selector');
    echo '</div>';
}
