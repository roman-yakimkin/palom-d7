<?php

function palom_preprocess_node(&$vars){
//  kpr($vars);
  if (isset($vars['field_avg_cost'])){
    $field_info = field_info_instance('node',  'field_avg_cost', $vars['type']);

    $cur_value = $vars['field_avg_cost'][0]['first'];
    $cur_name = $vars['field_avg_cost'][0]['second'];
    $currencies = _palom_currency_get_currencies();
    $vars['content']['field_avg_cost_display'] = [
      '#title' => $field_info['description'],
      '#markup' => number_format($cur_value,0,'', '').' '.$currencies[$cur_name]['short_sing'],
    ];
  }

  if (isset($vars['field_gallery'])){
    $cnt = count($vars['field_gallery']);
    drupal_add_js(['palom_gallery_count' => $cnt], 'setting');
    drupal_add_js(drupal_get_path('theme', 'palom').'/js/photogallery-size.js');
  }
}
