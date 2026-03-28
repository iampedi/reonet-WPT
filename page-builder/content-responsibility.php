<section class="_home-mod-cta bg-primary">
   <div class="bg-no-repeat bg-center py-10 sm:py-20" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/home-bubbles-bg-01.png');">
      <div class="container">
         <div
            class="flex flex-col justify-center items-center sm:max-w-2xl mx-auto gap-2">
            <h2 class="text-white text-[40px] font-medium flex flex-col-reverse sm:flex-row items-center gap-1.5 sm:gap-3">
               <?php the_sub_field('res_title'); ?>
               <img class="w-20 sm:w-12" src="<?php echo get_template_directory_uri() ?>/assets/images/icon/green-heart-icon.svg"
                  alt="White Heart in middle of a green circle" />
            </h2>
            <div class="text-gray-100 text-lg sm:text-xl leading-tight text-center">
               <?php the_sub_field('res_content'); ?>
            </div>
         </div>
      </div>
   </div>
</section>