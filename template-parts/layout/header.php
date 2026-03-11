<?php
if (!defined('ABSPATH')) exit;
?>

<header class="py-4 sm:py-5">
  <div class="container">
    <div class="flex justify-between items-center">

      <div class="logo h-auto flex">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <img
            src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.svg'); ?>"
            class="logo-img"
            alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
        </a>
      </div>

      <button class="menu-bars sm:hidden" type="button" onclick="mobileMenu()" aria-label="Open menu">
        <img class="w-6" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon/bars.svg'); ?>" alt="" />
      </button>

      <nav class="navbar hidden sm:block" aria-label="Main menu">
        <?php
        wp_nav_menu([
          'theme_location' => 'main-menu', // اگر register_nav_menus داری
          // اگر از اسم منو استفاده می‌کنی، همون 'menu' رو نگه دار
          'menu' => 'main-menu',
          'container' => false,
          'items_wrap' => '<ul class="fi-menu">%3$s</ul>',
          'add_li_class' => 'item',
          'fallback_cb' => '__return_false',
        ]);
        ?>
      </nav>
    </div>

    <div class="mobile-menu bg-gray-100 mb-5 hidden" id="myLinks">
      <?php
      wp_nav_menu([
        'theme_location' => 'main-menu',
        'menu' => 'main-menu',
        'container' => false,
        'items_wrap' => '<ul class="fi-menu">%3$s</ul>',
        'add_li_class' => 'item',
        'fallback_cb' => '__return_false',
      ]);
      ?>
    </div>
  </div>
</header>