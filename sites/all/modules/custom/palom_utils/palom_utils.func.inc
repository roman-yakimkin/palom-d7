<?php

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