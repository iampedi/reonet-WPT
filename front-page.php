<?php

/**
 * Front Page: Used when a static page is selected as the site homepage
 */

get_header();
?>

<main class="home-page">
   <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>

         <?php get_template_part('template-parts/home/slider'); ?>

         <?php if (function_exists('have_rows') && have_rows('page_builder')) : ?>
            <?php while (have_rows('page_builder')) : the_row(); ?>
               <?php get_template_part('page-builder/content', get_row_layout()); ?>
            <?php endwhile; ?>
         <?php endif; ?>

      <?php endwhile; ?>
   <?php endif; ?>
</main>

<?php
get_footer();
