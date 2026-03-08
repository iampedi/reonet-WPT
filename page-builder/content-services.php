<section class="home-services container px-3 sm:px-0">
    <div class="services-card flex flex-wrap sm:pl-[50px] sm:-mt-[50px] mb-14">
        <?php $i = 1; ?>
        <?php $the_query = new WP_Query(array('post_type' => 'service', 'posts_per_page' => 3, 'orderby' => 'date', 'order' => 'ASC')); ?>
        <?php if ($the_query->have_posts()): ?>
            <?php while ($the_query->have_posts()):
                $the_query->the_post(); ?>
                <div class="group <?php if ($i > 1) {
                    if ($i == 2) { ?>sm:mx-5 my-5 sm:my-0<?php } ?> flex flex-wrap content-end<?php } ?>">
                    <?php if ($i == 1) { ?>
                        <div class="absolute -top-[35px] -right-[35px] hidden sm:block">
                            <?php echo wp_get_attachment_image(get_sub_field('img'), 'full', false, array('class' => '')); ?>
                        </div>
                    <?php } ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php echo wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'full', false, array('class' => 'w-100 img-fluid')); ?>
                        <div class="card-body">
                            <div class="text">
                                <span><?php _tr('Service', 'PALVELUT'); ?></span>
                                <h3><?php the_title() ?></h3>
                            </div>
                            <div class="btn-serv">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/icon/arrow-right-white.svg"
                                    alt="Right Arrow Icon" />
                            </div>
                        </div>
                    </a>
                </div>
                <?php $i++; ?>
            <?php endwhile;
        endif;
        wp_reset_query();
        ?>
    </div>
</section>