<!-- washapp section -->
<section class="home-mod-washapp pt-[50px]">
    <div class="container px-3 sm:px-0">
        <div class="wrap flex items-center justify-between flex-col sm:flex-row gap-5 sm:gap-3">
            <div class="flex items-center flex-col sm:flex-row gap-3 sm:gap-2">
                <p class="text-[24px] font-medium text-[#0f77b6] text-center sm:text-left"><?php the_sub_field('title'); ?></p>
                <img class="h-[40px] w-auto"
                    src="<?php echo get_template_directory_uri() ?>/assets/images/washapp-logo.png"
                    alt="Washapp Logo" />
            </div>

            <div class="images flex flex-col justify-center items-center">
                <img class="h-[120px] sm:h-[80px] w-auto"
                    src="<?php echo get_template_directory_uri() ?>/assets/images/washapp-barcode.jpg"
                    alt="Washapp Barcode" />
            </div>
        </div>
    </div>
</section>