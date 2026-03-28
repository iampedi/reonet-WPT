<?php
get_header();

$lang = function_exists('pll_current_language') ? pll_current_language() : get_locale();
$services_page_title = get_field('page_title', 'option');
$services_description = get_field('page_description', 'option');
?>

<main class="component _services" id="main-content">
	<div
		class="_page-header flex flex-col items-center justify-center bg-no-repeat bg-center bg-contain h-40"
		style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/bg-symbol-gray.png');">

		<h1 class="uppercase text-4xl pt-3 font-semibold text-gray-600"><?php echo esc_html($services_page_title); ?></h1>
	</div>

	<div class="py-24 sm:py-24 space-y-6 sm:space-y-12">
		<div class="container">
			<div class="flex flex-col gap-12">
				<?php if (!empty($services_description)) : ?>
					<div class="_services-description text-lg leading-snug text-gray-700 [&_p]:mb-2 [&_p]:last:mb-0 text-center sm:max-w-4xl mx-auto">
						<?php echo wp_kses_post($services_description); ?>
					</div>
				<?php endif; ?>

				<?php if (have_posts()) : ?>
					<section class="services-card grid sm:grid-cols-2 gap-5" aria-label="<?php echo esc_attr($services_page_title); ?>">
						<?php while (have_posts()) : the_post(); ?>
							<?php $service_description = get_field('description', get_the_ID()); ?>

							<div <?php post_class('group'); ?>>
								<a
									href="<?php the_permalink(); ?>"
									aria-label="<?php echo esc_attr(get_the_title()); ?>"
									class="flex flex-col sm:flex-row bg-blue-50 sm:bg-blue-50/40 sm:group-hover:bg-blue-50 duration-300 rounded-4xl overflow-hidden h-full">
									<div class="sm:w-3/7 rounded-bl-4xl sm:rounded-tr-4xl overflow-hidden">
										<?php if (has_post_thumbnail()) : ?>
											<?php the_post_thumbnail('service', [
												'class'   => 'group-hover:scale-105 duration-300',
												'loading' => 'lazy',
												'alt'     => the_title_attribute(['echo' => false]),
											]); ?>
										<?php endif; ?>
									</div>

									<div class="card-body flex-1 p-5 pt-7">
										<div class="flex flex-col h-full gap-2.5">
											<h2 class="leading-none font-semibold text-xl duration-300 uppercase text-primary group-hover:text-green">
												<?php the_title(); ?>
											</h2>

											<?php if (!empty($service_description)) : ?>
												<div class="flex-1">
													<p class="line-clamp-3 text-[17px] leading-tight text-primary/80"><?php echo wp_kses_post($service_description); ?></p>
												</div>
											<?php endif; ?>

											<div class="flex justify-end">
												<div class="btn btn-primary btn-sm btn-ghost">
													<?php echo function_exists('pll__') ? esc_html(pll__('Read more')) : esc_html__('Read more', 'reonet'); ?>
													<i class="ph ph-arrow-right"></i>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
						<?php endwhile; ?>
					</section>

					<?php global $wp_query; ?>
					<?php if ($wp_query->max_num_pages > 1) : ?>
						<nav class="pagination mt-12" aria-label="<?php echo function_exists('pll__') ? esc_attr(pll__('Services pagination')) : esc_attr__('Services pagination', 'reonet'); ?>">
							<?php
							the_posts_pagination([
								'mid_size'  => 1,
								'prev_text' => function_exists('pll__') ? pll__('Previous') : __('Previous', 'reonet'),
								'next_text' => function_exists('pll__') ? pll__('Next') : __('Next', 'reonet'),
							]);
							?>
						</nav>
					<?php endif; ?>
				<?php else : ?>
					<div class="py-12 text-center">
						<p><?php echo function_exists('pll__') ? esc_html(pll__('No services found.')) : esc_html__('No services found.', 'reonet'); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php if (have_rows('page_builder', 'option')) : ?>
			<?php while (have_rows('page_builder', 'option')) : the_row(); ?>
				<?php get_template_part('page-builder/content', get_row_layout()); ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>