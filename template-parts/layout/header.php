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

         <div class="flex items-center gap-3 sm:gap-4">
            <nav class="navbar hidden sm:block" aria-label="Main menu">
               <?php if (has_nav_menu('main-menu')) : ?>
                  <?php
                  wp_nav_menu([
                     'theme_location' => 'main-menu',
                     'menu' => 'main-menu',
                     'container' => false,
                     'items_wrap' => '<ul class="main-menu">%3$s</ul>',
                     'add_li_class' => 'item',
                     'fallback_cb' => false,
                  ]);
                  ?>
               <?php else : ?>
                  <div class="rounded-xl bg-gray-100 px-4 py-2 text-sm text-gray-600">
                     No menu has been assigned yet. Please go to
                     <strong>Appearance → Menus</strong>
                     and assign a menu to
                     <strong>Main Menu</strong>.
                  </div>
               <?php endif; ?>
            </nav>

            <?php
            $languages = apply_filters('wpml_active_languages', null, [
               'skip_missing' => 0,
               'orderby'      => 'code',
            ]);

            if (!empty($languages)) : ?>
               <ul class="language-switcher flex items-center gap-2">
                  <?php foreach ($languages as $lang) : ?>
                     <?php if (!$lang['active']) : ?>
                        <li>
                           <a href="<?php echo esc_url($lang['url']); ?>" class="flex items-center">
                              <?php if (!empty($lang['country_flag_url'])) : ?>
                                 <img
                                    src="<?php echo esc_url($lang['country_flag_url']); ?>"
                                    alt="<?php echo esc_attr($lang['native_name']); ?>"
                                    class="size-7 sm:size-6 object-contain">
                              <?php endif; ?>
                           </a>
                        </li>
                     <?php endif; ?>
                  <?php endforeach; ?>
               </ul>
            <?php endif; ?>

            <button class="menu-bars sm:hidden flex" type="button" onclick="mobileMenu()" aria-label="Open menu">
               <i class="ph-bold ph-list text-4xl text-primary"></i>
            </button>
         </div>
      </div>

      <div class="mobile-menu bg-gray-100 mt-4 p-4 rounded-3xl hidden" id="myLinks">
         <?php if (has_nav_menu('main-menu')) : ?>
            <?php
            wp_nav_menu([
               'theme_location' => 'main-menu',
               'menu' => 'main-menu',
               'container' => false,
               'items_wrap' => '<ul class="fi-menu-mobile">%3$s</ul>',
               'add_li_class' => 'item',
               'fallback_cb' => false,
            ]);
            ?>
         <?php else : ?>
            <div class="text-sm text-gray-600">
               No menu has been assigned yet. Please create one in
               <strong>Appearance → Menus</strong>.
            </div>
         <?php endif; ?>
      </div>
   </div>
</header>