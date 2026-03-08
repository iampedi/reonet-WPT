<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green-500': "#339966",
                        'green-600': "#5bd075",
                        'green-700': "#268b32",

                        blue: {
                            900: "#193c68",
                            700: '#28567a',
                        },
                    },
                },
            },
        };
    </script>

    <!-- SEO Section -->
    <?php
    $title = (!is_post_type_archive() && get_field('seo_title')) ? get_field('seo_title') : str_replace('  ', '', wp_title('', false));
    $description = (!is_post_type_archive() && get_field('seo_description')) ? get_field('seo_description') : get_the_excerpt();

    $thumbnail = get_the_post_thumbnail_url();
    $thumbnail_meta = wp_get_attachment_metadata(get_post_thumbnail_id());

    $link = get_permalink();
    $company_name = get_field('company_name', 'option');

    $post_type = get_post_type();
    if ($post_type) {
        $post_type_data = get_post_type_object($post_type);
        $post_type_slug = $post_type;
        $post_type_label = $post_type_data->labels->name;
    }

    $content_type = (is_front_page() || is_archive()) ? 'website' : 'article';

    $company_social = get_field('company_social', 'option');

    $noindex_post_types = array("faq", "docs", "attachment", "promos");
    $noindex = (get_field('noindex')) ? get_field('noindex')[0] : null;
    if (is_tag()) {
        $object = get_queried_object();
        $noindex = (get_field('index', $object)) ? "index" : "noindex";
    }
    if (in_array($post_type, $noindex_post_types) || $noindex == "noindex") :
        $index = 'noindex, nofollow';
    else :
        $index = 'index, follow';
    endif;
    ?>

    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo str_replace('"', '', $description); ?>" />
    <meta name="robots" content="<?php echo $index; ?>" />
    <link rel="canonical" href="<?php echo $link; ?>" />
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="<?php echo $content_type; ?>" />
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo str_replace('"', '', $description); ?>" />
    <meta property="og:url" content="<?php echo $link; ?>" />
    <meta property="og:site_name" content="<?php echo $company_name; ?>" />
    <?php if (is_singular()) { ?>
        <meta property="article:publisher" content="<?php echo $company_social['facebook']; ?>" />
        <meta property="article:modified_time" content="<?php echo get_the_modified_date('c'); ?>" />
        <meta property="og:image" content="<?php echo $thumbnail; ?>" />
        <meta property="og:image:width" content="<?php echo $thumbnail_w; ?>" />
        <meta property="og:image:height" content="<?php echo $thumbnail_h; ?>" />
        <meta property="og:image:type" content="image/png" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="<?php echo $company_social['twitter']; ?>" />
    <?php } ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@graph": [{
                    "@type": "WebPage",
                    "@id": "<?php echo $link; ?>",
                    "url": "<?php echo $link; ?>",
                    "name": "<?php echo $title; ?>",
                    "isPartOf": {
                        "@id": "<?php echo $link; ?>#website"
                    },
                    "about": {
                        "@id": "<?php echo $link; ?>#organization"
                    },
                    "datePublished": "<?php echo get_the_date('c'); ?>",
                    "dateModified": "<?php echo get_the_modified_date('c'); ?>",
                    "description": "<?php echo str_replace('"', '', $description); ?>",
                    "breadcrumb": {
                        "@id": "<?php echo $link; ?>#breadcrumb"
                    },
                    "inLanguage": "fa-IR",
                    "potentialAction": [{
                        "@type": "ReadAction",
                        "target": ["<?php echo $link; ?>"]
                    }]
                }, {
                    "@type": "BreadcrumbList",
                    "@id": "<?php echo $link; ?>#breadcrumb",
                    "name": "Breadcrumb",
                    "itemListElement": [{
                            "@type": "ListItem",
                            "position": 1,
                            "name": "home",
                            "item": "<?php echo home_url(); ?>/"
                        }
                        <?php
                        $i = 1;
                        $default_post_types = array("post", "page", "attachment");
                        if (!in_array($post_type, $default_post_types) && !is_archive()) :
                            $i++;
                        ?>, {
                                "@type": "ListItem",
                                "position": <?php echo $i; ?>,
                                "name": "<?php echo $post_type_label; ?>",
                                "item": "<?php echo home_url(); ?>/<?php echo $post_type_slug; ?>/"
                            }
                        <?php endif;
                        if (!is_front_page() && !is_post_type_archive()) :
                            $i++; ?>, {
                                "@type": "ListItem",
                                "position": <?php echo $i; ?>,
                                "name": "<?php echo $title; ?>"
                            }
                        <?php endif; ?>
                    ]
                },
                {
                    "@type": "WebSite",
                    "@id": "<?php echo home_url(); ?>/#website",
                    "url": "<?php echo home_url(); ?>/",
                    "name": "<?php echo $company_name; ?>",
                    "description": "",
                    "publisher": {
                        "@id": "<?php echo home_url(); ?>/#organization"
                    },
                    "potentialAction": [{
                        "@type": "SearchAction",
                        "target": {
                            "@type": "EntryPoint",
                            "urlTemplate": "<?php echo home_url(); ?>/?s={search_term_string}"
                        },
                        "query-input": "required name=search_term_string"
                    }],
                    "inLanguage": "fa-IR"
                },
                {
                    "@type": "Organization",
                    "@id": "<?php echo home_url(); ?>/#organization",
                    "name": "<?php echo $company_name; ?>",
                    "url": "<?php echo home_url(); ?>/",
                    "logo": {
                        "@type": "ImageObject",
                        "inLanguage": "fa-IR",
                        "@id": "<?php echo home_url(); ?>/#/schema/logo/image/",
                        "url": "<?php echo $company_logo; ?>",
                        "contentUrl": "<?php echo $company_logo; ?>",
                        "width": 512,
                        "height": 512,
                        "caption": "<?php echo $company_name; ?>"
                    },
                    "image": {
                        "@id": "<?php echo home_url(); ?>/#/schema/logo/image/",
                        "name": "<?php echo $company_name; ?>"
                    },
                    "sameAs": ["<?php echo $company_social['instagram']; ?>
                        ", "
                        <?php echo $company_social['linkedin']; ?> ", "
                        <?php echo $company_social['facebook']; ?> ", "
                        <?php echo $company_social['twitter']; ?> "]
                    }
                ]
            }
    </script>
    <!-- /SEO Section -->

    <?php wp_head(); ?>
</head>

<body class="font-['jost'] home">
    <?php if (have_rows('toc')) : ?>
        <table class="deatail options" style="display: table-column;">
            <tbody>
                <?php while (have_rows('toc')) : the_row(); ?>
                    <tr>
                        <td><?php echo get_sub_field("title"); ?> ✅</td>
                        <td><?php echo get_sub_field("desc"); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="page-wrap">
        <header>
            <div class="container px-3 sm:px-0">
                <div class="flex justify-between items-center py-3 mb-3 sm:mb-5">
                    <div class="logo h-auto flex">
                        <a href="<?php echo get_site_url(); ?>">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/images/logo.svg" class="logo-img" />
                        </a>
                    </div>
                    <div class="menu-bars sm:hidden" onclick="mobileMenu()">
                        <img class="w-6" src="<?php echo get_template_directory_uri() ?>/assets/images/icon/bars.svg" />
                    </div>
                    <div class="navbar hidden sm:block">
                        <ul class="fi-menu">
                            <?php
                            $menu_args = array(
                                'menu' => 'main-menu',
                                'items_wrap' => '<ul id="%1$s" class="%2$s fi-menu">%3$s</ul>',
                                'add_li_class'  => 'item'
                            );
                            wp_nav_menu($menu_args);
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="mobile-menu bg-gray-100 mb-5 hidden" id="myLinks">
                    <?php
                    $menu_args = array(
                        'menu' => 'main-menu',
                        'items_wrap' => '<ul id="%1$s" class="%2$s fi-menu">%3$s</ul>',
                        'add_li_class'  => 'item'
                    );
                    wp_nav_menu($menu_args);
                    ?>
                </div>
            </div>
        </header>