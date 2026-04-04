<?php
$title = get_sub_field('title');
$product_category = get_sub_field('product_category');
$items_per_page = (int) (get_sub_field('items_per_page') ?: 8);
$show_featured = (bool) get_sub_field('show_featured_only');
$product_ids = get_sub_field('product_ids');
$order_by = get_sub_field('order_by') ?: 'menu_order';

$all_products_url = '';
$product_category_ids = array();

if (!empty($product_category)) {
   $raw_categories = is_array($product_category) ? $product_category : array($product_category);

   foreach ($raw_categories as $category_item) {
      if ($category_item instanceof WP_Term) {
         $product_category_ids[] = (int) $category_item->term_id;
         continue;
      }

      $product_category_ids[] = (int) $category_item;
   }

   $product_category_ids = array_values(array_filter(array_unique($product_category_ids)));
}

if (!empty($product_category_ids)) {
   $category_link = get_term_link((int) $product_category_ids[0], 'product_cat');
   if (!is_wp_error($category_link) && is_string($category_link)) {
      $all_products_url = $category_link;
   }
}

if ($all_products_url === '' && function_exists('wc_get_page_permalink')) {
   $shop_url = wc_get_page_permalink('shop');
   if (is_string($shop_url) && $shop_url !== '') {
      $all_products_url = $shop_url;
   }
}

if ($all_products_url === '') {
   $archive_url = get_post_type_archive_link('product');
   if (is_string($archive_url) && $archive_url !== '') {
      $all_products_url = $archive_url;
   } else {
      $all_products_url = home_url('/');
   }
}

$args = array(
   'post_type' => 'product',
   'post_status' => 'publish',
   'posts_per_page' => $items_per_page > 0 ? $items_per_page : 8,
);

if (!empty($product_ids)) {
   if (!is_array($product_ids)) {
      $product_ids = array($product_ids);
   }

   $manual_ids = array();
   foreach ($product_ids as $product_item) {
      if ($product_item instanceof WP_Post) {
         $manual_ids[] = (int) $product_item->ID;
         continue;
      }

      $manual_ids[] = (int) $product_item;
   }

   $manual_ids = array_values(array_filter(array_unique($manual_ids)));

   if (!empty($manual_ids)) {
      $args['post__in'] = $manual_ids;
      $args['orderby'] = 'post__in';
   }
} else {
   $tax_query = array();

   if (!empty($product_category_ids)) {
      $tax_query[] = array(
         'taxonomy' => 'product_cat',
         'field' => 'term_id',
         'terms' => $product_category_ids,
      );
   }

   if ($show_featured) {
      $tax_query[] = array(
         'taxonomy' => 'product_visibility',
         'field' => 'name',
         'terms' => array('featured'),
         'operator' => 'IN',
      );
   }

   if (!empty($tax_query)) {
      $args['tax_query'] = $tax_query;
   }

   $allowed_orderby = array('menu_order', 'date', 'title', 'ID', 'rand');
   $args['orderby'] = in_array($order_by, $allowed_orderby, true) ? $order_by : 'menu_order';
}

$query = new WP_Query($args);
?>

<section class="woocommerce-products-module py-10 sm:py-16">
   <div class="container">
      <div class="flex items-center justify-between mb-4">
         <?php if ($title) : ?>
            <h2 class="text-2xl sm:text-2xl font-semibold text-center uppercase text-primary flex items-center gap-2">
               <i class=" ph-duotone ph-shopping-bag text-3xl"></i>
               <?php echo esc_html($title); ?>
            </h2>
         <?php endif; ?>

         <a class="text-primary text-lg font-medium underline underline-offset-4 hover:text-green duration-300" href="<?php echo esc_url($all_products_url); ?>">
            <?php echo esc_html(reonet_tr('All products')); ?>
         </a>
      </div>

      <?php if ($query->have_posts()) : ?>
         <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
               <?php wc_get_template_part('content', 'product'); ?>
            <?php endwhile; ?>
         </div>
      <?php endif; ?>

      <?php wp_reset_postdata(); ?>
   </div>
</section>