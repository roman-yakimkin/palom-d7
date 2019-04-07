<?php

define('ALL_REGIONS', -1);

/*
 * Get all the countries
 */
function palom_utils_get_countries(){
  $countries = taxonomy_get_tree(3, 0, 1);
  return $countries;
}

function palom_utils_get_regions($country_id){
  $regions = taxonomy_get_tree(3, $country_id, 1);
  return $regions;
}

function palom_utils_get_country_default(){
  return 2;
}

/*
 * Get cities by country and region
 */
function palom_utils_get_cities($country_id, $region_id = ALL_REGIONS){
  $query = new EntityFieldQuery();
  $query->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', 'city')
    ->propertyCondition('status', NODE_PUBLISHED)
    ->fieldCondition('field_geo', 'country_id', $country_id);
  if ($region_id != ALL_REGIONS)
    $query->fieldCondition('field_geo', 'region_id', $region_id);
  $result = $query->execute();

  $cities = [];
  if ($result != [])
    $cities = node_load_multiple(array_keys($result['node']));

  return $cities;
}

/*
 * Get count of regions of the country
 */
function palom_utils_region_count($country_id) {
  $regions = taxonomy_get_children($country_id);
  return count($regions);
}

/*
 * Get region and city array by the country
 */
function palom_utils_get_region_city_by_geo($geo_id){

  // An array of regions and cities by a country
  if (palom_utils_region_count($geo_id)>0){

    $q_regions = db_select('taxonomy_term_data', 'ttd');
    $q_regions->addField('ttd', 'tid', 'elem_id');
    $q_regions->addField('ttd', 'name', 'title');
    $q_regions->addJoin('inner', 'taxonomy_term_hierarchy', 'tth', 'ttd.tid = tth.tid');
    $q_regions->condition('tth.parent', $geo_id);
    $q_regions->orderBy('ttd.name');

    $results = $q_regions->execute()->fetchAll();
    foreach ($results as $key => &$value){

      // Recursion of a list
      $value->children = palom_utils_get_region_city_by_geo($value->elem_id);
      $value->folder = true;
      $value->type = 'region';
    }

    return $results;
  }

  // An array of cities by a region
  else
  {
    $q_cities = db_select('node');
    $q_cities->addField('node', 'nid', 'elem_id');
    $q_cities->addField('node', 'title', 'title');
    $q_cities->addField('node', 'type', 'type');

    $q_cities->addJoin('inner', 'field_data_field_geo', 'geo', 'node.nid=geo.entity_id');

    $q_cities->condition(
      db_or()
      ->condition('geo.field_geo_country_id', $geo_id)
      ->condition('geo.field_geo_region_id', $geo_id)
    );
    $q_cities->condition('node.type', 'city');

    $q_cities->orderBy('node.title');

    $results = $q_cities->execute()->fetchAll();

    return $results;
  }
}

/*
 * Get country and region data by city
 */
function palom_utils_get_geo_by_city($city_id){
  $query = db_select('field_data_field_geo', 'geo');
  $query->condition('geo.entity_type', 'node');
  $query->condition('geo.bundle', 'city');
  $query->condition('geo.entity_id', $city_id);
  $query->addJoin('left', 'taxonomy_term_data', 'ttd_c', 'geo.field_geo_country_id = ttd_c.tid');
  $query->addJoin('left', 'taxonomy_term_data', 'ttd_r', 'geo.field_geo_region_id = ttd_r.tid');
  $query->addField('ttd_c', 'name', 'country_name');
  $query->addField('ttd_r', 'name', 'region_name');

  $results = $query->execute()->fetchAll();

  foreach ($results as &$value){
    if ($value->region_name != '')
      $value->geo_str = '('.$value->country_name.', '.$value->region_name.')';
    else
      $value->geo_str = '('.$value->country_name.')';
  }

  return $results;
}