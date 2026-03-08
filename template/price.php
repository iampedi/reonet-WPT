<?php
/* Template Name: price */
get_header();
?>

    <div class="component price-list">
        <div class="container px-3 sm:px-0">
            <style>
                .page-header.simple:before {
                    background-image: url(<?php the_field('header_image'); ?>) !important;
                }
            </style>
            <div class="page-header simple">
                <h1><?php the_field('subtitle'); ?></h1>
            </div>
            <div class="page-title">
                <div class="symbol"></div>
                <div class="line"></div>
                <h2><?php the_title() ?></h2>
            </div>
            <div class="content mx-auto sm:w-8/12">
                <div class="flex flex-col">
                    <?php foreach (get_field('pricelist') as $list): ?>
						<?php if($list['issection'] == true || $list['issection2'] == true) : ?>
							<div class="heading-sec mt-14 mb-10 first:mt-0">
								<h3 class="text-green-700 !text-[22px]">
									<?php echo $list['title'] ?>
								</h3>
								 <?php foreach ( $list['priceitem'] as $li):?>
								<div class="text-[18px]">
									<span><?php echo $li['description'];?></span>										
								</div>
								<?php endforeach; ?>
							</div>
						<?php else : ?>
                        <div class="items-sec text-[17px] sm:text-[18px]">
                            <h3><?php echo $list['title'];?></h3>
                            <div class="items">
                                <?php foreach ( $list['priceitem'] as $li):?>
                                <div class='flex flex-col w-full mb-2'>
									<div class='w-full flex justify-between gap-3 sm:gap-6'>
										<span><?php echo $li['name'];?></span><span class="divider"></span><span><?php echo $li['price'];?></span>
									</div>
									<div class='pl-3 sm:pl-6 text-[15px] sm:text-[16px] text-gray-500'>
									    <span><?php echo $li['description'];?></span>										
									</div>
								</div>
                                <?php endforeach; ?>
                            </div>
                        </div>
						<?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>