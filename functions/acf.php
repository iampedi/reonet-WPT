<?php
//  custom logo
function mytheme_setup()
{
    add_theme_support('custom-logo');
}

add_action('after_setup_theme', 'mytheme_setup');

//  custom logo link
function logoLink()
{
    echo esc_url(wp_get_attachment_url(get_theme_mod('custom_logo')));
}


if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Theme Setting',
        'menu_title' => 'Theme Setting',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}
if (function_exists('acf_add_options_page')) {


    acf_add_options_page(array(
        'page_title' => 'Contact Us',
        'menu_title' => 'Contact Us',
        'capability' => 'edit_posts',
        'menu_slug' => 'contact',
        'parent_slug' => 'theme-general-settings',
    ));





}


