<?php get_header(); ?>
	<div class="component services">
		<div class="container">
			<div class="page-header bg-symbol">
				<h1><?php _tr('Services','PALVELUT') ?></h1>
			</div>
			<div class="services-card my-24">
				<div class="flex justify-center flex-wrap gap-8">
					<?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="group">
                            <a href="<?php the_permalink();?>">
                                <?php if (has_post_thumbnail(get_the_id())) echo get_the_post_thumbnail(get_the_id(), 'service', array('class' => '')); ?>
                                <div class="card-body">
                                    <div class="text">
                                        <span><?php _tr('Services','PALVELUT') ?></span>
                                        <h3><?php the_title();?></h3>
                                    </div>
                                    <div class="btn-serv">
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/icon/arrow-right-white.svg"
                                             alt="Right Arrow Icon"/>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php endwhile;
                endif;
                wp_reset_query(); ?>
				</div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>