<section class="_home-mod-blog py-10 sm:py-16">
   <div class="container">
      <?php
      $shortcode = trim((string) get_sub_field('shortcode'));

      if (!empty($shortcode)) {
         echo do_shortcode($shortcode);
      }
      ?>
   </div>
</section>