<section class="_delivery py-5 sm:py-10">
   <div class="max-w-3xl mx-auto px-4">
      <div class="border-2 p-6 sm:px-8 sm:py-5 rounded-3xl border-primary/80 bg-blue-50 flex flex-col sm:flex-row-reverse gap-4 sm:gap-8 items-stretch">
         <div class="shrink-0 flex justify-center sm:items-end">
            <?php
            $icon = get_sub_field('icon');
            if (!empty($icon)) :
            ?>
               <img
                  src="<?php echo esc_url($icon); ?>"
                  alt="Truck"
                  class="w-28 sm:w-24 object-contain"
                  loading="lazy" />
            <?php endif; ?>
         </div>

         <div class="space-y-1 min-w-0 flex-1">
            <?php
            $title = get_sub_field('title');
            if (!empty($title)) :
            ?>
               <h3 class="text-xl text-center sm:text-left font-semibold text-primary uppercase"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>

            <?php
            $text = get_sub_field('text');
            if (!empty($text)) :
            ?>
               <div class="text-lg text-center sm:text-left text-primary leading-tight sm:leading-snug"><?php echo wp_kses_post($text); ?></div>
            <?php endif; ?>
         </div>
      </div>
   </div>
</section>