<?php

function palom_preprocess_node(&$vars){
//  kpr($vars);
  $node_type_suggestion_key = array_search('node__' . $vars['type'], $vars['theme_hook_suggestions']);
  if ($node_type_suggestion_key !== FALSE) {
    $node_view_mode_suggestion = 'node__' . $vars['type'] . '__' . $vars['view_mode'];
    array_splice($vars['theme_hook_suggestions'], $node_type_suggestion_key + 1, 0, array($node_view_mode_suggestion));
  }

  if (isset($vars['field_author'][0]['value'])){
    if ($vars['field_author'][0]['value'] != ''){
      $vars['content']['field_author_display'] = $vars['field_author'][0]['value'];
    }
    else {
      $vars['content']['field_author_display'] = $vars['name'];
    }
  };

  foreach (['field_avg_cost', 'field_cost'] as $field_name){
    if (isset($vars[$field_name][0])){
      $field_info = field_info_instance('node',  $field_name, $vars['type']);

      $cur_value = $vars[$field_name][0]['first'];
      $cur_name = $vars[$field_name][0]['second'];
      $currencies = _palom_currency_get_currencies();
      $vars['content'][$field_name.'_display'] = [
        '#title' => $field_info['description'],
        '#markup' => number_format($cur_value,0,'', '').' '.$currencies[$cur_name]['short_sing'],
      ];
    }
  }

  if ($vars['type'] == 'city'){
    $vars['title'] = palom_utils_get_city_title($vars['nid']);
  }

  if (isset($vars['field_gallery'])){
//    $cnt = count($vars['field_gallery']);
//    drupal_add_js(['palom_gallery_count' => $cnt], 'setting');
//    drupal_add_js(drupal_get_path('theme', 'palom').'/js/photogallery-size.js');
  }
}

function palom_preprocess_html(&$vars){
//  kpr($vars);
}

function palom_preprocess_page(&$vars){
//  kpr($vars);
}

function palom_preprocess_views_view(&$vars){
  $masonry_views = [
    'geo__page_places' => '12',
    'geo__page_cities' => '123',
    'geo__page_services' => '12',
    'geo__page_accommodation' => '12',
    'geo__page_feeding' => '12',
    'geo__page_transport' => '12',

    'data_by_place__page_reviews' => '12',
    'data_by_place__page_accommodation' => '12',
    'data_by_place__page_feeding' => '12',
    'data_by_place__page_transport' => '12',

    'places_by_city__page_places' => '12',
    'places_by_city__page_services' => '12',
    'places_by_city__page_accommodation' => '12',
    'places_by_city__page_feeding' => '12',
    'places_by_city__page_transport' => '12',

    'search_tour__page_search_tour' => '12',

    'blog__page' => '12',

    'taxonomy_term__page' => '12',
  ];

  $current_view_name = $vars['name'].'__'.$vars['display_id'];

  foreach($masonry_views as $key => $value){
    if ($current_view_name == $key){
      $vars['views_content_classes'] = 'row masonry'.$value;
      $vars['views_content_attr'] = 'data-columns';
    }
  }
//  kpr($current_view_name);
}

function palom_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  $options = !empty($element['#localized_options']) ? $element['#localized_options'] : array();

  // Check plain title if "html" is not set, otherwise, filter for XSS attacks.
  $title = empty($options['html']) ? check_plain($element['#title']) : filter_xss_admin($element['#title']);

  // Ensure "html" is now enabled so l() doesn't double encode. This is now
  // safe to do since both check_plain() and filter_xss_admin() encode HTML
  // entities. See: https://www.drupal.org/node/2854978
  $options['html'] = TRUE;

  $href = $element['#href'];
  $attributes = !empty($element['#attributes']) ? $element['#attributes'] : array();

  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';

      // Generate as standard dropdown.
      $title .= ' <span class="caret"></span>';
      $attributes['class'][] = 'dropdown';
      $options['attributes']['class'][] = 'dropdown-toggle';
      $options['attributes']['data-toggle'] = 'dropdown';
    }
  }

  if (isset($element['#below_custom']) && ($element['#below_custom'] != "")) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below_custom']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      unset($element['#below_custom']['#theme_wrappers']);
      $sub_menu = '<div class="dropdown-menu below-custom">' . drupal_render($element['#below_custom']) . '</div>';

      // Generate as standard dropdown.
      $title .= ' <span class="caret"></span>';
      $attributes['class'][] = 'dropdown';
      $options['attributes']['class'][] = 'dropdown-toggle';
      $options['attributes']['data-toggle'] = 'dropdown';
    }

//    kpr($element);
  }


  return '<li' . drupal_attributes($attributes) . '>' . l($title, $href, $options) . $sub_menu . "</li>\n";
}

function palom_preprocess_menu_link(&$vars) {
  $vars['element']['#attributes']['class'][] = 'menu-item-' . $vars['element']['#original_link']['mlid'];
  $vars['theme_hook_suggestions'][] = 'menu_link__' . $vars['element']['#original_link']['mlid'];
}

function palom_menu_link__1345(array $variables){

  $user_state = palom_users_get_user_state();
  $date_current = new DateTime();

  if ($user_state['expire'] > $date_current->format('Y-m-d')){
    $date_expire = DateTime::createFromFormat('Y-m-d', $user_state['expire']);
    $interval = $date_expire->diff($date_current);

    $days = '';
    if ($interval->days < 20){
      $days = " ($interval->days дн.)";
    }

    $content = l('Продлить премиум'.$days, 'premium');
  }
  else {
    $content = l('Купить премиум', 'premium');
  }

  $attributes = !empty($element['#attributes']) ? $element['#attributes'] : array();

  return '<li' . drupal_attributes($attributes) . '>' . $content . "</li>\n";
}

