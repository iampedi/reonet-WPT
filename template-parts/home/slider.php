<?php
$slides = function_exists('get_field') ? get_field('home_slider') : array();
$slides = is_array($slides) ? array_values($slides) : array();
$carousel_id = '_home-flowbite-carousel';
?>

<section class="_slider mb-6">
   <div class="container">
      <?php if (!empty($slides)) : ?>
         <div id="<?php echo esc_attr($carousel_id); ?>" class="relative w-full" data-carousel="slide" data-carousel-interval="5000">
            <div class="relative overflow-hidden rounded-[30px] transition-[height] duration-300" data-carousel-track>
               <?php foreach ($slides as $index => $slide) : ?>
                  <?php
                  $slide_title = isset($slide['slide_title']) ? $slide['slide_title'] : '';
                  $slide_text = isset($slide['slide_text']) ? $slide['slide_text'] : '';
                  $slide_button_link = isset($slide['slide_button_link']) ? $slide['slide_button_link'] : '';
                  $slide_button_text = isset($slide['slide_button_text']) ? $slide['slide_button_text'] : '';
                  $slide_image_raw = isset($slide['slide_image']) ? $slide['slide_image'] : '';

                  $slide_image_url = '';
                  if (is_array($slide_image_raw) && isset($slide_image_raw['url'])) {
                     $slide_image_url = (string) $slide_image_raw['url'];
                  } elseif (is_numeric($slide_image_raw)) {
                     $slide_image_url = (string) wp_get_attachment_image_url((int) $slide_image_raw, 'full');
                  } else {
                     $slide_image_url = (string) $slide_image_raw;
                  }

                  $button_url = '';
                  $button_target = '_self';
                  $slide_button_class = function_exists('reonet_flowbite_button_class_string')
                     ? reonet_flowbite_button_class_string('secondary', 'md')
                     : 'btn btn-secondary';
                  if (is_array($slide_button_link)) {
                     $button_url = isset($slide_button_link['url']) ? (string) $slide_button_link['url'] : '';
                     $button_target = isset($slide_button_link['target']) ? (string) $slide_button_link['target'] : '_self';
                  } else {
                     $button_url = (string) $slide_button_link;
                  }
                  ?>

                  <div class="<?php echo $index === 0 ? 'block' : 'hidden'; ?> duration-700 ease-in-out" data-carousel-item="<?php echo $index === 0 ? 'active' : ''; ?>">
                     <div class="_slider-item flex flex-col-reverse sm:flex-row sm:items-stretch sm:bg-gray-100/60 rounded-[30px]">
                        <div class="flex flex-col justify-center items-start relative sm:w-1/2 sm:px-14 p-4 sm:p-8 overflow-hidden">
                           <img
                              class="absolute right-[15px] sm:right-[80px] bottom-[85px] sm:bottom-[130px] !w-16 sm:!w-20 -z-10"
                              src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/sign-2-v-gray.svg'); ?>"
                              alt="Logo Pattern" />

                           <?php if ($slide_title !== '') : ?>
                              <h2 class="text-4xl sm:text-5xl font-bold text-gray-600 leading-tight line-clamp-2 mb-2">
                                 <?php echo esc_html($slide_title); ?>
                              </h2>
                           <?php endif; ?>

                           <?php if ($slide_text !== '') : ?>
                              <p class="text-[22px] leading-tight line-clamp-3 text-gray-600">
                                 <?php echo wp_kses_post($slide_text); ?>
                              </p>
                           <?php endif; ?>

                           <?php if ($button_url !== '' && $slide_button_text !== '') : ?>
                              <a
                                 href="<?php echo esc_url($button_url); ?>"
                                 target="<?php echo esc_attr($button_target); ?>"
                                 class="<?php echo esc_attr(trim($slide_button_class . ' w-full sm:w-auto mt-6')); ?>">
                                 <?php echo esc_html($slide_button_text); ?>
                              </a>
                           <?php endif; ?>
                        </div>

                        <div class="_image sm:w-1/2 aspect-square overflow-hidden rounded-[30px]">
                           <?php if ($slide_image_url !== '') : ?>
                              <img
                                 src="<?php echo esc_url($slide_image_url); ?>"
                                 alt="<?php echo esc_attr($slide_title ?: 'Slide Image'); ?>"
                                 class="h-full w-full object-cover" />
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
               <?php endforeach; ?>
            </div>

            <?php if (count($slides) > 1) : ?>
               <button type="button" class="group absolute top-1/2 left-3 z-30 -translate-y-1/2 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-primary shadow-sm duration-200 hover:bg-white pointer-events-auto cursor-pointer" data-carousel-prev aria-label="<?php echo esc_attr(reonet_tr('Previous slide')); ?>">
                  <i class="ph ph-caret-left text-xl"></i>
               </button>
               <button type="button" class="group absolute top-1/2 right-3 z-30 -translate-y-1/2 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-primary shadow-sm duration-200 hover:bg-white pointer-events-auto cursor-pointer" data-carousel-next aria-label="<?php echo esc_attr(reonet_tr('Next slide')); ?>">
                  <i class="ph ph-caret-right text-xl"></i>
               </button>

               <div class="absolute top-8 left-8 z-30 flex gap-2">
                  <?php foreach ($slides as $index => $unused) : ?>
                     <button type="button" class="h-2.5 w-2.5 rounded-full bg-white/70 transition-colors duration-200 cursor-pointer" aria-label="<?php echo esc_attr(sprintf(reonet_tr('Go to slide %d'), $index + 1)); ?>" data-carousel-slide-to="<?php echo esc_attr((string) $index); ?>"></button>
                  <?php endforeach; ?>
               </div>
            <?php endif; ?>
         </div>
      <?php elseif (current_user_can('manage_options')) : ?>
         <div class="rounded-xl bg-yellow-50 border border-yellow-300 px-4 py-3 text-sm text-yellow-800">
            No slides found in the <strong>home_slider</strong> repeater field.
         </div>
      <?php endif; ?>
   </div>
</section>
