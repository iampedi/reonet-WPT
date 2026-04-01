<?php
if (!defined('ABSPATH')) exit;

add_action('wp_enqueue_scripts', function () {
    // Fonts
    wp_enqueue_style(
        'reonet-font-jost',
        'https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700;800;900&display=swap',
        [],
        null
    );

    // Phosphor Icons Regular
    wp_enqueue_style(
        'phosphor-icons-regular',
        'https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/regular/style.css',
        [],
        '2.1.2'
    );

    // Phosphor Icons Bold
    wp_enqueue_style(
        'phosphor-icons-bold',
        'https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/bold/style.css',
        [],
        '2.1.2'
    );

    // Phosphor Icons Duotone
    wp_enqueue_style(
        'phosphor-icons-duotone',
        'https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/duotone/style.css',
        [],
        '2.1.2'
    );

    // Tailwind compiled CSS
    $tw_path = get_template_directory() . '/assets/css/tailwind.css';
    $tw_url  = get_template_directory_uri() . '/assets/css/tailwind.css';

    if (file_exists($tw_path)) {
        wp_enqueue_style('reonet-tailwind', $tw_url, [], filemtime($tw_path));
    }

    // Legacy CSS
    wp_enqueue_style('reonet-style', get_template_directory_uri() . '/assets/css/style.css', [], null);
    wp_enqueue_style('reonet-responsive', get_template_directory_uri() . '/assets/css/responsive.css', [], null);

    // JS files
    $flowbite_js_path = get_template_directory() . '/node_modules/flowbite/dist/flowbite.min.js';
    $flowbite_js_url  = get_template_directory_uri() . '/node_modules/flowbite/dist/flowbite.min.js';

    if (file_exists($flowbite_js_path)) {
        wp_enqueue_script(
            'reonet-flowbite',
            $flowbite_js_url,
            [],
            filemtime($flowbite_js_path),
            true
        );
    }

    wp_enqueue_script('reonet-owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', ['jquery'], '2.3.4', true);
    wp_enqueue_script('reonet-owl-nav', get_template_directory_uri() . '/assets/js/owl.navigation.js', ['jquery'], null, true);
    $app_js_path = get_template_directory() . '/assets/js/app.js';
    $app_js_url  = get_template_directory_uri() . '/assets/js/app.js';

    $app_deps = ['jquery'];
    if (wp_script_is('reonet-flowbite', 'enqueued')) {
        $app_deps[] = 'reonet-flowbite';
    }
    if (wp_script_is('wc-cart-fragments', 'registered')) {
        $app_deps[] = 'wc-cart-fragments';
    }

    wp_enqueue_script(
        'reonet-app',
        $app_js_url,
        $app_deps,
        file_exists($app_js_path) ? filemtime($app_js_path) : null,
        true
    );
}, 20);

