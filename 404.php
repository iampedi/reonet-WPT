<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package reonet
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="component _404-page" id="main-content">
  <div
    class="_page-header flex flex-col items-center justify-center bg-no-repeat bg-center bg-contain h-40"
    style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/bg-symbol-gray.png'); ?>');">
    <h1 class="uppercase text-4xl pt-3 font-semibold text-gray-600">404</h1>
  </div>

  <div class="py-16 sm:py-24">
    <div class="container">
      <section class="mx-auto max-w-2xl rounded-3xl border border-gray-200 bg-white p-6 sm:p-10 text-center space-y-5">
        <h2 class="text-2xl sm:text-3xl font-semibold text-primary">
          <?php echo esc_html(reonet_tr('Page not found')); ?>
        </h2>

        <p class="text-gray-600">
          <?php echo esc_html(reonet_tr('The page you are looking for does not exist or may have been moved.')); ?>
        </p>

        <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
          <a class="btn btn-primary btn-sm" href="<?php echo esc_url(home_url('/')); ?>">
            <?php echo esc_html(reonet_tr('Back to home')); ?>
          </a>
          <?php if (post_type_exists('service')) : ?>
            <a class="btn btn-ghost btn-sm" href="<?php echo esc_url(get_post_type_archive_link('service')); ?>">
              <?php echo esc_html(reonet_tr('View services')); ?>
            </a>
          <?php endif; ?>
        </div>
      </section>
    </div>
  </div>
</main>

<?php get_footer(); ?>
