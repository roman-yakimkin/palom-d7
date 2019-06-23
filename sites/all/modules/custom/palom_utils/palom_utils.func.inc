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
  if ($result != []){
    $cities = node_load_multiple(array_keys($result['node']));
  }

  return $cities;
}

/*
 * Get count of regions of the country
 */
function palom_utils_region_count($country_id) {
  $regions = taxonomy_get_children($country_id);
  return count($regions);
}

function palom_utils_places_by_city($city_id){
  $query = db_select('node');
  $query->addField('node', 'nid', 'elem_id');
  $query->addField('node', 'title', 'title');
  $query->addJoin('inner', 'field_data_field_city', 'fc', 'node.nid = fc.entity_id');
  $query->condition('fc.field_city_city_id', $city_id);
  $query->condition('node.type', 'place');
  $query->condition('node.status', 1);
  $query->orderBy('node.title');

  $results = $query->execute()->fetchAll();
  foreach($results as &$row){
    $row->key = 'node_'.$row->elem_id;
    $row->type = 'place';
    $row->geo_str = palom_utils_get_geo_by_place($row->elem_id)[0]->geo_str;
  }

  return $results;
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
      $value->key = 'term_'.$value->elem_id;
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

    foreach ($results as $key => &$value){
      $value->key = 'node_'.$value->elem_id;
    }

    return $results;
  }
}

/*
 * Get the region, city and place structure for JS Tree by geo_id
 */
function palom_utils_get_region_city_place_by_geo($country_id){
  $geo = palom_utils_get_region_city_by_geo($country_id);

  // Сycling through countries and regions
  if (palom_utils_region_count($country_id)>0){
    $geo_tmp = [];

    foreach ($geo as $key_1 => &$one_geo){

      foreach ($one_geo->children as $key_2 => &$one_city){
        $places = palom_utils_places_by_city($one_city->elem_id);

        if ($places == []){

          // Exclude a city without sacred placres
          unset($one_geo->children[$key_2]);
        }
        else
        {
          $one_city->children = $places;
          $one_city->folder = true;
        }
      }
      $one_geo->children = array_values($one_geo->children);

      // Add sacred places without cities
      $places_without_city = palom_utils_places_without_city($one_geo->elem_id);
      foreach($places_without_city as $one_place){
        $one_geo->children[] = $one_place;
      };

      // Repack an array
      if (sizeof($one_geo->children)>0){
        $one_geo->folder = true;
        $geo_tmp[] = $one_geo;
      }
    }
    $geo = $geo_tmp;
  }
  else

    // Cycling through separated cities
  {
    foreach ($geo as $key => &$one_city){
      $places = palom_utils_places_by_city($one_city->elem_id);
      if ($places == []){
        unset($geo[$key]);
      }
      else
      {
        $one_city->children = $places;
        $one_city->folder = true;
      }
    };

    $places_without_city = palom_utils_places_without_city($country_id);
    foreach($places_without_city as $one_place){
      $geo[] = $one_place;
    };

    $geo = array_values($geo);
  }

  return $geo;
}

/*
 * Get country and region data by city
 */
function palom_utils_get_geo_by_city($city_id, $field_name){
  $query = db_select('field_data_'.$field_name, 'geo');
  $query->condition('geo.entity_type', 'node');
  $query->condition('geo.bundle', 'city');
  $query->condition('geo.entity_id', $city_id);
  $query->addJoin('left', 'taxonomy_term_data', 'ttd_c', 'geo.'.$field_name.'_country_id = ttd_c.tid');
  $query->addJoin('left', 'taxonomy_term_data', 'ttd_r', 'geo.'.$field_name.'_region_id = ttd_r.tid');
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

function palom_utils_get_geo_by_place($place_id, $field_name = 'field_city'){
  $query = db_select('field_data_'.$field_name, 'geo');
  $query->condition('geo.entity_type', 'node');
  $query->condition('geo.bundle', 'place');
  $query->condition('geo.entity_id', $place_id);
  $query->addJoin('left', 'taxonomy_term_data', 'ttd_c', 'geo.'.$field_name.'_country_id = ttd_c.tid');
  $query->addJoin('left', 'taxonomy_term_data', 'ttd_r', 'geo.'.$field_name.'_region_id = ttd_r.tid');
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

/*
 * Get places list without a city
 */
function palom_utils_places_without_city($geo_id){

  $query = db_select('node');
  $query->addField('node', 'nid', 'elem_id');
  $query->addField('node', 'title', 'title');
  $query->addJoin('inner', 'field_data_field_city', 'fc', 'node.nid = fc.entity_id');
  $query->condition(
    db_or()
      ->condition('fc.field_city_country_id', $geo_id)
      ->condition('fc.field_city_region_id', $geo_id)
  );

//  $query->condition('fc.field_city_country_id', $geo_id);
  $query->condition('fc.field_city_city_id', 0);
  $query->condition('node.type', 'place');
  $query->condition('node.status', 1);
  $query->orderBy('node.title');

  $results = $query->execute()->fetchAll();
  foreach($results as &$row){
    $row->key = 'node_'.$row->elem_id;
    $row->type = 'place';
    $row->geo_str = palom_utils_get_geo_by_place($row->elem_id)[0]->geo_str;
  }

  return $results;
}

/*
 * Get max nid of defined node type
 */
function palom_utils_get_last_nid($node_type){
  $query = db_select('node');
  $query->addExpression('MAX(nid)');
  $query->condition('type', $node_type);
  $max_nid = $query->execute()->fetchField();

  return $max_nid;
}

function palom_utils_get_entity_id($entity, $type){
  switch ($type) {
    case 'node':
      return $entity->nid;
    case 'user':
      return $entity->uid;
    case 'taxonomy_term':
      return $entity->tid;
    case 'taxonomy_vocabulary':
      return $entity->vid;
  }
}

function palom_utils_get_month_name($month_number){
  $months = [
    'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'
  ];

  return $months[$month_number-1];
}

/*
 * Get full titles of city (including city types)
 */
function palom_utils_get_city_title_multiple(array $city_ids){
  $query = db_select('node');
  $query->addField('node', 'nid');
  $query->addField('node', 'title');
  $query->leftJoin('field_data_field_city_type', 'city_type', 'node.nid = city_type.entity_id');
  $query->leftJoin('taxonomy_term_data', 'ttd', 'city_type.field_city_type_target_id = ttd.tid');
  $query->addField('ttd', 'name', 'c_type');
  $query->condition('nid', $city_ids, 'IN');
  $results = $query->execute()->fetchAll();

  $output = [];
  foreach ($results as $value){
    if (is_null($value->c_type)){
      $output[$value->nid] = $value->title;
    }
    else {
      $output[$value->nid] = $value->c_type." ".$value->title;
    }
  }

  return $output;
}

/*
 * Get title of a city including city type
 */
function palom_utils_get_city_title($city_id){
  $output = palom_utils_get_city_title_multiple([$city_id]);
  return $output[$city_id];
}