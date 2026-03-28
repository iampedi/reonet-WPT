<?php

/**
 * Template Name: Page Builder
 */
get_header();

if (have_posts()) :
   while (have_posts()) : the_post();

      if (have_rows('pagebuilder')) :
         while (have_rows('pagebuilder')) : the_row();
            get_template_part('page-builder/content', get_row_layout());
         endwhile;
      else :
         get_template_part('page-builder/content-page');
      endif;

   endwhile;
endif;

get_footer();
