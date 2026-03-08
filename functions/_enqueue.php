<?php
// css & js load
function loadfiles()
{
    if (is_admin()) {
        return;
    }
    // wp_enqueue_style('bootstrap-min', get_template_directory_uri() . '/assets/css/bootstrap/bootstrap.min.css', false);
    // wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/swiper.css', false);
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css', false);
    // wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css', false);

    // wp_enqueue_script('jq', get_template_directory_uri() . '/assets/js/jquery-3.7.0.min.js', false, null, true);
    // wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', false, null, true);
    // wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/js/bootstrap.bundle.js', false, null, true);
    wp_enqueue_script(
        'owl-carousel',
        get_template_directory_uri() . '/assets/js/owl.carousel.js',
        array('jquery'),
        '2.3.4',
        true
    );
    wp_enqueue_script('owl-nav', get_template_directory_uri() . '/assets/js/owl.navigation.js', false, null, true);
    wp_enqueue_script(
        'app',
        get_template_directory_uri() . '/assets/js/app.js',
        array('jquery'),
        '1.1.8',
        true
    );
    if (is_page_template('template/contact.php')) {
        wp_enqueue_style('leaflet', get_stylesheet_directory_uri() . '/assets/css/leaflet.css', false);
        wp_enqueue_script('leaflet', get_template_directory_uri() . '/assets/js/leaflet.js', false, null, false);
    }

    wp_dequeue_style('wpsh-style');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('wpsh-blocks-shamsi-style');
    wp_dequeue_style('wpsh-blocks-justify-style');
    wp_dequeue_style('wpsh-blocks-aparat-style');
    wp_dequeue_style('wp-block-library');
}
add_action('wp_enqueue_scripts', 'loadfiles');

function disable_wp_emojicons()
{
    // all actions related to emojis
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    // filter to remove TinyMCE emojis
    if (!is_admin()) {
        add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
    }
}
add_action('init', 'disable_wp_emojicons');

remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

add_filter('xmlrpc_enabled', '__return_false');

add_filter('rest_authentication_errors', function ($result) {
    if (!empty($result)) {
        return $result;
    }
    if (!is_user_logged_in()) {
        return new WP_Error('rest_not_logged_in', 'You are not currently logged in.', array('status' => 401));
    }
    return $result;
});

function remove_json_api()
{
    // Remove the REST API lines from the HTML Header
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Turn off oEmbed auto discovery.
    add_filter('embed_oembed_discover', '__return_false');

    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');

    // Remove all embeds rewrite rules. IT MUST COMMENT
    //add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
}
add_action('after_setup_theme', 'remove_json_api');

function remove_version()
{
    return '';
}
add_filter('the_generator', 'remove_version');

add_action('template_redirect', 'lf_custom_cpt_display');
function lf_custom_cpt_display()
{
    if (is_post_type_archive() || is_singular()) : {
            remove_action('wp_head', 'feed_links_extra', 3);
            remove_action('wp_head', 'feed_links', 2);
        }
    endif;
}
