<section class="_slider">
  <div class="container">
    <div class="owl-carousel owl-theme">
      <?php foreach (get_sub_field('slider') as $slide): ?>
        <?php if ($slide['video']): ?>
          <video class="w-full slide-item flex" controls>
            <source src="<?php echo wp_get_attachment_url($slide['video']); ?>" type="video/mp4">
            مرورگر شما از ویدیو پشتیبانی نمی‌کند.
          </video>
        <?php else: ?>
          <div class="_slider-item flex gap-4 sm:bg-gray-100/60 rounded-[30px] <?php echo wp_is_mobile() ? 'flex-col-reverse' : 'flex-row'; ?>">
            <div class="flex flex-col justify-center items-start relative sm:w-1/2 sm:px-6">
              <img class="absolute right-[15px] sm:right-[80px] bottom-[85px] sm:bottom-[130px] !w-16 sm:!w-20 -z-10"
                src="<?php echo get_template_directory_uri() ?>/assets/images/sign-2-v-gray.svg"
                alt="Logo Pattern" />

              <h2 class="text-4xl sm:text-5xl font-bold text-gray-600 leading-tight line-clamp-2 mb-2">
                <?php echo $slide['title']; ?>
              </h2>

              <p class="text-[22px] leading-tight line-clamp-3 text-gray-600">
                <?php echo $slide['content']; ?>
              </p>

              <?php if (!empty($slide['btn']) && !empty($slide['link'])): ?>
                <a href="<?php echo $slide['link']; ?>" class="btn btn-secondary w-full sm:w-auto mt-6">
                  <?php echo $slide['btn']; ?>
                </a>
              <?php endif; ?>
            </div>

            <div class="_image sm:w-1/2">
              <?php echo wp_get_attachment_image($slide['img'], 'full', false, array('class' => 'rounded-[30px]')); ?>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>