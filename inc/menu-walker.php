<?php
/*
** /inc/menu-walker.php
*/

if (!defined('ABSPATH')) {
  exit;
}

class Footer_Menu_Walker extends Walker_Nav_Menu
{
  function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
  {
    $is_current = in_array('current-menu-item', $item->classes) || in_array('current_page_item', $item->classes);

    $aria = $is_current ? ' aria-current="page"' : '';

    $icon_class = $is_current
      ? 'opacity-100'
      : 'opacity-0 group-hover:opacity-100';

    $output .= '<li class="item group inline-flex w-fit items-center gap-2">';
    $output .= '<i class="ph ph-arrow-right text-lg -ml-6 transition-all ' . $icon_class . '"></i>';
    $output .= '<a href="' . esc_url($item->url) . '" class="flex items-center text-white uppercase text-[15px] hover:text-primary hover:underline underline-offset-4 h-6.5 aria-[current=page]:text-primary"' . $aria . '>';
    $output .= esc_html($item->title);
    $output .= '</a></li>';
  }
}
