<?php
/* Template Name: About Page */
get_header();

$header_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>
<div class="component _about">
    <div class="container">

        <div class="page-header h-80 relative rounded-[30px] bg-cover bg-center bg-no-repeat"
            <?php if (!empty($header_image_url)) : ?>
            style="background-image: url('<?php echo esc_url($header_image_url); ?>');"
            <?php endif; ?>>

            <div class="bg-black/40 text-white absolute inset-0 rounded-[30px] flex items-center justify-center px-4">
                <h1 class="text-4xl uppercase font-semibold text-center text-shadow-lg">
                    <?php the_title(); ?>
                </h1>
            </div>
        </div>

        <div class="page-title relative pt-16">
            <div class="symbol"></div>
        </div>

        <div class="content mt-8 mb-16 sm:mt-12 sm:bg-blue-50/75 p-0 sm:p-10 max-w-3xl mx-auto">
            <?php the_content(); ?>
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