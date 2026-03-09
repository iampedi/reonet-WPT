<section class="_home-mod-cta bg-blue-900">
    <div class="container px-3 sm:px-0">
        <div
            class="flex flex-wrap justify-center content-center sm:h-[490px] bg-[url('<?php echo get_template_directory_uri() ?>/assets/images/home-bubbles-bg-01.png')] bg-no-repeat bg-center py-[50px] sm:py-0">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/icon/green-heart-icon.svg"
                alt="White Heart in middle of a green circle" />
            <h2 class="text-white w-full text-center mt-5 text-[38px] sm:text-[40px] font-medium">
                <?php the_sub_field('title'); ?>
            </h2>
            <p class="text-gray-300 mx-auto text-center text-[19px] sm:text-[20px] leading-[24px] mt-3 sm:w-8/12">
                <strong><?php the_sub_field('subtitle'); ?></strong>
                <?php the_sub_field('content'); ?>
            </p>
            <div class="w-full text-center">
                <button class="btn btn-green mt-7">
                    <?php the_sub_field('btn'); ?>
                </button>
            </div>
        </div>
    </div>
</section>