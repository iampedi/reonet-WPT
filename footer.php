<footer class="footer mt-16 bg-[#193c68] relative">
    <span class="tt-line hidden sm:block w-[1px] h-[100px] bg-[#51a865] absolute top-[-50px] right-[96px]"></span>
    <div class="wrap">
        <div class="container px-3 sm:px-0">
            <div class="grid sm:grid-cols-3">
                <div class="sm:col-span-2 py-10 sm:py-24 flex justify-center sm:justify-between">
                    <div>
                        <img class="mb-6" src="<?php echo get_template_directory_uri() ?>/assets/images/logo-white.svg"
                            alt="ReoNet Logo white" />
                        <div class="text-gray-200 text-lg leading-[24px] flex flex-col gap-3">
                            <div>
                                <h3 class="font-semibold"><?php _tr('Customer Service', 'Asiakaspalvelu'); ?></h3>
                                <span><?php echo get_field('phone', 'option'); ?></span>
                            </div>
                            <div>
                                <h3 class="font-semibold"><?php _tr('Store Address:', 'Myymälän Osoite:') ?></h3>
                                <div>
                                    <span><?php _tr('Address 1:', 'Osoite 1:') ?></span>
                                    <span> <?php echo get_field('address_store', 'option'); ?></span>
                                </div>
                                <div>
                                    <span><?php _tr('Address 2:', 'Osoite 2:') ?></span>
                                    <span> <?php echo get_field('address_factory', 'option'); ?></span>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold"><?php _tr('Opening Hours', 'Aukioloajat'); ?></h3>
                                <span><?php echo get_field('hours', 'option'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap content-end justify-center sm:justify-start">
                    </div>
                </div>
                <div class="sm:col-span-1 sm:pl-16 flex flex-wrap content-end 2xl:bg-green-600 py-10 sm:py-24">
                    <div class="social-wrap w-full">
                        <h2 class="text-white text-[22px] font-medium text-center sm:text-left mb-6">
                            <?php _tr('Follow us', 'Seuraa meitä'); ?>
                        </h2>
                        <div class="social-icons ">
                            <?php $company_social = get_field('company_social', 'option'); ?>
                            <div class="item">
                                <a href="<?php echo $company_social['facebook']; ?>" target="_blank">
                                    <img class="w-[24px]"
                                        src="<?php echo get_template_directory_uri() ?>/assets/images/icon/facebook-white.svg"
                                        alt="Facebook Icon" />
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo $company_social['instagram']; ?>" target="_blank">
                                    <img class="w-[24px]"
                                        src="<?php echo get_template_directory_uri() ?>/assets/images/icon/instagram-white.svg"
                                        alt="Instgram Icon" />
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo $company_social['tiktok']; ?>" target="_blank">
                                    <img class="w-[24px]"
                                        src="<?php echo get_template_directory_uri() ?>/assets/images/icon/tiktok-white.svg"
                                        alt="TikTok Icon" />
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo $company_social['linkedin']; ?>" target="_blank">
                                    <img class="w-[24px]"
                                        src="<?php echo get_template_directory_uri() ?>/assets/images/icon/linkedin-white.svg"
                                        alt="Linkedin Icon" />
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo $company_social['youtube']; ?>" target="_blank">
                                    <img class="w-[24px]"
                                        src="<?php echo get_template_directory_uri() ?>/assets/images/icon/youtube-white.svg"
                                        alt="You Tube Icon" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!wp_is_mobile()): ?>
        <button class="to-top"><span><?php _tr('up', 'ylös'); ?></span></button>
    <?php endif; ?>
</footer>

</div>

<script type="application/ld+json">
    [{
        "@context": "https://schema.org/",
        "@type": "CreativeWorkSeason",
        "name": "<?php echo $title; ?>",
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "<?php echo $rate; ?>",
            "ratingCount": "<?php echo $ratecount; ?>",
            "bestRating": "5",
            "worstRating": "1"
        }
    }]
</script>

<?php wp_footer(); ?>

<Style>
    .ginput_container.ginput_container_text input::placeholder,
    .ginput_container.ginput_container_textarea textarea:placeholde {
        color: gray !important;
    }
</Style>
</body>

</html>