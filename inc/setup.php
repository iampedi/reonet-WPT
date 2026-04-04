<?php
/*
** /inc/setup.php
*/

if (!defined('ABSPATH')) {
    exit;
}

// Theme support + image sizes
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_image_size('blog', 612, 416, true);
    add_image_size('service', 400, 400, true);
});

// Disable unused default image sizes
add_filter('intermediate_image_sizes_advanced', function ($sizes) {
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);

    return $sizes;
});

// Disable big image scaling
add_filter('big_image_size_threshold', '__return_false');

// Menus
add_action('init', function () {
    register_nav_menus([
        'main-menu'   => __('Main Menu', 'reonet'),
        'mobile-menu' => __('Mobile Menu', 'reonet'),
        'footer-menu' => __('Footer Menu', 'reonet'),
        'footer-service' => __('Footer Service', 'reonet'),
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
    $excerpt = mb_substr($excerpt, 0, mb_strrpos($excerpt, ' '));

    return trim(preg_replace('/\s+/', ' ', $excerpt));
}

// Translation helper with Polylang fallback
function reonet_tr($text)
{
    if (function_exists('pll__')) {
        return pll__($text);
    }

    return __($text, 'reonet');
}

function reonet_tr_e($text)
{
    echo reonet_tr($text);
}

function reonet_esc_html_tr($text)
{
    return esc_html(reonet_tr($text));
}

function reonet_esc_html_tr_e($text)
{
    echo reonet_esc_html_tr($text);
}

function reonet_esc_attr_tr($text)
{
    return esc_attr(reonet_tr($text));
}

function reonet_esc_attr_tr_e($text)
{
    echo reonet_esc_attr_tr($text);
}
