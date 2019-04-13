// Auxillary JS - functions for palomniki.su

(function ($) {

  Drupal.palom = {};

  // LGet last nid of node with a defined type
  Drupal.palom.getLastNid = function(node_type){
    $.get('/palom-get-info/get-last-nid/'+node_type, function(response){
    })
  }

}(jQuery));
