<?php

/**
 * Product archive (Shop) page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<main class="_shop-page pb-8 sm:pb-12">
	<div class="container">
		<div
			class="_page-header flex flex-col items-center justify-center bg-no-repeat bg-center bg-contain h-40"
			style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/bg-symbol-gray.png');">

			<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
				<h1 class="uppercase text-4xl pt-3 font-semibold text-gray-600"><?php woocommerce_page_title(); ?></h1>
			<?php endif; ?>
		</div>

		<!-- <div class="flex">
			<div class="text-sm text-gray-600 [&_p]:m-0">
				<?php do_action('woocommerce_archive_description'); ?>
			</div>
		</div> -->

		<?php if (woocommerce_product_loop()) : ?>
			<div class="__shop-toolbar pt-14 mb-4">
				<?php
				/**
				 * Theme-level extension point before toolbar content.
				 */
				do_action('reonet_before_shop_toolbar');
				?>

				<div class="_shop-notices">
					<?php woocommerce_output_all_notices(); ?>
				</div>

				<?php
				/**
				 * Theme-level extension point after toolbar content.
				 */
				do_action('reonet_after_shop_toolbar');
				?>
			</div>

			<?php woocommerce_product_loop_start(); ?>

			<?php if (wc_get_loop_prop('total')) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php
					/**
					 * Hook: woocommerce_shop_loop.
					 */
					do_action('woocommerce_shop_loop');
					?>
					<?php wc_get_template_part('content', 'product'); ?>
				<?php endwhile; ?>
			<?php endif; ?>

			<?php woocommerce_product_loop_end(); ?>

			<div class="_shop-pagination">
				<?php
				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action('woocommerce_after_shop_loop');
				?>
			</div>
		<?php else : ?>
			<div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">
				<?php
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action('woocommerce_no_products_found');
				?>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php get_footer('shop'); ?>