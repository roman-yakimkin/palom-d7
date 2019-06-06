<?php

function palom_preprocess_node(&$vars){
//  kpr($vars);
  if (isset($vars['field_gallery'])){
    $cnt = count($vars['field_gallery']);
    drupal_add_js(['palom_gallery_count' => $cnt], 'setting');
    drupal_add_js(drupal_get_path('theme', 'palom').'/js/photogallery-size.js');
  }
}
