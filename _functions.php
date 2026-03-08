<!-- theme/reonet/functions.php -->
<?php
add_action('init', function() {
    include_once get_template_directory() . '/functions/enqueue.php';
    include_once get_template_directory() . '/functions/acf.php';
});
 
 function fix_media_library_loading_issue() {
    if (is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'fix_media_library_loading_issue');



//  archive word in archive page title perfix
add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) { //for custom post types
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});


//  image thumbnails
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    add_image_size('blog', 612, 416, true);
    add_image_size('service', 300, 240, true);
    add_image_size('service-first', 320, 340, true);
}


//blog label prefix
function change_post_menu_label()
{
    global $menu;
    global $submenu;
    $menu[5][0] = 'Blog';
    echo '';
}

add_action('admin_menu', 'change_post_menu_label');

//  menu reg
function register_my_menus()
{
    register_nav_menus(
        array(
            'main-menu' => __('main menu'),
            'mobile-menu' => __('mobile menu'),
            'footer-menu' => __('footer menu'),
        )
    );
}
add_action('init', 'register_my_menus');







function get_excerpt($limit, $source = null)
{

    $excerpt = $source == "content" ? get_the_content() : get_the_excerpt();
    $excerpt = preg_replace(" (\[.*?\])", '', $excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
    return $excerpt;
}




//service post type
function custom_post_type()
{

    // Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Services', 'Post Type General Name'),
        'singular_name' => _x('Service', 'Post Type Singular Name'),
        'menu_name' => __('Services'),
        'parent_item_colon' => __('Parent'),
        'all_items' => __('All Service'),
        'view_item' => __('view Service'),
        'add_new_item' => __('Add New Service'),
        'add_new' => __('Add'),
        'edit_item' => __('Edit'),
        'update_item' => __('Update'),
        'search_items' => __('Search'),
        'not_found' => __('Not Found'),
        'not_found_in_trash' => __('Not Found'),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label' => __('Services'),
        'description' => __('Services'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'tags', 'excerpt'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'menu_icon' => 'dashicons-hammer',
        'rewrite' => array('slug' => 'service'),

    );

    // Registering your Custom Post Type
    register_post_type('service', $args);
}

add_action('init', 'custom_post_type', 0);




function add_additional_class_on_li($classes, $item, $args)
{
    if (isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);



function _tr($en, $fi)
{
    if (get_language_attributes() == 'lang="en-US"') {
        echo $en;
    } else {
        echo $fi;
    }
}



function wpml_floating_language_switcher()
{
    echo '<div class="wpml-floating-language-switcher">';
    //PHP action to display the language switcher (see https://wpml.org/documentation/getting-started-guide/language-setup/language-switcher-options/#using-php-actions)
    do_action('wpml_add_language_selector');
    echo '</div>';
}


add_action('acf/include_fields', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_640fb15bd3fa4',
        'title' => 'سئو و بهینه سازی',
        'fields' => array(
            array(
                'key' => 'field_640fb15c6b2db',
                'label' => 'عنوان سئو',
                'name' => 'seo_title',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_640fb1866b2dc',
                'label' => 'توضیحات سئو',
                'name' => 'seo_description',
                'aria-label' => '',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'rows' => '',
                'placeholder' => '',
                'new_lines' => '',
            ),
            array(
                'key' => 'field_6413d51025252',
                'label' => 'تعداد آرا',
                'name' => 'ratingCount',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_6413d53525253',
                'label' => 'میانگین آرا',
                'name' => 'initialRating',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_6460e804ea702',
                'label' => 'درخواست عدم ایندکس توسط گوگل',
                'name' => 'noindex',
                'aria-label' => '',
                'type' => 'checkbox',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'noindex' => 'ایندکس نشود',
                ),
                'default_value' => array(),
                'return_format' => 'value',
                'allow_custom' => 0,
                'layout' => 'vertical',
                'toggle' => 0,
                'save_custom' => 0,
                'custom_choice_button_text' => 'درج انتخاب جدید',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'products',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
});
// add_filter( 'use_block_editor_for_post', '__return_false' );
// add_filter( 'use_widgets_block_editor', '__return_false' );



function custom_acf_field_type($field_types)
{
    class ACF_Custom_Field_Type_Gravity_Forms extends acf_field
    {
        function __construct()
        {
            $this->name = 'gravity_forms_select';
            $this->label = __('Gravity Forms');
            $this->category = 'choice';
            $this->defaults = array(
                'default_value' => '',
            );
            parent::__construct();
        }

        function render_field($field)
        {

            if (is_plugin_active('gravityforms/gravityforms.php')) {
                // get Gravity Forms
                $forms = GFAPI::get_forms();


                // Display a select dropdown for Gravity Forms
?>
                <select name="<?php echo esc_attr($field['name']); ?>">
                    <option value="">Select a Gravity Form</option>
                    <?php foreach ($forms as $form) : ?>
                        <option value="<?php echo esc_attr($form['id']); ?>" <?php selected($field['value'], $form['id']); ?>>
                            <?php echo esc_html($form['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
<?php
            }
        }
    }

    acf_register_field_type(new ACF_Custom_Field_Type_Gravity_Forms());
}

add_action('acf/include_field_types', 'custom_acf_field_type');
