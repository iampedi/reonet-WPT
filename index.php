<!-- theme/reonet/index.php -->
<?php
get_header();
if (have_rows('pagebuilder')) :
    while (have_rows('pagebuilder')) : the_row();
        get_template_part('page-builder/content', get_row_layout());
    endwhile;
else:
    get_template_part('page-builder/content-page');
endif;
?>

<?php get_footer(); ?>