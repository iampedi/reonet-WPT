<?php

/**
 * My Account Orders
 *
 * Theme override for WooCommerce My Account orders table.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.5.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders);
?>

<?php if ($has_orders) : ?>

	<table class="my_account_orders_table w-full text-[15px] text-primary">
		<thead class="bg-blue-50 border-b border-primary/30">
			<tr>
				<?php foreach (wc_get_account_orders_columns() as $column_id => $column_name) : ?>
					<th scope="col" class="px-5 py-3.5 first:rounded-tl-2xl last:rounded-tr-2xl font-medium woth_<?php echo esc_attr($column_id); ?>">
						<span class="nobr"><?php echo esc_html($column_name); ?></span>
					</th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody class="text-sm">
			<?php foreach ($customer_orders->orders as $customer_order) : ?>
				<?php
				$order      = wc_get_order($customer_order); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				$item_count = $order->get_item_count() - $order->get_item_count_refunded();
				?>
				<tr class="border-b border-gray-200 last:border-b-0 hover:bg-gray-50 wotr--status-<?php echo esc_attr($order->get_status()); ?> order">
					<?php foreach (wc_get_account_orders_columns() as $column_id => $column_name) : ?>
						<?php $is_order_number = 'order-number' === $column_id; ?>
						<?php if ($is_order_number) : ?>
							<th class="px-5 py-3 font-medium text-heading whitespace-nowrap wotc_<?php echo esc_attr($column_id); ?>" data-title="<?php echo esc_attr($column_name); ?>" scope="row">
							<?php else : ?>
							<td class="px-5 py-3 text-center wotc_<?php echo esc_attr($column_id); ?>" data-title="<?php echo esc_attr($column_name); ?>">
							<?php endif; ?>

							<?php if (has_action('woocommerce_my_account_my_orders_column_' . $column_id)) : ?>
								<?php do_action('woocommerce_my_account_my_orders_column_' . $column_id, $order); ?>

							<?php elseif ($is_order_number) : ?>
								<?php /* translators: %s: the order number, usually accompanied by a leading # */ ?>
								<a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="font-medium text-primary underline" aria-label="<?php echo esc_attr(sprintf(__('View order number %s', 'woocommerce'), $order->get_order_number())); ?>">
									<?php echo esc_html(_x('#', 'hash before order number', 'woocommerce') . $order->get_order_number()); ?>
								</a>

							<?php elseif ('order-date' === $column_id) : ?>
								<time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></time>

							<?php elseif ('order-status' === $column_id) : ?>
								<?php
								$order_status_key   = sanitize_html_class($order->get_status());
								$order_status_label = wc_get_order_status_name($order->get_status());
								$default_order_status_class = function_exists('reonet_flowbite_order_status_badge_class_string')
									? reonet_flowbite_order_status_badge_class_string($order_status_key)
									: 'inline-flex items-center whitespace-nowrap rounded-full border border-gray-300 bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700';
								$order_status_class = apply_filters(
									'reonet_my_account_order_status_badge_class',
									$default_order_status_class,
									$order
								);
								?>
								<span class="<?php echo esc_attr($order_status_class); ?>">
									<?php echo esc_html($order_status_label); ?>
								</span>

							<?php elseif ('order-total' === $column_id) : ?>
								<?php
								/* translators: 1: formatted order total 2: total order items */
								echo wp_kses_post(sprintf(_n('%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce'), $order->get_formatted_order_total(), $item_count));
								?>

							<?php elseif ('order-actions' === $column_id) : ?>
								<?php
								$actions = wc_get_account_orders_actions($order);
								$actions = apply_filters('reonet_my_account_orders_actions', $actions, $order);

								$action_icon_map = apply_filters(
									'reonet_my_account_orders_action_icon_map',
									array(
										'pay'         => 'ph-credit-card',
										'view'        => 'ph-receipt',
										'cancel'      => 'ph-x-circle',
										'order-again' => 'ph-arrow-counter-clockwise',
									),
									$order
								);

								$actions_wrapper_class = apply_filters(
									'reonet_my_account_orders_actions_wrapper_class',
									'flex justify-center',
									$order
								);

								$custom_actions_html = apply_filters('reonet_my_account_orders_actions_html', '', $actions, $order);

								if (is_string($custom_actions_html) && $custom_actions_html !== '') :
									echo $custom_actions_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								elseif (!empty($actions)) :
								?>
									<?php
									$normalized_actions = array();

									foreach ($actions as $key => $action) {
										$action_name = isset($action['name']) ? (string) $action['name'] : ucfirst((string) $key);
										$action_name = apply_filters('reonet_my_account_orders_action_name', $action_name, $key, $action, $order);

										if (empty($action['aria-label'])) {
											/* translators: %1$s Action name, %2$s Order number. */
											$action_aria_label = sprintf(__('%1$s order number %2$s', 'woocommerce'), $action_name, $order->get_order_number());
										} else {
											$action_aria_label = $action['aria-label'];
										}

										$button_base_class = function_exists('reonet_flowbite_button_class_string')
											? reonet_flowbite_button_class_string('secondary', 'icon')
											: 'button';

										$button_class = apply_filters('reonet_my_account_orders_action_button_class', $button_base_class, $key, $action, $order);
										$icon_class = isset($action_icon_map[$key]) ? $action_icon_map[$key] : 'ph-arrow-square-out';
										$icon_class = apply_filters('reonet_my_account_orders_action_icon_class', $icon_class, $key, $action, $order);

										$normalized_actions[$key] = array(
											'url'        => isset($action['url']) ? $action['url'] : '',
											'action'     => $action,
											'name'       => $action_name,
											'aria_label' => $action_aria_label,
											'button'     => $button_class,
											'icon'       => $icon_class,
										);
									}

									$actions_count = count($normalized_actions);
									?>

									<?php if ($actions_count <= 1) : ?>
										<div class="<?php echo esc_attr($actions_wrapper_class); ?>">
											<?php foreach ($normalized_actions as $key => $action_data) : ?>
												<?php
												$tooltip_id = '_order-action-tooltip-' . absint($order->get_id()) . '-' . sanitize_html_class((string) $key);
												$custom_action_html = apply_filters(
													'reonet_my_account_orders_action_html',
													'',
													$key,
													$action_data['action'],
													$order,
													$action_data['name'],
													$action_data['icon'],
													$action_data['button'],
													$action_data['aria_label']
												);

												if (is_string($custom_action_html) && $custom_action_html !== '') {
													echo $custom_action_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													continue;
												}
												?>
												<span class="group relative inline-flex">
													<a href="<?php echo esc_url($action_data['url']); ?>" class="inline-flex items-center justify-center" aria-label="<?php echo esc_attr($action_data['aria_label']); ?>">
														<i class="ph-duotone <?php echo esc_attr($action_data['icon']); ?> text-xl" aria-hidden="true"></i>
														<span class="sr-only"><?php echo esc_html($action_data['name']); ?></span>
													</a>
													<div id="<?php echo esc_attr($tooltip_id); ?>" role="tooltip" class="pointer-events-none invisible absolute -top-2 left-1/2 z-10 inline-block -translate-x-1/2 -translate-y-full whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-xs transition-opacity duration-150 group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">
														<?php echo esc_html($action_data['name']); ?>
														<div class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1/2 rotate-45 bg-gray-900"></div>
													</div>
												</span>
											<?php endforeach; ?>
										</div>
									<?php else : ?>
										<?php
										$dropdown_id = '_order-actions-dropdown-' . absint($order->get_id());
										$toggle_id = $dropdown_id . '-toggle';
										$toggle_tooltip_id = $dropdown_id . '-tooltip';
										$dropdown_toggle_button_class = function_exists('reonet_flowbite_button_class_string')
											? 'inline-flex items-center justify-center cursor-pointer'
											: 'button';
										$dropdown_item_class = apply_filters(
											'reonet_my_account_orders_action_dropdown_item_class',
											'flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
											$order
										);
										?>
										<div class="relative flex justify-center">
											<span class="group relative inline-flex">
												<button id="<?php echo esc_attr($toggle_id); ?>" type="button" class="<?php echo esc_attr($dropdown_toggle_button_class); ?>" data-dropdown-toggle="<?php echo esc_attr($dropdown_id); ?>" data-dropdown-placement="bottom" aria-label="<?php echo esc_attr__('Order actions', 'woocommerce'); ?>">
													<i class="ph-duotone ph-dots-three-circle text-xl" aria-hidden="true"></i>
													<span class="sr-only"><?php esc_html_e('Order actions', 'woocommerce'); ?></span>
												</button>
												<div id="<?php echo esc_attr($toggle_tooltip_id); ?>" role="tooltip" class="pointer-events-none invisible absolute -top-2 left-1/2 z-10 inline-block -translate-x-1/2 -translate-y-full whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-xs transition-opacity duration-150 group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">
													<?php esc_html_e('Order actions', 'woocommerce'); ?>
													<div class="absolute left-1/2 top-full size-2 -translate-x-1/2 -translate-y-1/2 rotate-45 bg-gray-900"></div>
												</div>
											</span>

											<div id="<?php echo esc_attr($dropdown_id); ?>" class="z-10 hidden w-36 divide-y divide-gray-100 rounded-lg bg-gray-50 border border-gray-200 shadow-sm">
												<ul class="py-2 text-sm text-gray-700" aria-labelledby="<?php echo esc_attr($toggle_id); ?>">
													<?php foreach ($normalized_actions as $key => $action_data) : ?>
														<?php
														$custom_action_html = apply_filters(
															'reonet_my_account_orders_action_html',
															'',
															$key,
															$action_data['action'],
															$order,
															$action_data['name'],
															$action_data['icon'],
															$action_data['button'],
															$action_data['aria_label']
														);

														if (is_string($custom_action_html) && $custom_action_html !== '') {
															echo $custom_action_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
															continue;
														}

														$is_destructive_action = in_array($key, array('cancel', 'delete'), true);
														$icon_color_class = $is_destructive_action ? 'text-red-600' : '';
														?>
														<li>
															<a href="<?php echo esc_url($action_data['url']); ?>" class="<?php echo esc_attr($dropdown_item_class); ?>" aria-label="<?php echo esc_attr($action_data['aria_label']); ?>">
																<i class="ph-duotone <?php echo esc_attr($action_data['icon']); ?> text-lg <?php echo esc_attr($icon_color_class); ?>" aria-hidden="true"></i>
																<span><?php echo esc_html($action_data['name']); ?></span>
															</a>
														</li>
													<?php endforeach; ?>
												</ul>
											</div>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>

							<?php if ($is_order_number) : ?>
								</th>
							<?php else : ?>
							</td>
						<?php endif; ?>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php do_action('woocommerce_before_account_orders_pagination'); ?>

	<?php if (1 < $customer_orders->max_num_pages) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination mt-4 flex items-center justify-between gap-3">
			<?php if (1 !== $current_page) : ?>
				<a class="<?php echo esc_attr(function_exists('reonet_flowbite_button_class_string') ? reonet_flowbite_button_class_string('secondary', 'sm') : 'button'); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>">
					<?php esc_html_e('Previous', 'woocommerce'); ?>
				</a>
			<?php endif; ?>

			<?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
				<a class="<?php echo esc_attr(function_exists('reonet_flowbite_button_class_string') ? reonet_flowbite_button_class_string('secondary', 'sm') : 'button'); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>">
					<?php esc_html_e('Next', 'woocommerce'); ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>

	<?php
	$browse_products_button_class = function_exists('reonet_flowbite_button_class_string')
		? reonet_flowbite_button_class_string('secondary', 'sm')
		: 'button';
	?>
	<?php wc_print_notice(esc_html__('No order has been made yet.', 'woocommerce') . ' <a class="' . esc_attr($browse_products_button_class) . '" href="' . esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))) . '">' . esc_html__('Browse products', 'woocommerce') . '</a>', 'notice'); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment 
	?>

<?php endif; ?>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>