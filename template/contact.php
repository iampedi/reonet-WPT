<?php
/* Template Name: contact */
get_header();
?>

<div class="component contact">
    <div class="container px-3 sm:px-0">
        <div class="grid sm:grid-cols-2 mt-4 sm:mt-8 gap-6 sm:gap-14">
            <div class="contact-form ">
                <?php
                if (get_language_attributes() == 'lang="en-US"') {
                    echo do_shortcode('[gravityform id="1" title="true"]');
                } else {
                    echo do_shortcode('[gravityform id="2" title="true"]');
                }
                ?>
            </div>
            <div class="contact-info px-8 py-8 sm:px-16 bg-[#44a159] rounded-3xl text-white">
                <div class="_logo">
                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/logo-white.svg"
                        alt="ReoNet Logo white" />
                </div>
                <h2 class="text-2xl font-medium my-4"><?php _tr('Customer Service', 'Asiakaspalvelu') ?></h2>
                <div class="_contact-det mb-6 flex flex-col gap-4 text-lg">
                    <div>
                        <div class="flex items-center gap-1">
                            <h3 class="font-semibold"><?php _tr('Phone:', 'Puhelin:') ?></h3>
                            <span><?php echo get_field('phone', 'option'); ?></span>
                        </div>
                        <div class="flex items-center gap-1">
                            <h3 class="font-semibold"><?php _tr('Email:', 'Sähköposti:') ?></h3>
                            <span><?php echo get_field('mail', 'option'); ?></span>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold"><?php _tr('Opening Hours:', 'Aukioloajat:') ?></h3>
                        <?php echo get_field('hours', 'option'); ?>
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
                </div>

                <!-- Social Icons -->
                <?php $company_social = get_field('company_social', 'option'); ?>
                <div class="social-icons">
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
        <div class="maps-wrap flex flex-col sm:flex-row w-full mt-6 sm:mt-14 gap-6 sm:gap-1">
            <div class="sm:w-1/2">
                <div class="map rounded-tl-3xl rounded-tr-3xl sm:rounded-tr-none" id="map1" style="height: 30vh;">
                </div>
                <h2
                    class="rounded-bl-3xl rounded-br-3xl sm:rounded-br-none bg-gray-300 text-gray-800 flex items-center justify-center h-11 text-lg font-medium">
                    <?php the_field('map_1_title', 'option'); ?>
                </h2>
            </div>
            <div class="sm:w-1/2">
                <div class="map rounded-tr-3xl rounded-tl-3xl sm:rounded-tl-none" id="map2" style="height: 30vh;">
                </div>
                <h2
                    class=" bg-gray-300 rounded-br-3xl rounded-bl-3xl sm:rounded-bl-none text-gray-800 flex items-center justify-center h-11 text-lg font-medium">
                    <?php the_field('map_2_title', 'option'); ?>
                </h2>
            </div>
        </div>
    </div>

    <script>
        <?php $mapicon = get_field('map_icon', 'option'); ?>

        var greenIcon = L.icon({
            iconUrl: '<?php echo $mapicon['url']; ?>',
            iconSize: [<?php echo $mapicon['width']; ?>, <?php echo $mapicon['height']; ?>], // size of the icon
        });

        console.log('Icon URL:', '<?php echo $mapicon['url']; ?>');
        console.log('Icon Size:', [<?php echo $mapicon['width']; ?>, <?php echo $mapicon['height']; ?>]);

        // نقشه اول
        var map1Cords = [<?php echo get_field('map_1_cordinations', 'option'); ?>];
        console.log('Map 1 Coordinates:', map1Cords);
        var map1 = L.map('map1', { scrollWheelZoom: false }).setView(map1Cords, 13);
        L.marker(map1Cords, { icon: greenIcon }).addTo(map1).bindPopup('<?php the_field('map_1_badge', 'option'); ?>');
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap',
        }).addTo(map1);

        // نقشه دوم
        var map2Cords = [<?php echo get_field('map_2_cordinations', 'option'); ?>];
        console.log('Map 2 Coordinates:', map2Cords);
        var map2 = L.map('map2', { scrollWheelZoom: false }).setView(map2Cords, 13);
        L.marker(map2Cords, { icon: greenIcon }).addTo(map2).bindPopup('<?php the_field('map_2_badge', 'option'); ?>');
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap',
        }).addTo(map2);
    </script>

    <?php get_footer(); ?>