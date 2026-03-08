<?php get_header(); ?>
    <div class="component blog" style="margin-bottom:8rem;">
        <div class="container px-4 sm:px-0">
            <div class="blog-header flex flex-col-reverse sm:flex-row gap-10 sm:gap-20">
                <div class="relative flex items-center basis-full sm:basis-1/2">
                    <h1 class="mb-4 fs-4 lh-lg" style="font-size: unset;!important"><?php the_title(); ?></h1>
					<!-- <p class="w-4/5"><?php the_excerpt();?></p> -->
                    <div class="absolute bottom-[75px] right-[50px]"><img src="<?php echo get_template_directory_uri() ?>/assets//images/sign-2-v-gray.svg" alt="" /></div>
                </div>
                <div class="basis-full sm:basis-1/2">
                    <?php if (has_post_thumbnail(get_the_id())) echo get_the_post_thumbnail(get_the_id(), 'full', array('class' => 'single-thumb img-fluid w-100 rounded-4')); ?>
                </div>
            </div>
            <div class="blog-body mt-5 sm:mt-10">
                <?php the_content();?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>