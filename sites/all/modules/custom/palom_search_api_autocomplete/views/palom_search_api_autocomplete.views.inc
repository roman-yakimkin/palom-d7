<?php

/**
 * Implements hook_views_data_alter().
 */
function palom_search_api_autocomplete_views_data_alter(&$data) {
  $data['search_api_index_tour']['geo_ac']['filter']['handler'] = 'SearchApiViewsHandlerFilterTextAutocomplete';
}