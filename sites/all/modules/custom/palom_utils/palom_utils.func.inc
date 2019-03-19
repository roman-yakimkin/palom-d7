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