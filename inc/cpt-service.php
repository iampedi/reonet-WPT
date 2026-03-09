<?php

/**
 * Custom Post Type: Service
 * - Post type key: service
 * - Per-language slugs via WPML:
 *   EN => /services/
 *   FI => /palvelut/
 * - Hierarchical URLs:
 *   /{base}/{parent}/{child}/ (e.g., /palvelut/mattopesu/vantaa/)
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the "Service" custom post type.
 */
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

        // Enable parent/child structure like Pages
        'hierarchical'        => true,

        // Add "page-attributes" so you can set Parent and Order in admin
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),

        // Optional: enable built-in taxonomies
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

        // Enable an archive page; archive slug will be overridden per language
        'has_archive'         => true,

        // Default rewrite slug (overridden per language via WPML filter below)
        'rewrite'             => array(
            'slug'         => 'services',
            'with_front'   => false,
            'hierarchical' => true,
        ),

        // Enable Gutenberg / REST API support
        'show_in_rest'        => true,
    );

    register_post_type('service', $args);
}

// Use a slightly later priority so WPML language is more likely available
add_action('init', 'reonet_register_service_cpt', 20);

/**
 * WPML: Override the CPT slug and archive slug per language.
 */
add_filter('register_post_type_args', function ($args, $post_type) {
    if ($post_type !== 'service') {
        return $args;
    }

    // Only run if WPML is available
    if (!has_filter('wpml_current_language')) {
        return $args;
    }

    $lang = apply_filters('wpml_current_language', null);

    // Map language code => slug
    $slugs = array(
        'en'    => 'services',
        'en-US' => 'services',
        'fi'    => 'palvelut',
        'fi-FI' => 'palvelut',
    );

    $slug = isset($slugs[$lang]) ? $slugs[$lang] : 'services';

    // Override rewrite rules for the CPT
    $args['rewrite'] = array_merge($args['rewrite'] ?? array(), array(
        'slug'         => $slug,
        'with_front'   => false,
        'hierarchical' => true,
    ));

    // Make the archive page use the same slug as the CPT base
    $args['has_archive'] = $slug;

    return $args;
}, 20, 2);

/**
 * IMPORTANT:
 * After adding/changing rewrite/slug settings:
 * WordPress Admin -> Settings -> Permalinks -> Save Changes
 * (This flushes rewrite rules.)
 */
