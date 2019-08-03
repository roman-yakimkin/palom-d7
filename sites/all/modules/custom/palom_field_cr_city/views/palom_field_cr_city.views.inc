<?php
/**
 * Implements hook_field_views_data().
 */
function palom_field_cr_city_field_views_data($field) {
}

/**
 * Implements hook_field_views_data_alter().
 */
function palom_field_cr_city_field_views_data_alter(&$result, $field, $module) {
}

/**
 * Implements hook_field_views_data_views_data_alter().
 */
function palom_field_cr_city_field_views_data_views_data_alter(&$data, $field) {
  $field_name = $field['field_name'];
  $data['field_data_'.$field_name][$field_name.'_country_id']['relationship'] = [
    'handler' => 'views_handler_relationship',
    'base' => 'taxonomy_term_data',
    'base field' => 'tid',
    'label' => t('Country term from !field_name', array('!field_name' => $field_name)),
  ];
  $data['field_data_'.$field_name][$field_name.'_region_id']['relationship'] = [
    'handler' => 'views_handler_relationship',
    'base' => 'taxonomy_term_data',
    'base field' => 'tid',
    'label' => t('Region term from !field_name', array('!field_name' => $field_name)),
  ];
  $data['field_data_'.$field_name][$field_name.'_city_id']['relationship'] = [
    'handler' => 'views_handler_relationship',
    'base' => 'node',
    'base field' => 'nid',
    'label' => t('City node from !field_name', array('!field_name' => $field_name)),
  ];
}
