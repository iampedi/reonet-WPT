<?php
$service_title = get_sub_field('service_title');
$service_icon = get_sub_field('service_icon');
$service_posts = get_sub_field('service_name');

if (empty($service_posts)) {
   return;
}

if (!is_array($service_posts)) {
   $service_posts = array($service_posts);
}

$service_posts = array_values(array_filter($service_posts, function ($service_post) {
   return $service_post instanceof WP_Post;
}));

if (empty($service_posts)) {
   return;
}
?>

<section class="pb-services">
   <div class="container">
      <?php if (!empty($service_title)) : ?>
         <h2 class="text-2xl sm:text-2xl font-semibold text-center uppercase text-primary mb-6">
            <?php echo esc_html($service_title); ?>
         </h2>
      <?php endif; ?>

      <div class="_services-card flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-4">
         <?php foreach ($service_posts as $index => $service) : ?>
            <?php
            $service_id = $service->ID;
            $service_link = get_permalink($service_id);
            $service_name = get_the_title($service_id);
            ?>
            <div class="group relative">
               <?php if ($index === 0 && !empty($service_icon)) : ?>
                  <div class="absolute -top-7.5 -left-7.5 hidden sm:block w-20 z-10">
                     <img
                        src="<?php echo esc_url($service_icon); ?>"
                        alt=""
                        class="w-full h-auto opacity-90" />
                  </div>
               <?php endif; ?>

               <a href="<?php echo esc_url($service_link); ?>">
                  <div class="aspect-6/4 sm:w-90 rounded-3xl overflow-hidden">
                     <?php
                     echo get_the_post_thumbnail(
                        $service_id,
                        'full',
                        array('class' => 'object-cover group-hover:scale-105 duration-300')
                     );
                     ?>
                  </div>

                  <div class="_card-body absolute top-0 left-0 flex items-end justify-center w-full h-full rounded-3xl bg-black/20">
                     <div class="flex justify-between w-full p-6">
                        <div class="_text uppercase text-white text-shadow-lg sm:text-shadow-none sm:group-hover:text-shadow-lg duration-300">
                           <span class="text-xl flex leading-tight"><?php echo esc_html(reonet_tr('Services')); ?></span>
                           <h3 class="leading-none font-semibold text-2xl">
                              <?php echo esc_html($service_name); ?>
                           </h3>
                        </div>

                        <div class="btn-serv bg-primary/90 sm:bg-transparent sm:group-hover:bg-primary/90 flex py-3 pr-1 rounded-md duration-300">
                           <i class="ph ph-arrow-right text-2xl text-white sm:text-shadow-lg sm:group-hover:text-shadow-none -ml-0.5"></i>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
         <?php endforeach; ?>
      </div>
   </div>
</section>