<section class="slider">
    <div class="container px-3 sm:px-0">
        <div class="owl-carousel owl-theme">
            <?php foreach (get_sub_field('slider') as $slide): ?>
                <?php if ($slide['video']): ?>
                    <video class="w-full slide-item flex" controls>
                        <source src="<?php echo wp_get_attachment_url($slide['video']); ?>" type="video/mp4">
                        مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                    </video>
                <?php else: ?>
                    <div class="slide-item flex flex-wrap <?php echo wp_is_mobile() ? 'flex-col-reverse' : ''; ?>">
                        <div class="flex flex-col items-start text w-full sm:w-1/2 sm:px-[50px] relative mb-[30px] sm:mb-0">
                            <img class="absolute right-[15px] sm:right-[80px] bottom-[85px] sm:bottom-[130px] !w-[76px]"
                                src="<?php echo get_template_directory_uri() ?>/assets/images/sign-2-v-gray.svg"
                                alt="Logo Pattern" />
                            <h2
                                class="text-[clamp(40px,12vw,50px)] sm:text-[54px] text-gray-600 font-bold uppercase sm:w-full leading-[60px] pt-[15px] sm:pt-[100px]">
                                <?php echo $slide['title']; ?>
                            </h2>
                            <p class="mt-4 text-[20px]">
                                <?php echo $slide['content']; ?>
                            </p>
                            <?php if (!empty($slide['btn']) && !empty($slide['link'])): ?>
                                <a href="<?php echo $slide['link']; ?>" class="mt-7 bg-green-700 hover:bg-gray-600 text-white px-8 font-medium h-[54px] text-[18px] rounded-full transition-all duration-300 flex items-center justify-center w-full sm:w-auto">
                                    <?php echo $slide['btn']; ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="image w-full sm:w-1/2">
                            <?php echo wp_get_attachment_image($slide['img'], 'full', false, array('class' => 'rounded-[30px] sm:rounded-[50px] mb-5 sm:mb-0')); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>