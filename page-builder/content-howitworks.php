<section class="_how-it-works py-5 sm:py-10">
   <div class="container">
      <?php
      $title = get_sub_field('title');
      if (!empty($title)) :
      ?>
         <h3 class="text-xl text-green uppercase font-semibold text-center mb-8"><?php echo esc_html($title); ?></h3>
      <?php endif; ?>

      <?php if (have_rows('items')) : ?>
         <div class="flex flex-col sm:flex-row items-center justify-around gap-12 sm:gap-0">
            <?php
            $step = 1;
            while (have_rows('items')) : the_row();

               $icon = get_sub_field('item_icon');
               $text = get_sub_field('item_text');
            ?>

               <div class="flex items-center sm:justify-center w-66">
                  <span class="flex items-center text-8xl pl-2 bg-gray-50 text-gray-400/70 font-light size-36 rounded-full">
                     <?php echo esc_html($step); ?>
                  </span>

                  <div class="flex flex-col gap-2 -ml-16">
                     <?php if (!empty($icon)) : ?>
                        <div class="_icon">
                           <?php
                           if (is_array($icon) && !empty($icon['url'])) {
                              $icon_url = $icon['url'];
                              $icon_alt = !empty($icon['alt']) ? $icon['alt'] : '';
                              echo '<img class="w-10" src="' . esc_url($icon_url) . '" alt="' . esc_attr($icon_alt) . '" loading="lazy" />';
                           } elseif (is_string($icon)) {
                              echo '<img class="w-24" src="' . esc_url($icon) . '" alt="" loading="lazy" />';
                           } elseif (is_numeric($icon)) {
                              echo wp_get_attachment_image((int) $icon, 'thumbnail', false, ['loading' => 'lazy']);
                           }
                           ?>
                        </div>
                     <?php endif; ?>

                     <?php if (!empty($text)) : ?>
                        <div class="text-center text-primary font-semibold text-xl"><?php echo esc_html($text); ?></div>
                     <?php endif; ?>
                  </div>
               </div>

            <?php
               $step++;
            endwhile;
            ?>
         </div>
      <?php endif; ?>
   </div>
</section>