<?php
if (!defined('ABSPATH')) exit;

$company_social = function_exists('get_field') ? get_field('company_social', 'option') : [];
$phone = function_exists('get_field') ? get_field('phone', 'option') : '';
$address_store = function_exists('get_field') ? get_field('address_store', 'option') : '';
$address_factory = function_exists('get_field') ? get_field('address_factory', 'option') : '';
$hours = function_exists('get_field') ? get_field('hours', 'option') : '';
?>

<footer class="footer relative sm:[background:linear-gradient(90deg,var(--color-primary)_50%,var(--color-secondary)_50%)]">
    <span class="_tt-line w-[2px] h-16 sm:h-28 bg-green-600 absolute bottom-[158px] right-[44px] sm:top-[-50px] sm:right-[96px]"></span>

    <div class="_wrap sm:bg-[url('../images/footer-pattern.png')] bg-[right_top_60px] bg-no-repeat">
        <div class="container px-0!">
            <div class="grid sm:grid-cols-2">
                <div class="px-4 sm:px-0 bg-primary sm:bg-transparent py-10 sm:py-24 flex justify-center sm:justify-between">
                    <div>
                        <img class="mb-6"
                            src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-white.svg'); ?>"
                            alt="<?php echo esc_attr(get_bloginfo('name')); ?> Logo" />

                        <div class="text-gray-200 text-lg leading-[24px] flex flex-col gap-3">
                            <div>
                                <h3 class="font-semibold"><?php _tr('Customer Service', 'Asiakaspalvelu'); ?></h3>
                                <span><?php echo esc_html($phone); ?></span>
                            </div>

                            <div>
                                <h3 class="font-semibold"><?php _tr('Store Address:', 'Myymälän Osoite:'); ?></h3>

                                <div>
                                    <span><?php _tr('Address 1:', 'Osoite 1:'); ?></span>
                                    <span><?php echo esc_html($address_store); ?></span>
                                </div>

                                <div>
                                    <span><?php _tr('Address 2:', 'Osoite 2:'); ?></span>
                                    <span><?php echo esc_html($address_factory); ?></span>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-semibold"><?php _tr('Opening Hours', 'Aukioloajat'); ?></h3>
                                <span><?php echo nl2br(esc_html($hours)); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sm:pl-16 flex flex-wrap content-end py-10 sm:py-24 bg-secondary sm:bg-transparent">
                    <div class="social-wrap w-full">
                        <h2 class="text-white text-[22px] font-medium text-center sm:text-left mb-6">
                            <?php _tr('Follow us', 'Seuraa meitä'); ?>
                        </h2>

                        <div class="social-icons">
                            <div class="item">
                                <a href="<?php echo esc_url($company_social['facebook'] ?? '#'); ?>" target="_blank" rel="noopener">
                                    <img class="w-[24px]" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon/facebook-white.svg'); ?>" alt="Facebook" />
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo esc_url($company_social['instagram'] ?? '#'); ?>" target="_blank" rel="noopener">
                                    <img class="w-[24px]" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon/instagram-white.svg'); ?>" alt="Instagram" />
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo esc_url($company_social['tiktok'] ?? '#'); ?>" target="_blank" rel="noopener">
                                    <img class="w-[24px]" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon/tiktok-white.svg'); ?>" alt="TikTok" />
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo esc_url($company_social['linkedin'] ?? '#'); ?>" target="_blank" rel="noopener">
                                    <img class="w-[24px]" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon/linkedin-white.svg'); ?>" alt="LinkedIn" />
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo esc_url($company_social['youtube'] ?? '#'); ?>" target="_blank" rel="noopener">
                                    <img class="w-[24px]" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon/youtube-white.svg'); ?>" alt="YouTube" />
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="to-top"><span><?php _tr('up', 'ylös'); ?></span></button>

</footer>

</div><!-- /.page-wrap -->