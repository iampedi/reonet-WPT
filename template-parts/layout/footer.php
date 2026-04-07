<?php
if (!defined('ABSPATH')) {
   exit;
}

$get_option_field = function ($field_name, $default = '') {
   return function_exists('get_field') ? get_field($field_name, 'option') : $default;
};

$finland_logo     = $get_option_field('finland_logo');
$brand_logo_white = $get_option_field('brand_logo_white');
$footer_seo_text  = $get_option_field('footer_seo_text', '');
$phone            = $get_option_field('phone', '');
$phone_clean      = preg_replace('/[^0-9+]/', '', $phone);
$email            = $get_option_field('email', '');
$address_one      = $get_option_field('address_one', '');
$address_two      = $get_option_field('address_two', '');
$hours            = $get_option_field('opening_hours', '');
?>

<footer class="footer mt-8 relative sm:[background:linear-gradient(90deg,var(--color-primary)_50%,var(--color-secondary)_50%)]">
   <span id="land-line" class="_tt-line w-0.5 hidden h-16 sm:h-28 bg-green-600 sm:absolute bottom-39.5 right-11 sm:-top-12.5 sm:right-24"></span>

   <div class="_wrap sm:bg-[url('../images/footer-pattern.png')] bg-position-[right_top_60px] bg-no-repeat">
      <div class="container px-0!">
         <div class="grid sm:grid-cols-2">

            <div class="px-4 sm:px-0 bg-primary sm:bg-transparent py-10 sm:py-24 flex justify-center sm:justify-between">
               <section class="_contact-info text-gray-200 text-lg space-y-6">
                  <div>
                     <h3 class="font-semibold text-xl flex items-center gap-2 mb-1">
                        <i class="ph-duotone ph-call-bell text-2xl"></i><?php echo esc_html(reonet_tr('Contact Information')); ?>
                     </h3>
                     <?php if (!empty($phone)) : ?>
                        <div>
                           <a class="underline underline-offset-4 hover:no-underline" href="tel:<?php echo esc_attr($phone_clean); ?>">
                              <?php echo esc_html($phone); ?>
                           </a>
                        </div>
                     <?php endif; ?>

                     <?php if (!empty($email)) : ?>
                        <div>
                           <a class="underline underline-offset-4 hover:no-underline" href="mailto:<?php echo esc_attr($email); ?>">
                              </i><?php echo esc_html($email); ?>
                           </a>
                        </div>
                     <?php endif; ?>
                  </div>

                  <div>
                     <h3 class="font-semibold text-xl flex items-center gap-2 mb-1">
                        <i class="ph-duotone ph-storefront text-2xl"></i><?php echo esc_html(reonet_tr('Addresses')); ?>
                     </h3>

                     <?php if (!empty($address_one)) : ?>
                        <div>
                           <span><?php echo esc_html(reonet_tr('Address One')); ?>:</span>
                           <span><?php echo esc_html($address_one); ?></span>
                        </div>
                     <?php endif; ?>

                     <?php if (!empty($address_two)) : ?>
                        <div>
                           <span><?php echo esc_html(reonet_tr('Address Two')); ?>:</span>
                           <span><?php echo esc_html($address_two); ?></span>
                        </div>
                     <?php endif; ?>
                  </div>

                  <div>
                     <h3 class="font-semibold text-xl flex items-center gap-2 mb-1">
                        <i class="ph-duotone ph-clock text-2xl"></i><?php echo esc_html(reonet_tr('Opening Hours')); ?>
                     </h3>
                     <?php if (!empty($hours)) : ?>
                        <div><?php echo nl2br(esc_html($hours)); ?></div>
                     <?php endif; ?>
                  </div>

                  <div class="_social-wrap space-y-3">
                     <h3 class="font-semibold text-xl">
                        <?php echo esc_html(reonet_tr('Follow Us')); ?>
                     </h3>

                     <?php if (function_exists('have_rows') && have_rows('social_media', 'option')) : ?>
                        <div class="social-icons flex gap-2.5">
                           <?php while (have_rows('social_media', 'option')) : the_row(); ?>
                              <?php
                              $social_name_raw = get_sub_field('social_name');
                              $social_name     = sanitize_file_name(strtolower((string) $social_name_raw));
                              $social_link     = get_sub_field('social_link');

                              $link_url    = is_array($social_link) ? ($social_link['url'] ?? '') : '';
                              $link_target = is_array($social_link) && !empty($social_link['target']) ? $social_link['target'] : '_self';
                              $link_title  = is_array($social_link) && !empty($social_link['title']) ? $social_link['title'] : ucfirst($social_name);

                              $icon_path = get_template_directory_uri() . '/assets/images/icon/' . $social_name . '-logo-white.svg';
                              ?>

                              <?php if (!empty($link_url) && !empty($social_name)) : ?>
                                 <div class="item">
                                    <a
                                       class="block border-2 rounded-full p-3 hover:bg-secondary hover:border-secondary duration-300"
                                       href="<?php echo esc_url($link_url); ?>"
                                       target="<?php echo esc_attr($link_target); ?>"
                                       rel="<?php echo $link_target === '_blank' ? 'noopener noreferrer' : 'noopener'; ?>"
                                       aria-label="<?php echo esc_attr($link_title); ?>">
                                       <img
                                          class="w-5.5"
                                          src="<?php echo esc_url($icon_path); ?>"
                                          alt="<?php echo esc_attr($link_title); ?>" />
                                    </a>
                                 </div>
                              <?php endif; ?>
                           <?php endwhile; ?>
                        </div>
                     <?php endif; ?>
                  </div>

                  <?php
                  $copyright_text = function_exists('get_field') ? get_field('copyright_text', 'option') : '';
                  $current_year   = date('Y');
                  $site_name      = get_bloginfo('name');
                  ?>

                  <?php if (!empty($copyright_text)) : ?>
                     <div class="text-base mt-12">
                        <?php
                        echo wp_kses_post(
                           str_replace(
                              ['{year}', '{site_name}'],
                              [$current_year, $site_name],
                              $copyright_text
                           )
                        );
                        ?>
                     </div>
                  <?php endif; ?>
               </section>
            </div>

            <div class="px-4 sm:px-0 sm:pl-16 py-10 sm:py-24 bg-secondary sm:bg-transparent space-y-10">
               <?php if (!empty($finland_logo) && is_array($finland_logo) && !empty($finland_logo['url'])) : ?>
                  <div class="h-32 flex">
                     <img
                        src="<?php echo esc_url($finland_logo['url']); ?>"
                        alt="<?php echo esc_attr($finland_logo['alt'] ?? get_bloginfo('name')); ?>" />
                  </div>
               <?php endif; ?>

               <div class="_seo space-y-1">
                  <?php if (!empty($brand_logo_white) && is_array($brand_logo_white) && !empty($brand_logo_white['url'])) : ?>
                     <div class="h-10 flex">
                        <img
                           src="<?php echo esc_url($brand_logo_white['url']); ?>"
                           alt="<?php echo esc_attr($brand_logo_white['alt'] ?? get_bloginfo('name')); ?>" />
                     </div>
                  <?php endif; ?>

                  <?php if (!empty($footer_seo_text)) : ?>
                     <p class="text-white leading-tight"><?php echo esc_html($footer_seo_text); ?></p>
                  <?php endif; ?>
               </div>

               <div class="flex justify-between sm:grid sm:grid-cols-2 sm:gap-6">
                  <nav class="navbar" aria-label="Footer Menu">
                     <h4 class="text-primary font-semibold text-lg mb-1"><?php echo esc_html(reonet_tr('Information')); ?></h4>
                     <?php if (has_nav_menu('footer-menu')) : ?>
                        <?php
                        wp_nav_menu([
                           'theme_location' => 'footer-menu',
                           'menu' => 'footer-menu',
                           'container' => false,
                           'items_wrap' => '<ul class="footer-menu flex flex-col">%3$s</ul>',
                           'walker' => new Footer_Menu_Walker(),
                           'fallback_cb' => false,
                        ]);
                        ?>
                     <?php endif; ?>
                  </nav>

                  <nav class="navbar" aria-label="Footer Service Menu">
                     <h4 class="text-primary font-semibold text-lg mb-1"><?php echo esc_html(reonet_tr('Services')); ?></h4>
                     <?php if (has_nav_menu('footer-service')) : ?>
                        <?php
                        wp_nav_menu([
                           'theme_location' => 'footer-service',
                           'menu' => 'footer-service',
                           'container' => false,
                           'items_wrap' => '<ul class="footer-menu flex flex-col">%3$s</ul>',
                           'walker' => new Footer_Menu_Walker(),
                           'fallback_cb' => false,
                        ]);
                        ?>
                     <?php endif; ?>
                  </nav>
               </div>
            </div>

         </div>
      </div>
   </div>

   <button class="to-top relative hidden fixed z-[99] h-[65px] w-[70px] cursor-pointer bg-[url('../images/icon/totop.png')] bg-contain bg-no-repeat text-white right-[62px] bottom-4 leading-[30px]" type="button" aria-label="<?php echo esc_attr(reonet_tr('Back to top')); ?>">
      <span class="absolute left-0 right-0 top-4 text-center text-sm font-medium"><?php echo esc_html(reonet_tr('Up')); ?></span>
   </button>
</footer>
</div>