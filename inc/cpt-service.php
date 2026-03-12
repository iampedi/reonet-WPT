<?php

if (!defined('ABSPATH')) {
    exit;
}

function reonet_register_service_cpt()
{
    $labels = array(
        'name'                  => _x('Services', 'Post Type General Name', 'textdomain'),
        'singular_name'         => _x('Service', 'Post Type Singular Name', 'textdomain'),
        'menu_name'             => __('Services', 'textdomain'),
        'name_admin_bar'        => __('Service', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Service', 'textdomain'),
        'edit_item'             => __('Edit Service', 'textdomain'),
        'new_item'              => __('New Service', 'textdomain'),
        'view_item'             => __('View Service', 'textdomain'),
        'view_items'            => __('View Services', 'textdomain'),
        'search_items'          => __('Search Services', 'textdomain'),
        'not_found'             => __('Not found', 'textdomain'),
        'not_found_in_trash'    => __('Not found in Trash', 'textdomain'),
        'all_items'             => __('All Services', 'textdomain'),
        'archives'              => __('Service Archives', 'textdomain'),
        'attributes'            => __('Service Attributes', 'textdomain'),
        'featured_image'        => __('Featured Image', 'textdomain'),
        'set_featured_image'    => __('Set featured image', 'textdomain'),
        'remove_featured_image' => __('Remove featured image', 'textdomain'),
        'use_featured_image'    => __('Use as featured image', 'textdomain'),
    );

    $args = array(
        'label'               => __('Services', 'textdomain'),
        'description'         => __('Services', 'textdomain'),
        'labels'              => $labels,
        'hierarchical'        => true,
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'taxonomies'          => array('category', 'post_tag'),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-hammer',
        'can_export'          => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'has_archive'         => true,
        'rewrite'             => array(
            'slug'         => 'services',
            'with_front'   => false,
            'hierarchical' => true,
        ),
        'show_in_rest'        => true,
    );

    register_post_type('service', $args);
}

add_action('init', 'reonet_register_service_cpt', 20);
