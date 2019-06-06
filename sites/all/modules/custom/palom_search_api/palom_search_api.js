(function ($) {

  Drupal.behaviors.palom_search_api = {
    attach: function(context, settings) {

      var currency = 'rub';

      if ($.cookie('palom_search_tour_currency') != null){
        currency = $.cookie('palom_search_tour_currency');
      }
      console.log(currency);

      $('.facetapi-facetapi-currency-checkbox-links li:not(".'+currency+'") ').hide();
      $('select.palom-select-currencies').val(currency);

      $('.palom-select-currencies').on('change', function(evt){

        var currency = evt.target.value;
        $('.facetapi-facetapi-currency-checkbox-links .'+currency).show();
        $('.facetapi-facetapi-currency-checkbox-links li:not(".'+currency+'") ').hide();
//        $('.facetapi-facetapi-currency-checkbox-links .leaf input[type=checkbox]').prop('checked', false);

        var loc = window.location.href;
        var regexp = /(\/cval\/\D{3}-\d{3})/gi;
        var newloc = loc.replace(regexp, "");

//        console.log(loc);
//        console.log(newloc);
        $.cookie('palom_search_tour_currency', currency, {expires: 365});

        window.location.href = newloc;
      })
    }
  };

}(jQuery));
