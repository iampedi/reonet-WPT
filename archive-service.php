<?php get_header(); ?>

<?php
$lang = apply_filters('wpml_current_language', null);
$archive_title = ($lang === 'fi') ? 'Palvelut' : 'Services';
$archive_description = get_field('service_archive_description', 'option');
?>

<main class="component services" id="main-content">
	<div class="container">
		<header class="page-header bg-symbol">
			<?php
			$lang = apply_filters('wpml_current_language', null);
			$archive_title = ($lang === 'fi') ? 'Palvelut' : 'Services';
			?>
			<h1 class="uppercase"><?php echo esc_html($archive_title); ?></h1>

			<!-- <?php if (!empty($archive_description)) : ?>
				<div class="archive-description">
					<?php echo wp_kses_post($archive_description); ?>
				</div>
			<?php endif; ?> -->
		</header>

		<section class="services-card my-24" aria-label="<?php echo esc_attr($archive_title ?: __('Services', 'textdomain')); ?>">
			<?php if (have_posts()) : ?>
				<div class="flex justify-center flex-wrap gap-8">
					<?php while (have_posts()) : the_post(); ?>
						<article <?php post_class('group'); ?>>
							<a href="<?php the_permalink(); ?>" class="block" aria-label="<?php echo esc_attr(get_the_title()); ?>">
								<?php if (has_post_thumbnail()) : ?>
									<?php the_post_thumbnail('service', [
										'class'   => 'w-full h-auto',
										'loading' => 'lazy',
										'alt'     => the_title_attribute(['echo' => false]),
									]); ?>
								<?php endif; ?>

								<div class="card-body">
									<div class="text">
										<span><?php echo esc_html($archive_title); ?></span>
										<h2><?php the_title(); ?></h2>
									</div>

									<div class="btn-serv" aria-hidden="true">
										<img
											src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon/arrow-right-white.svg'); ?>"
											alt=""
											loading="lazy" />
									</div>
								</div>
							</a>
						</article>
					<?php endwhile; ?>
				</div>

				<?php if (get_the_posts_pagination()) : ?>
					<nav class="pagination mt-12" aria-label="<?php esc_attr_e('Services pagination', 'textdomain'); ?>">
						<?php
						the_posts_pagination([
							'mid_size'  => 1,
							'prev_text' => __('Previous', 'textdomain'),
							'next_text' => __('Next', 'textdomain'),
						]);
						?>
					</nav>
				<?php endif; ?>

			<?php else : ?>
				<div class="py-12 text-center">
					<p><?php esc_html_e('No services found.', 'textdomain'); ?></p>
				</div>
			<?php endif; ?>
		</section>
	</div>
</main>

<?php get_footer(); ?>