<?php get_header(); ?>
<div class="component">
  <div class="container px-3 sm:px-0">
    <style>
      .page-header.simple:before {
        background-image: url(<?php the_field('header_image'); ?>) !important;
      }
    </style>
    <div class="page-header simple">
      <h1><?php the_field('subtitle'); ?></h1>
    </div>
    <div class="page-title">
      <div class="symbol"></div>
      <div class="line"></div>
      <h2><?php the_title(); ?></h2>
    </div>
    <div class="content mx-auto sm:w-8/12">
      <?php the_content(); ?>
    </div>

    <div class="services-card mt-[70px]">
      <?php
      // Store the current page's title
      $current_title = get_the_title();

      $the_query = new WP_Query(array(
        'post_type' => 'service',
        'posts_per_page' => 4,
        'orderby' => 'date',
        'order' => 'DESC'
      ));
      ?>
      <?php if ($the_query->have_posts()) : ?>
        <?php while ($the_query->have_posts()) :
          $the_query->the_post();

          // Skip the current service if the titles match
          if ($current_title === get_the_title()) {
            continue;
          }
        ?>
          <div class="group my-5 sm:my-0 sm:mx-6">
            <a href="<?php the_permalink(); ?>">
              <?php if (has_post_thumbnail(get_the_ID())) echo get_the_post_thumbnail(get_the_ID(), 'service', array('class' => '')); ?>
              <div class="card-body">
                <div class="text">
                  <span>service</span>
                  <h3><?php the_title(); ?>(SF)</h3>
                </div>
                <div class="btn-serv">
                  <img src="<?php echo get_template_directory_uri() ?>/assets/images/icon/arrow-right-white.svg"
                    alt="Right Arrow Icon" />
                </div>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php else : ?>
        <p><?php _e('not found'); ?></p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>