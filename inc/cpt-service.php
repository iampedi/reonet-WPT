<?php
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Register Service CPT
 */
function reonet_register_service_cpt()
{
    $labels = array(
        'name'                  => _x('Services', 'Post Type General Name', 'reonet'),
        'singular_name'         => _x('Service', 'Post Type Singular Name', 'reonet'),
        'menu_name'             => __('Services', 'reonet'),
        'name_admin_bar'        => __('Service', 'reonet'),
        'add_new'               => __('Add New', 'reonet'),
        'add_new_item'          => __('Add New Service', 'reonet'),
        'edit_item'             => __('Edit Service', 'reonet'),
        'new_item'              => __('New Service', 'reonet'),
        'view_item'             => __('View Service', 'reonet'),
        'view_items'            => __('View Services', 'reonet'),
        'search_items'          => __('Search Services', 'reonet'),
        'not_found'             => __('Not found', 'reonet'),
        'not_found_in_trash'    => __('Not found in Trash', 'reonet'),
        'all_items'             => __('All Services', 'reonet'),
        'archives'              => __('Service Archives', 'reonet'),
        'attributes'            => __('Service Attributes', 'reonet'),
        'featured_image'        => __('Featured Image', 'reonet'),
        'set_featured_image'    => __('Set featured image', 'reonet'),
        'remove_featured_image' => __('Remove featured image', 'reonet'),
        'use_featured_image'    => __('Use as featured image', 'reonet'),
    );

    $args = array(
        'label'               => __('Services', 'reonet'),
        'description'         => __('Services', 'reonet'),
        'labels'              => $labels,
        'hierarchical'        => true,
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'taxonomies'          => array('category', 'post_tag'),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-hammer',
        'can_export'          => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'has_archive'         => true,
        'rewrite'             => array(
            'slug'         => 'palvelut',
            'with_front'   => false,
            'hierarchical' => true,
        ),
        'show_in_rest'        => true,
    );

    register_post_type('service', $args);
}
add_action('init', 'reonet_register_service_cpt', 20);

/**
 * Archive query:
 * - only top-level services
 * - order by native WordPress menu_order
 * - fallback by title
 */
function reonet_modify_service_archive_query($query)
{
    if (
        !is_admin() &&
        $query->is_main_query() &&
        is_post_type_archive('service')
    ) {
        $query->set('post_parent', 0);
        $query->set('orderby', array(
            'menu_order' => 'ASC',
            'title'      => 'ASC',
        ));
    }
}
add_action('pre_get_posts', 'reonet_modify_service_archive_query');

/**
 * Native Service Order metabox
 */
function reonet_add_service_order_metabox()
{
    add_meta_box(
        'reonet_service_order',
        __('Service Order', 'reonet'),
        'reonet_render_service_order_metabox',
        'service',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'reonet_add_service_order_metabox');

function reonet_render_service_order_metabox($post)
{
    wp_nonce_field('reonet_save_service_order', 'reonet_service_order_nonce');
    $menu_order = (int) $post->menu_order;
?>
    <p>
        <label for="reonet_service_order_field">
            <?php esc_html_e('Order', 'reonet'); ?>
        </label>
    </p>
    <input
        type="number"
        id="reonet_service_order_field"
        name="reonet_service_order_field"
        value="<?php echo esc_attr($menu_order); ?>"
        min="0"
        step="1"
        style="width:100%;" />
    <p style="margin-top:8px; color:#666; font-size:12px;">
        <?php esc_html_e('Lower numbers appear first.', 'reonet'); ?>
    </p>
<?php
}

function reonet_save_service_order_metabox($post_id)
{
    if (!isset($_POST['reonet_service_order_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['reonet_service_order_nonce'], 'reonet_save_service_order')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $menu_order = isset($_POST['reonet_service_order_field'])
        ? (int) $_POST['reonet_service_order_field']
        : 0;

    remove_action('save_post_service', 'reonet_save_service_order_metabox');

    wp_update_post(array(
        'ID'         => $post_id,
        'menu_order' => $menu_order,
    ));

    add_action('save_post_service', 'reonet_save_service_order_metabox');
}
add_action('save_post_service', 'reonet_save_service_order_metabox');

/**
 * Admin columns
 */
function reonet_service_columns($columns)
{
    $new_columns = array();

    foreach ($columns as $key => $label) {
        $new_columns[$key] = $label;

        if ($key === 'title') {
            $new_columns['service_order'] = __('Order', 'reonet');
            $new_columns['service_parent'] = __('Parent', 'reonet');
        }
    }

    return $new_columns;
}
add_filter('manage_service_posts_columns', 'reonet_service_columns');

function reonet_service_custom_column($column, $post_id)
{
    if ($column === 'service_order') {
        echo (int) get_post_field('menu_order', $post_id);
    }

    if ($column === 'service_parent') {
        $parent_id = wp_get_post_parent_id($post_id);

        if ($parent_id) {
            echo esc_html(get_the_title($parent_id));
        } else {
            echo '—';
        }
    }
}
add_action('manage_service_posts_custom_column', 'reonet_service_custom_column', 10, 2);

/**
 * Make Order column sortable
 */
function reonet_service_sortable_columns($columns)
{
    $columns['service_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-service_sortable_columns', 'reonet_service_sortable_columns');

/**
 * Support sorting by menu_order in admin list
 */
function reonet_service_admin_orderby($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('post_type') !== 'service') {
        return;
    }

    if ($query->get('orderby') === 'menu_order') {
        $query->set('orderby', array(
            'menu_order' => 'ASC',
            'title'      => 'ASC',
        ));
    }
}
add_action('pre_get_posts', 'reonet_service_admin_orderby');

/**
 * Template files
 */

add_filter('single_template', function ($template) {
    if (get_post_type() === 'service') {
        $custom = locate_template('template-parts/services/single-service.php');
        if ($custom) {
            return $custom;
        }
    }
    return $template;
});

add_filter('archive_template', function ($template) {
    if (is_post_type_archive('service')) {
        $custom = locate_template('template-parts/services/archive-service.php');
        if ($custom) {
            return $custom;
        }
    }
    return $template;
});
