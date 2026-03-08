<?php
/* Template Name: form */
get_header() ?>
    <div class="component">
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
            </div>
            <div class="content mx-auto sm:w-6/12">
				<p class="form-description">
					<?php the_field('description'); ?>
				</p>
                <?php echo do_shortcode('[gravityform id="'.get_field('form').'" title="false"]') ?>
            </div>
        </div>
    </div>

<?php get_footer() ?>