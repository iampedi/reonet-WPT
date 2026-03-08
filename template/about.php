<?php
/* Template Name: about */
get_header();
?>

    <div class="component about">
        <div class="container px-3 sm:px-0">
            <style>
                .page-header.simple:before {
                    background-image: url(<?php the_field('header_image'); ?>) !important;
                }
            </style>
            <div class="page-header simple">
                <h1><?php the_field('subtitle'); ?></h1>
            </div>
            <div class="page-title">
                <div class="symbol"></div>
                <div class="line"></div>
                <h2><?php the_title() ?></h2>
            </div>
            <div class="content mx-auto sm:w-8/12 text-[19px] relative">
                <?php
                the_content();
                ?>
                <div class="absolute -bottom-[120px] sm:-bottom-[80px] right-0 sm:-right-[40px]">
                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/badge-01.png"/>
                </div>
            </div>
        </div>

        <?php

        if (have_rows('pagebuilder')) :
            while (have_rows('pagebuilder')) : the_row();
                get_template_part('page-builder/content', get_row_layout());
            endwhile;
        endif;

        ?>

    </div>

<?php get_footer(); ?>