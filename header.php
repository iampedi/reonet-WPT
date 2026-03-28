<?php
if (!defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class('font-jost'); ?>>
  <div id="site-loader" class="site-loader">
    <div class="site-loader__spinner"></div>
  </div>

  <?php wp_body_open(); ?>

  <div class="page-wrap">
    <?php get_template_part('template-parts/layout/header'); ?>