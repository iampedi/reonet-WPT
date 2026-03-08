<!-- blog section -->
<section class="home-mod-blog">
    <div class="container px-3 sm:px-0">
        <h2 class="text-[26px] font-medium mb-2 sm:mb-6"><?php the_sub_field('title'); ?></h2>
        <div class="blog-posts grid sm:grid-cols-4 gap-4 sm:gap-5">
            <?php $the_query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 4, 'orderby' => 'date', 'order' => 'dcs')); ?>

            <?php if ($the_query->have_posts()): ?>
                <?php while ($the_query->have_posts()):
                    $the_query->the_post(); ?>
                    <!-- Post 1 -->
                    <div class="item group">
                        <a href="<?php the_permalink(); ?>">
                            <figure>
                                <?php if (has_post_thumbnail(get_the_id()))
                                    echo get_the_post_thumbnail(get_the_id(), 'blog', array('class' => 'blog-item-image img-fluid w-100  rounded-3 ')); ?>

                            </figure>
                            <div class="text">
                                <h3><?php the_title(); ?></h3>
                            </div>
                            <div class="btn-arrow">
                                <img class="fill-blue-950 group-hover:hidden"
                                    src="<?php echo get_template_directory_uri() ?>/assets/images/icon/arrow-right-blue.svg"
                                    alt="Right Arrow Icon" />
                                <img class="fill-blue-950 hidden group-hover:block"
                                    src="<?php echo get_template_directory_uri() ?>/assets/images/icon/arrow-right-white.svg"
                                    alt="Right Arrow Icon" />
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <p><?php _e('not found'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>