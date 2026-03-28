<?php
$current_lang = apply_filters('wpml_current_language', null);

$blog_page_id = (int) get_option('page_for_posts');

if ($blog_page_id) {
   $blog_page_id = apply_filters('wpml_object_id', $blog_page_id, 'page', true, $current_lang);
   $blog_url = get_permalink($blog_page_id);
} else {
   $blog_url = home_url('/');
}
?>

<section class="_home-mod-blog py-8">
   <div class="container">
      <div class="mb-4 sm:mb-5 flex items-center justify-between">
         <h2 class="text-[26px] font-medium text-primary">
            <?php echo esc_html(get_sub_field('blog_title')); ?>
         </h2>

         <a class="text-muted-foreground hover:text-primary flex items-center gap-1" href="<?php echo esc_url($blog_url); ?>">
            <?php echo esc_html(reonet_tr('Show all')); ?>
            <i class="ph-duotone ph-caret-circle-right text-xl"></i>
         </a>
      </div>

      <div class="_blog-posts grid sm:grid-cols-4 gap-4 sm:gap-5">
         <?php
         $the_query = new WP_Query([
            'post_type'           => 'post',
            'posts_per_page'      => 4,
            'orderby'             => 'date',
            'order'               => 'DESC',
            'ignore_sticky_posts' => true,
         ]);
         ?>

         <?php if ($the_query->have_posts()) : ?>
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
               <div class="_item group rounded-2xl bg-blue-50 flex flex-col">
                  <a href="<?php the_permalink(); ?>">
                     <div class="overflow-hidden rounded-2xl rounded-bl-none">
                        <?php
                        if (has_post_thumbnail()) {
                           echo get_the_post_thumbnail(
                              get_the_ID(),
                              'blog',
                              ['class' => 'group-hover:scale-110 duration-300']
                           );
                        }
                        ?>
                     </div>
                  </a>

                  <div class="_text pt-4 pl-5 pr-3 pb-6 flex items-start gap-5 sm:gap-2.5 flex-1">
                     <h3 class="text-xl sm:text-lg font-medium leading-tight line-clamp-3 text-primary sm:text-inherit sm:group-hover:text-primary">
                        <a href="<?php the_permalink(); ?>">
                           <?php the_title(); ?>
                        </a>
                     </h3>

                     <div class="flex items-end h-full">
                        <a class="py-3 pr-1.25 flex rounded-md -mb-3 bg-primary sm:bg-transparent sm:group-hover:bg-primary duration-300" href="<?php the_permalink(); ?>">
                           <i class="ph ph-arrow-right text-xl text-white sm:text-primary sm:group-hover:text-white duration-300"></i>
                        </a>
                     </div>
                  </div>
               </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
         <?php else : ?>
            <p><?php reonet_tr('Artikkeleita ei löytynyt', 'No posts found'); ?></p>
         <?php endif; ?>
      </div>
   </div>
</section>