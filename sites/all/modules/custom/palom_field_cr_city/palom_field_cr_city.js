(function ($) {

  Drupal.behaviors.palom_field_cr_city = {
    attach: function(context, settings) {
      $('button[name="new_city_add"]', context).addClass('disabled');

      $('input[name="new_city_name"]', context).keyup(function(evt){

        if (evt.target.value == ""){
          $('button[name="new_city_add"]', context).addClass('disabled');
        }
        else{
          $('button[name="new_city_add"]', context).removeClass('disabled');
        }
      })
    }
  };

}(jQuery));
