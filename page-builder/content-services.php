<?php
$services = get_sub_field('service');
if ($services) :
    $i = 1;
?>
    <section class="_home-services py-8 sm:pb-16">
        <div class="container">
            <div class="_services-card flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">
                <?php foreach ($services as $service) : ?>
                    <div class="group relative">

                        <?php if ($i == 1) : ?>
                            <div class="absolute -top-8 -left-8 hidden sm:block w-[86px]">
                                <?php echo wp_get_attachment_image(get_sub_field('img'), 'full'); ?>
                            </div>
                        <?php endif; ?>

                        <a href="<?php echo esc_url(get_permalink($service->ID)); ?>">
                            <?php echo get_the_post_thumbnail($service->ID, 'full', ['class' => 'aspect-4/3 object-cover w-[340px] rounded-2xl']); ?>

                            <div class="_card-body absolute bottom-8 px-6 left-0 w-full flex items-center justify-between">
                                <div class="_text uppercase text-white [text-shadow:2px_2px_2px_#000]">
                                    <span class="text-xl"><?php _tr('Service', 'PALVELUT'); ?></span>
                                    <h3 class="leading-none font-semibold text-2xl"><?php echo esc_html(get_the_title($service->ID)); ?></h3>
                                </div>

                                <div class="btn-serv bg-primary/90 sm:bg-transparent sm:group-hover:bg-primary/90 flex py-3 pr-1 rounded-md duration-300">
                                    <i class="ph ph-arrow-right text-2xl text-white sm:[text-shadow:2px_2px_2px_#000] sm:group-hover:text-shadow-none -ml-[2px]"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>