<?php

/**
 * Custom Post Type: Service
 * - Post type key: service
 * - Per-language slugs via WPML:
 *   EN => /services/
 *   FI => /palvelut/
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the "Service" custom post type.
 */
function reonet_register_service_cpt()
{
    // UI labels used in the WordPress admin
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

    // Core registration arguments for the post type
    $args = array(
        'label'               => __('Services', 'textdomain'),
        'description'         => __('Services', 'textdomain'),
        'labels'              => $labels,

        // Editor/UI features enabled for this post type
        // NOTE: Do not use "tags" here; tags/categories are enabled via "taxonomies"
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),

        // Enable built-in taxonomies (optional)
        // Remove 'category' or 'post_tag' if you don't want them for Services
        'taxonomies'          => array('category', 'post_tag'),

        'hierarchical'        => false,
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

        // Enable an archive page; the actual archive slug will be overridden per language
        'has_archive'         => true,

        // Default rewrite slug (will be overridden per language via WPML filter below)
        'rewrite'             => array(
            'slug'       => 'services',
            'with_front' => false,
        ),

        // Enable Gutenberg / REST API support
        'show_in_rest'        => true,
    );

    register_post_type('service', $args);
}
add_action('init', 'reonet_register_service_cpt', 0);

/**
 * WPML: Override the CPT slug and archive slug per language.
 * This makes URLs like:
 * - English: /services/ and /services/{post-slug}/
 * - Finnish: /palvelut/ and /palvelut/{post-slug}/
 */
add_filter('register_post_type_args', function ($args, $post_type) {
    // Only target the "service" post type
    if ($post_type !== 'service') {
        return $args;
    }

    // Only run if WPML is available
    if (!has_filter('wpml_current_language')) {
        return $args;
    }

    // Read the current WPML language code (e.g., "en", "fi")
    $lang = apply_filters('wpml_current_language', null);

    // Define per-language slugs here
    $slugs = array(
        'en' => 'services',
        'fi' => 'palvelut',
    );

    // Fallback to English slug if language is not mapped
    $slug = isset($slugs[$lang]) ? $slugs[$lang] : 'services';

    // Override rewrite rules for the CPT
    $args['rewrite'] = array_merge($args['rewrite'] ?? array(), array(
        'slug'       => $slug,
        'with_front' => false,
    ));

    // Make the archive page use the same slug as the CPT base
    $args['has_archive'] = $slug;

    return $args;
}, 20, 2);

/**
 * IMPORTANT:
 * After adding or changing rewrite/slug settings, go to:
 * Settings -> Permalinks -> Save Changes
 * to flush rewrite rules.
 */
