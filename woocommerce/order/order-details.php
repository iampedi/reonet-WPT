<?php

/**
 * Order details
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

defined('ABSPATH') || exit;

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if (! $order) {
	return;
}

$order_items        = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$downloads          = $order->get_downloadable_items();
$actions            = array_filter(
	wc_get_account_orders_actions($order),
	function ($key) {
		return 'view' !== $key;
	},
	ARRAY_FILTER_USE_KEY
);

// We make sure the order belongs to the user. This will also be true if the user is a guest, and the order belongs to a guest (userID === 0).
$show_customer_details = $order->get_user_id() === get_current_user_id();

if ($show_downloads) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<section class="woocommerce-order-details overflow-hidden card sm:col-span-2">
	<?php do_action('woocommerce_order_details_before_order_table', $order); ?>

	<div class="card-head">
		<h2 class="woocommerce-order-details__title"><?php esc_html_e('Order details', 'woocommerce'); ?></h2>
	</div>

	<div class="card-body pb-4!">
		<div class="woocommerce-table woocommerce-table--order-details shop_table order_details">
			<div class="divide-y divide-gray-200 divide-dashed space-y-3">
				<?php
				do_action('woocommerce_order_details_before_order_table_items', $order);

				foreach ($order_items as $item_id => $item) {
					$product          = $item->get_product();
					$item_name        = $item->get_name();
					$item_qty         = $item->get_quantity();
					$item_subtotal    = $order->get_formatted_line_subtotal($item);
					$item_price       = wc_price($order->get_item_total($item, false, true), array('currency' => $order->get_currency()));
					$product_permalink = $product && $product->is_visible() ? $product->get_permalink() : '';
					$thumbnail        = $product ? $product->get_image('woocommerce_thumbnail', array('class' => 'rounded-xl w-full sm:w-20 h-auto object-cover')) : wc_placeholder_img('woocommerce_thumbnail', array('class' => 'rounded-xl w-full sm:w-20 h-auto object-cover'));
				?>
					<div class="woocommerce-table__line-item flex items-center gap-4 pb-3">
						<div class="product-thumbnail overflow-hidden rounded-xl">
							<?php if ($product_permalink) : ?>
								<a href="<?php echo esc_url($product_permalink); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
							<?php else : ?>
								<?php echo wp_kses_post($thumbnail); ?>
							<?php endif; ?>
						</div>

						<div class="flex min-w-0 flex-1 flex-col gap-1">
							<div class="product-name text-lg font-medium text-primary">
								<?php if ($product_permalink) : ?>
									<a class="text-lg font-medium text-primary" href="<?php echo esc_url($product_permalink); ?>"><?php echo esc_html($item_name); ?></a>
								<?php else : ?>
									<span class="text-lg font-medium text-primary"><?php echo esc_html($item_name); ?></span>
								<?php endif; ?>
							</div>

							<div class="text-[15px] text-gray-600 [&_.wc-item-meta]:m-0 [&_.wc-item-meta]:flex [&_.wc-item-meta]:flex-wrap [&_.wc-item-meta]:items-center [&_.wc-item-meta]:gap-x-4 [&_.wc-item-meta]:gap-y-1 [&_.wc-item-meta]:p-0 [&_.wc-item-meta_li]:m-0 [&_.wc-item-meta_li]:flex [&_.wc-item-meta_li]:list-none [&_.wc-item-meta_li]:p-0 [&_.wc-item-meta_strong]:mr-1 [&_.wc-item-meta_strong]:font-normal [&_.wc-item-meta_strong]:text-gray-500 [&_.wc-item-meta_p]:m-0 [&_p]:m-0 [&_dl]:m-0 [&_dd]:m-0">
								<?php echo wc_display_item_meta($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
								?>
							</div>


							<?php if ($show_purchase_note && $product && $product->get_purchase_note()) : ?>
								<div class="text-sm text-gray-600"><?php echo wp_kses_post(wpautop(do_shortcode($product->get_purchase_note()))); ?></div>
							<?php endif; ?>
						</div>
					</div>
				<?php
				}

				do_action('woocommerce_order_details_after_order_table_items', $order);
				?>
			</div>

			<div class="divide-y divide-gray-200 divide-dashed border-t-2 border-gray-200">
				<?php foreach ($order->get_order_item_totals() as $key => $total) : ?>
					<div class="flex items-center justify-between gap-3 p-3">
						<div class="font-medium text-gray-700"><?php echo esc_html($total['label']); ?></div>
						<div class="text-right font-medium [&_.amount]:text-green"><?php echo wp_kses_post($total['value']); ?></div>
					</div>
				<?php endforeach; ?>

				<?php if ($order->get_customer_note()) : ?>
					<div class="flex items-start justify-between gap-3 p-3">
						<div class="font-medium text-gray-700"><?php esc_html_e('Note:', 'woocommerce'); ?></div>
						<div class="text-gray-600 leading-tight text-[15px]">
							<?php
							$customer_note = wc_wptexturize_order_note($order->get_customer_note());
							echo wp_kses(nl2br($customer_note), array('br' => array()));
							?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<?php if (! empty($actions)) : ?>
				<div class="border-t border-primary/15 px-4 py-3 sm:px-5">
					<div class="mb-2 text-sm font-medium text-gray-700"><?php esc_html_e('Actions', 'woocommerce'); ?>:</div>
					<div class="flex flex-wrap gap-2">
						<?php
						foreach ($actions as $key => $action) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
							if (empty($action['aria-label'])) {
								/* translators: %1$s Action name, %2$s Order number. */
								$action_aria_label = sprintf(__('%1$s order number %2$s', 'woocommerce'), $action['name'], $order->get_order_number());
							} else {
								$action_aria_label = $action['aria-label'];
							}
							echo '<a href="' . esc_url($action['url']) . '" class="woocommerce-button button order-actions-button ' . sanitize_html_class($key) . ' inline-flex h-10 items-center justify-center rounded-full border-0 bg-primary px-5 text-sm font-medium text-white duration-300 hover:bg-green" aria-label="' . esc_attr($action_aria_label) . '">' . esc_html($action['name']) . '</a>';
							unset($action_aria_label);
						}
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php do_action('woocommerce_order_details_after_order_table', $order); ?>
</section>

<?php
do_action('woocommerce_after_order_details', $order);

if ($show_customer_details && ! is_order_received_page()) {
	wc_get_template('order/order-details-customer.php', array('order' => $order));
}
