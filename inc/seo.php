<?php

/**
 * /inc/seo.php
 * Minimal SEO output (safe + ACF-aware):
 * - meta description
 * - optional rating JSON-LD for single Service pages (ACF fields: initialRating, ratingCount)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_head', function () {

    // Only run ACF-based SEO if ACF is available
    if (!function_exists('get_field')) {
        return;
    }

    /**
     * META DESCRIPTION
     * Priority:
     * 1) ACF seo_description (if set and not CPT archive)
     * 2) Singular: excerpt or trimmed content from queried post
     * 3) Site tagline
     * 4) Site name (final fallback)
     */
    $description = '';

    if (!is_post_type_archive()) {
        $acf_desc = (string) get_field('seo_description');
        if ($acf_desc !== '') {
            $description = $acf_desc;
        }
    }

    if ($description === '' && is_singular()) {
        $post_id = get_queried_object_id();

        $excerpt = get_the_excerpt($post_id);
        if (!empty($excerpt)) {
            $description = $excerpt;
        } else {
            $content = get_post_field('post_content', $post_id);
            $content = wp_strip_all_tags($content ?: '');
            $description = wp_trim_words($content, 28, '');
        }
    }

    if ($description === '') {
        $description = (string) get_bloginfo('description');
    }

    if ($description === '') {
        $description = (string) get_bloginfo('name');
    }

    $description = wp_strip_all_tags($description);
    echo '<meta name="description" content="' . esc_attr($description) . "\" />\n";

    /**
     * RATING JSON-LD (optional)
     * Only output on single Service pages, and only if ACF rating fields are valid.
     *
     * ACF fields expected:
     * - initialRating (e.g., 4.7)
     * - ratingCount  (e.g., 128)
     */
    if (is_singular('service')) {
        $ratingValue = (string) get_field('initialRating');
        $ratingCount = (string) get_field('ratingCount');

        if ($ratingValue !== '' && $ratingCount !== '' && is_numeric($ratingValue) && is_numeric($ratingCount)) {
            $schema = [
                [
                    "@context" => "https://schema.org",
                    "@type" => "CreativeWorkSeason",
                    "name" => wp_get_document_title(),
                    "aggregateRating" => [
                        "@type" => "AggregateRating",
                        "ratingValue" => (float) $ratingValue,
                        "ratingCount" => (int) $ratingCount,
                        "bestRating" => "5",
                        "worstRating" => "1",
                    ],
                ]
            ];

            echo "<script type=\"application/ld+json\">" .
                wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) .
                "</script>\n";
        }
    }
}, 10);
