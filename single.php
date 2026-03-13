<?php get_header(); ?>
<div class="_component single-blog">
  <div class="max-w-4xl mx-auto px-4">
    <div class="blog-header flex flex-col-reverse sm:flex-row items-center gap-4 sm:gap-8">
      <?php if (has_post_thumbnail(get_the_id())) echo get_the_post_thumbnail(get_the_id(), 'full', array('class' => 'rounded-2xl aspect-square sm:w-64 object-cover object-center')); ?>

      <div class="flex h-full">
        <h1 class="text-3xl sm:text-4xl font-bold uppercase text-primary sm:w-3/4"><?php the_title(); ?></h1>

        <div class="hidden sm:flex justify-end flex-1"><img src="<?php echo get_template_directory_uri() ?>/assets/images/sign-2-v-gray.svg" alt="ReoNet Symbol Pattern" /></div>
      </div>
    </div>

    <div class="blog-body my-8 sm:mt-12 sm:mb-20 sm:bg-gray-100/60 p-0 sm:p-10">
      <?php the_content(); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>