<?php
/* Template Name: blog */
get_header();
?>
<div class="component blog">
    <div class="container">
        <div class="page-header bg-symbol">
            <h1>Blog</h1>
        </div>
        <div class="blog-posts grid sm:grid-cols-4 gap-4 px-4 sm:px-0 sm:gap-5 my-24">
            <?php $the_query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 12, 'orderby' => 'date', 'order' => 'dcs')); ?>

            <?php if ($the_query->have_posts()) : ?>
                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                    <div class="item group">
                        <a href="<?php the_permalink(); ?>">
                            <figure>
                                <?php if (has_post_thumbnail(get_the_id())) echo get_the_post_thumbnail(get_the_id(), 'blog', array('class' => 'blog-item-image img-fluid w-100  rounded-3 ')); ?>

                            </figure>
                            <div class="text">
                                <h3><?php the_title(); ?></h3>
                            </div>
                            <div class="btn-arrow">
                                <img class="fill-blue-950 group-hover:hidden"
                                    src="<?php echo get_template_directory_uri() ?>/assets/images/icon/arrow-right-blue.svg" alt="Right Arrow Icon" />
                                <img class="fill-blue-950 hidden group-hover:block"
                                    src="<?php echo get_template_directory_uri() ?>/assets/images/icon/arrow-right-white.svg" alt="Right Arrow Icon" />
                            </div>
                        </a>
                    </div>
            <?php endwhile;
            endif;

            wp_reset_query();
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>