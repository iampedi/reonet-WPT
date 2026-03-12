<?php

/**
 * /inc/seo.php
 *
 * Lightweight SEO additions for the theme.
 * Important:
 * - Title, meta description, canonical, Open Graph, Twitter tags, robots, sitemap
 *   should be handled by an SEO plugin like Yoast.
 * - This file only outputs optional structured data for single Service pages.
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Output optional AggregateRating schema for single Service pages.
 *
 * Expected ACF fields:
 * - initialRating (example: 4.7)
 * - ratingCount   (example: 128)
 */
add_action('wp_head', function () {

	// ACF is required for these custom fields
	if (!function_exists('get_field')) {
		return;
	}

	// Only on single service pages
	if (!is_singular('service')) {
		return;
	}

	$post_id = get_queried_object_id();
	if (!$post_id) {
		return;
	}

	$rating_value = get_field('initialRating', $post_id);
	$rating_count = get_field('ratingCount', $post_id);

	// Validate required values
	if ($rating_value === null || $rating_value === '' || $rating_count === null || $rating_count === '') {
		return;
	}

	if (!is_numeric($rating_value) || !is_numeric($rating_count)) {
		return;
	}

	$rating_value = (float) $rating_value;
	$rating_count = (int) $rating_count;

	// Basic sanity checks
	if ($rating_value < 1 || $rating_value > 5 || $rating_count < 1) {
		return;
	}

	$schema = [
		'@context' => 'https://schema.org',
		'@type'    => 'Service',
		'name'     => get_the_title($post_id),
		'url'      => get_permalink($post_id),
		'aggregateRating' => [
			'@type'       => 'AggregateRating',
			'ratingValue' => $rating_value,
			'ratingCount' => $rating_count,
			'bestRating'  => 5,
			'worstRating' => 1,
		],
	];

	// Optional description
	$description = get_the_excerpt($post_id);
	if (!empty($description)) {
		$schema['description'] = wp_strip_all_tags($description);
	}

	echo '<script type="application/ld+json">' .
		wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) .
		'</script>' . "\n";
}, 20);

add_filter('document_title_parts', function ($title) {
	if (is_post_type_archive('service')) {
		$lang = apply_filters('wpml_current_language', null);
		$title['title'] = ($lang === 'fi') ? 'Palvelut' : 'Services';
	}

	return $title;
});
