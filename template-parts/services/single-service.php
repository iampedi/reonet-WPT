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

<main class="_component service-single">
  <div class="container">
    <?php if (!$acf_available) : ?>
      <div class="mb-4 rounded-2xl border border-yellow-300 bg-yellow-50 px-5 py-4 text-sm text-yellow-800">
        <strong>Advanced Custom Fields (ACF) is not installed or activated.</strong><br>
        Please install and activate the ACF plugin to use the custom header image and subtitle fields on this page.
      </div>
    <?php endif; ?>

    <div class="page-header h-80 relative rounded-[30px] bg-cover bg-center bg-no-repeat"
      <?php if (!empty($header_image_url)) : ?>
      style="background-image: url('<?php echo esc_url($header_image_url); ?>');"
      <?php endif; ?>>

      <div class="bg-black/40 text-white absolute inset-0 rounded-[30px] flex items-center justify-center px-4">
        <h1 class="text-4xl uppercase font-semibold text-center text-shadow-lg">
          <?php the_title(); ?>
        </h1>
      </div>
    </div>

    <div class="page-title relative pt-16">
      <div class="symbol"></div>
      <!-- <div class="line"></div> -->
    </div>

    <div class="service-body mt-8 mb-16 sm:mt-12 sm:bg-gray-100/60 p-0 sm:p-10 max-w-3xl mx-auto">
      <?php the_content(); ?>
    </div>

    <?php if (function_exists('have_rows') && have_rows('gallery')) : ?>
      <div class="_gallery my-12 sm:my-16 space-y-12">
        <?php while (have_rows('gallery')) : the_row(); ?>
          <?php
          $gallery_title = get_sub_field('gallery_title');
          $gallery_shortcode = get_sub_field('gallery_shortcode');
          ?>

          <section class="gallery-item space-y-4 sm:space-y-6">
            <?php if (!empty($gallery_title)) : ?>
              <h2 class="text-2xl sm:text-2xl font-semibold text-center uppercase text-primary">
                <?php echo esc_html($gallery_title); ?>
              </h2>
            <?php endif; ?>

            <?php if (!empty($gallery_shortcode)) : ?>
              <div class="gallery-shortcode">
                <?php echo do_shortcode($gallery_shortcode); ?>
              </div>
            <?php endif; ?>
          </section>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

  </div>
  <?php if (function_exists('have_rows') && have_rows('page_builder')) : ?>
    <?php while (have_rows('page_builder')) : the_row(); ?>
      <?php get_template_part('page-builder/content', get_row_layout()); ?>
    <?php endwhile; ?>
  <?php endif; ?>
</main>

<?php get_footer(); ?>