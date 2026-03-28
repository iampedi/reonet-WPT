<section class="_slider mb-6">
   <div class="container">
      <div class="owl-carousel owl-theme">
         <?php if (function_exists('have_rows') && have_rows('home_slider')) : ?>
            <?php while (have_rows('home_slider')) : the_row(); ?>

               <?php
               $slide_title       = get_sub_field('slide_title');
               $slide_text        = get_sub_field('slide_text');
               $slide_button_link = get_sub_field('slide_button_link');
               $slide_button_text = get_sub_field('slide_button_text');
               $slide_image       = get_sub_field('slide_image');
               ?>

               <div class="_slider-item flex flex-col-reverse sm:flex-row sm:bg-gray-100/60 rounded-[30px]">
                  <div class="flex flex-col justify-center items-start relative sm:w-1/2 sm:px-14">
                     <img
                        class="absolute right-[15px] sm:right-[80px] bottom-[85px] sm:bottom-[130px] !w-16 sm:!w-20 -z-10"
                        src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/sign-2-v-gray.svg'); ?>"
                        alt="Logo Pattern" />

                     <?php if (!empty($slide_title)) : ?>
                        <h2 class="text-4xl sm:text-5xl font-bold text-gray-600 leading-tight line-clamp-2 mb-2">
                           <?php echo esc_html($slide_title); ?>
                        </h2>
                     <?php endif; ?>

                     <?php if (!empty($slide_text)) : ?>
                        <p class="text-[22px] leading-tight line-clamp-3 text-gray-600">
                           <?php echo wp_kses_post($slide_text); ?>
                        </p>
                     <?php endif; ?>

                     <?php if (!empty($slide_button_link) && !empty($slide_button_text)) : ?>
                        <?php
                        $button_url    = is_array($slide_button_link) ? ($slide_button_link['url'] ?? '') : $slide_button_link;
                        $button_target = is_array($slide_button_link) ? ($slide_button_link['target'] ?? '_self') : '_self';
                        ?>
                        <?php if (!empty($button_url)) : ?>
                           <a
                              href="<?php echo esc_url($button_url); ?>"
                              target="<?php echo esc_attr($button_target); ?>"
                              class="btn btn-secondary w-full sm:w-auto mt-6">
                              <?php echo esc_html($slide_button_text); ?>
                           </a>
                        <?php endif; ?>
                     <?php endif; ?>
                  </div>

                  <div class="_image sm:w-1/2">
                     <?php if (!empty($slide_image)) : ?>
                        <img
                           src="<?php echo esc_url($slide_image); ?>"
                           alt="<?php echo esc_attr($slide_title ?: 'Slide Image'); ?>"
                           class="rounded-[30px] w-full" />
                     <?php endif; ?>
                  </div>
               </div>

            <?php endwhile; ?>
         <?php else : ?>
            <?php if (current_user_can('manage_options')) : ?>
               <div class="rounded-xl bg-yellow-50 border border-yellow-300 px-4 py-3 text-sm text-yellow-800">
                  No slides found in the <strong>home_slider</strong> repeater field.
               </div>
            <?php endif; ?>
         <?php endif; ?>
      </div>
   </div>
</section>