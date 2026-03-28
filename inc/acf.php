<?php
if (!defined('ABSPATH')) exit;

// Custom logo support
add_action('after_setup_theme', function () {
    add_theme_support('custom-logo');
});

// Helper: get custom logo URL
function reonet_logo_url()
{
    $logo_id = get_theme_mod('custom_logo');
    return $logo_id ? wp_get_attachment_url($logo_id) : '';
}

// ACF Options Pages
if (function_exists('acf_add_options_page')) {

    acf_add_options_page([
        'page_title'  => 'Theme Settings',
        'menu_title'  => 'Theme Settings',
        'menu_slug'   => 'theme-general-settings',
        'capability'  => 'edit_posts',
        'redirect'    => false,
        'position'    => 61,
        'icon_url'    => 'dashicons-admin-generic',
    ]);

    acf_add_options_sub_page([
        'page_title'  => 'Services',
        'menu_title'  => 'Services',
        'menu_slug'   => 'theme-services',
        'capability'  => 'edit_posts',
        'parent_slug' => 'theme-general-settings',
    ]);

    acf_add_options_sub_page([
        'page_title'  => 'Contact Us',
        'menu_title'  => 'Contact Us',
        'menu_slug'   => 'theme-contact',
        'capability'  => 'edit_posts',
        'parent_slug' => 'theme-general-settings',
    ]);
}
