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
