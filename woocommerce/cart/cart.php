<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<div class="_reonet_cart_page mb-8 space-y-6">
	<header class="_reonet_cart_header flex items-center justify-between border-y border-dashed py-2.5 px-3 border-primary/20 bg-blue-50/35">
		<h1 class="text-2xl font-medium text-primary flex items-center gap-3"><i class="ph-duotone ph-shopping-bag text-3xl text-green"></i><?php esc_html_e('Your cart', 'woocommerce'); ?></h1>
		<p class="text-gray-600"><?php echo esc_html(reonet_tr('Review items and continue to checkout.')); ?></p>
	</header>

	<div class="__cart-layout grid grid-cols-1 sm:grid-cols-3 gap-4 items-start">
		<section class="_cart-items sm:col-span-2">
			<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
				<?php do_action('woocommerce_before_cart_table'); ?>

				<div class="cart woocommerce-cart-form__contents _cart-list space-y-2">
					<?php do_action('woocommerce_before_cart_contents'); ?>

					<?php
					foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
						$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
						$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
						/**
						 * Filter the product name.
						 *
						 * @since 2.1.0
						 * @param string $product_name Name of the product in the cart.
						 * @param array $cart_item The product in the cart.
						 * @param string $cart_item_key Key for the product in the cart.
						 */
						$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

						if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
							$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
					?>
							<div class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?> flex items-center gap-4 rounded-2xl p-3 hover:bg-blue-50/50 duration-300">
								<div class="product-thumbnail overflow-hidden rounded-xl">
									<?php
									$thumbnail = apply_filters(
										'woocommerce_cart_item_thumbnail',
										$_product->get_image('woocommerce_thumbnail', array('class' => 'rounded-xl w-full sm:w-28 h-auto object-cover')),
										$cart_item,
										$cart_item_key
									);

									if (! $product_permalink) {
										echo $thumbnail; // PHPCS: XSS ok.
									} else {
										printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
									}
									?>
								</div>

								<div class="flex flex-col gap-2 flex-1">
									<div class="product-name">
										<h3 class="flex items-center justify-between gap-3">
											<?php
											if (! $product_permalink) {
												echo wp_kses_post($product_name . '&nbsp;');
											} else {
												echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a class="text-lg text-primary font-medium" href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
											}
											?>

											<div class="product-remove shrink-0">
												<?php
												echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													'woocommerce_cart_item_remove_link',
													sprintf(
														'<a role="button" href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="ph ph-x-circle text-xl text-muted-forground hover:text-danger"></i></a>',
														esc_url(wc_get_cart_remove_url($cart_item_key)),
														/* translators: %s is the product name */
														esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
														esc_attr($product_id),
														esc_attr($_product->get_sku())
													),
													$cart_item_key
												);
												?>
											</div>
										</h3>
									</div>

									<?php
									do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
									echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

									if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
										echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
									}
									?>

									<div class="cart-item-pricing flex items-center gap-3">
										<div class="product-price text-gray-600 flex items-center gap-1">
											<span class="text-gray-500"><?php esc_html_e('Price', 'woocommerce'); ?>:</span>
											<?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok. 
											?>
										</div>

										<div class="product-quantity">
											<?php
											if ($_product->is_sold_individually()) {
												$min_quantity = 1;
												$max_quantity = 1;
											} else {
												$min_quantity = 0;
												$max_quantity = $_product->get_max_purchase_quantity();
											}

											$product_quantity = woocommerce_quantity_input(
												array(
													'input_name'   => "cart[{$cart_item_key}][qty]",
													'input_value'  => $cart_item['quantity'],
													'max_value'    => $max_quantity,
													'min_value'    => $min_quantity,
													'product_name' => $product_name,
													'classes'      => array_values(array_unique(array_merge(
														array('input-text', 'qty', 'text', 'max-w-12'),
														explode(' ', reonet_flowbite_input_small_class_string())
													))),
												),
												$_product,
												false
											);

											echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
											?>
										</div>

										<div class="product-subtotal font-semibold flex-1 text-right">
											<span class="font-medium text-gray-700"><?php esc_html_e('Subtotal', 'woocommerce'); ?>:</span>
											<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok. 
											?>
										</div>
									</div>
								</div>
							</div>
					<?php
						}
					}
					?>

					<?php do_action('woocommerce_cart_contents'); ?>

					<div class="actions py-6">
						<div class="_cart-actions flex items-center gap-3 justify-between">
							<?php if (wc_coupons_enabled()) { ?>
								<div class="coupon flex items-center gap-2 flex-1">
									<label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
									<input type="text" name="coupon_code" class="max-w-64 <?php echo esc_attr(reonet_flowbite_input_class_string()); ?> text-center" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
									<button type="submit" class="shrink-0 <?php echo esc_attr(reonet_flowbite_button_class_string('secondary', 'icon')); ?>" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><i class="ph-bold ph-check text-xl"></i></button>
									<?php do_action('woocommerce_cart_coupon'); ?>
								</div>
							<?php } ?>

							<button
								type="submit"
								class="shrink-0 hidden h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100"
								name="update_cart"
								value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"
								aria-label="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">
								<i class="ph-bold ph-arrows-clockwise text-lg"></i>
							</button>
						</div>

						<?php do_action('woocommerce_cart_actions'); ?>

						<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
					</div>

					<?php do_action('woocommerce_after_cart_contents'); ?>
				</div>
				<?php do_action('woocommerce_after_cart_table'); ?>
			</form>
		</section>

		<aside class="_cart-summary">
			<?php do_action('woocommerce_before_cart_collaterals'); ?>
			<div class="cart-collaterals">
				<?php woocommerce_cart_totals(); ?>
			</div>
		</aside>
	</div>

	<?php if (! WC()->cart->is_empty()) : ?>
		<section class="_cart-cross-sells">
			<?php woocommerce_cross_sell_display(); ?>
		</section>
	<?php endif; ?>
</div>

<?php do_action('woocommerce_after_cart'); ?>