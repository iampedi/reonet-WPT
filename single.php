<?php
get_header();

$acf_available = function_exists('get_field');
$header_image = null;
$subtitle = '';
$header_image_url = '';

if ($acf_available) {
   $header_image = get_field('header_image');
   $subtitle     = get_field('subtitle');

   if (!empty($header_image)) {
      if (is_array($header_image) && !empty($header_image['url'])) {
         $header_image_url = $header_image['url'];
      } elseif (is_numeric($header_image)) {
         $header_image_url = wp_get_attachment_image_url($header_image, 'full');
      } elseif (is_string($header_image)) {
         $header_image_url = $header_image;
      }
   }
}
?>

<div class="_component single-service">
   <div class="container">
      <?php if (!$acf_available) : ?>
         <div class="mb-4 rounded-2xl border border-yellow-300 bg-yellow-50 px-5 py-4 text-sm text-yellow-800">
            <strong>Advanced Custom Fields (ACF) is not installed or activated.</strong><br>
            Please install and activate the ACF plugin to use the custom header image and subtitle fields on this page.
         </div>
      <?php endif; ?>

      <div
         class="page-header h-80 relative rounded-[30px] bg-cover bg-center bg-no-repeat"
         <?php if (!empty($header_image_url)) : ?>
         style="background-image: url('<?php echo esc_url($header_image_url); ?>');"
         <?php endif; ?>>
         <div class="bg-black/40 absolute inset-0 rounded-[30px] flex items-center justify-center px-4">
            <?php if (!empty($subtitle)) : ?>
               <h2 class="text-white text-[40px] font-semibold text-shadow-lg leading-none">
                  <?php echo wp_kses_post($subtitle); ?>
               </h2>
            <?php endif; ?>
         </div>
      </div>

      <div class="page-title relative pt-28">
         <div class="symbol"></div>
         <div class="line"></div>
         <h1 class="text-4xl uppercase font-semibold text-center mb-10 sm:mb-14">
            <?php the_title(); ?>
         </h1>
      </div>

      <div class="blog-body my-8 sm:mt-12 sm:mb-20 sm:bg-gray-100/60 p-0 sm:p-10">
         <?php the_content(); ?>
      </div>
   </div>
</div>

<?php get_footer(); ?>