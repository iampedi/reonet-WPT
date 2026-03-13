<?php
/*
Template Name: Static Page Template (Mammin Editor)
*/
// If you want the content to be processed by WordPress (e.g., shortcodes), use:
// the_content();
// If you want raw HTML from the post_content field (as was likely intended for static pages):
global $post;
if (is_a($post, "WP_Post")) {
    $page_html_id_attr = \MamminEditor\Core\Utilities::extract_html_page_id($post->post_content);
    if ($page_html_id_attr) {
        echo "<!-- Mammin Editor Page ID: " . esc_attr($page_html_id_attr) . " -->\n";
    }
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo $post->post_content;
}
?>