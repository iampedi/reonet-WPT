<?php
/* Template Name: Form Page */
get_header()
?>
<div class="component _form">
    <div class="container">
        <div class="page-header h-80 relative rounded-[30px] bg-right bg-cover bg-no-repeat"
            style="background-image: url(<?php the_field('header_image'); ?>) !important;">
            <div class="bg-black/40 absolute w-full right-0 h-full rounded-[30px] flex items-center justify-center px-4">
                <h1 class="text-white text-[40px] font-semibold text-shadow-lg leading-none"><?php the_field('subtitle'); ?></h1>
            </div>
        </div>

        <div class="page-title relative pt-28">
            <div class="symbol"></div>
            <div class="line"></div>
            <h2 class="text-4xl uppercase font-semibold text-center mb-10 sm:mb-14"><?php the_title() ?></h2>
        </div>

        <div class="content mx-auto sm:w-6/12 pb-24 sm:pb-32">
            <p class="form-description">
                <?php the_field('description'); ?>
            </p>
            <?php echo do_shortcode('[gravityform id="' . get_field('form') . '" title="false"]') ?>
        </div>
    </div>
</div>

<?php get_footer() ?>