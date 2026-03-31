<?php
if (function_exists('is_shop') && function_exists('wc_get_template')) {
  if (is_shop() || is_product_taxonomy()) {
    wc_get_template('archive-product.php');
    return;
  }
}

get_header();
?>

<main class="product-page">
  <div class="container">
    <?php woocommerce_content(); ?>
  </div>
</main>

<?php
get_footer();
