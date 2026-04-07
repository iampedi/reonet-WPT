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
  <div id="site-loader" class="fixed inset-0 z-99999 flex items-center justify-center bg-white opacity-100 transition-opacity duration-300">
    <div class="h-9 w-9 animate-spin rounded-full border-[3px] border-gray-200 border-t-primary"></div>
  </div>

  <?php wp_body_open(); ?>

  <div class="page-wrap">
    <?php get_template_part('template-parts/layout/header'); ?>