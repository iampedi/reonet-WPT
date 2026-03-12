<?php get_header(); ?>

<div class="component blog">
  <div class="container">
    <div class="page-header bg-symbol">
      <h1 class="uppercase"><?php single_post_title(); ?></h1>
    </div>

    <div class="_blog-posts grid sm:grid-cols-4 gap-4 sm:gap-5 py-24">
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <div class="_item group rounded-2xl bg-blue-50 flex flex-col">
            <a href="<?php the_permalink(); ?>">
              <figure class="overflow-hidden rounded-2xl rounded-bl-none">
                <?php
                if (has_post_thumbnail(get_the_ID())) {
                  echo get_the_post_thumbnail(
                    get_the_ID(),
                    'blog',
                    array('class' => 'group-hover:scale-110 duration-300')
                  );
                }
                ?>
              </figure>
            </a>

            <div class="_text pt-4 pl-5 pr-3 pb-6 flex items-start gap-5 sm:gap-2.5 flex-1">
              <h3 class="text-xl sm:text-lg font-medium leading-tight line-clamp-3 text-primary sm:text-inherit sm:group-hover:text-primary">
                <a href="<?php the_permalink(); ?>">
                  <?php the_title(); ?>
                </a>
              </h3>

              <div class="flex items-end h-full">
                <a class="py-3 pr-1.25 flex rounded-md -mb-3 bg-primary sm:bg-transparent sm:group-hover:bg-primary duration-300" href="<?php the_permalink(); ?>">
                  <i class="ph ph-arrow-right text-xl text-white sm:text-primary sm:group-hover:text-white duration-300"></i>
                </a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>

    <div class="pagination">
      <?php the_posts_pagination(); ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>