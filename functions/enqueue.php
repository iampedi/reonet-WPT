<?php
// Load CSS & JS for frontend only
function loadfiles()
{
    // Prevent loading in wp-admin (important for media uploader to work)
    if (is_admin()) return;

    // CSS files
    wp_enqueue_style('bootstrap-min', get_template_directory_uri() . '/assets/css/bootstrap/bootstrap.min.css', [], null);
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/swiper.css', [], null);
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css', [], null);
    wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css', [], null);

    // JS files — use WordPress's built-in jQuery
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', ['jquery'], null, true);
    wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/js/bootstrap.bundle.js', ['jquery'], null, true);
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', ['jquery'], '2.3.4', true);
    wp_enqueue_script('owl-nav', get_template_directory_uri() . '/assets/js/owl.navigation.js', ['jquery'], null, true);
    wp_enqueue_script('app', get_template_directory_uri() . '/assets/js/app.js', ['jquery'], '1.1.8', true);

    // Conditional: only load Leaflet if using the contact template
    if (is_page_template('template/contact.php')) {
        wp_enqueue_style('leaflet', get_template_directory_uri() . '/assets/css/leaflet.css', [], null);
        wp_enqueue_script('leaflet', get_template_directory_uri() . '/assets/js/leaflet.js', [], null, true);
    }
}
add_action('wp_enqueue_scripts', 'loadfiles');

// Disable emojis
function disable_wp_emojicons()
{
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    if (!is_admin()) {
        add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
    }
}
function disable_emojicons_tinymce($plugins)
{
    return array_diff($plugins, ['wpemoji']);
}
add_action('init', 'disable_wp_emojicons');

// Remove some unnecessary stuff from wp_head
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
add_filter('the_generator', '__return_empty_string');

// Disable REST API for non-logged-in users
add_filter('rest_authentication_errors', function ($result) {
    if (!empty($result)) {
        return $result;
    }
    if (!is_user_logged_in()) {
        return new WP_Error('rest_not_logged_in', 'You are not currently logged in.', ['status' => 401]);
    }
    return $result;
});

// Remove oEmbed and JSON API discovery
function remove_json_api()
{
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('rest_api_init', 'wp_oembed_register_route');
    add_filter('embed_oembed_discover', '__return_false');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('after_setup_theme', 'remove_json_api');

// Remove RSS feed links (optional)
add_action('template_redirect', function () {
    if (is_post_type_archive() || is_singular()) {
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'feed_links', 2);
    }
});
