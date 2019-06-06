(function ($) {

  Drupal.behaviors.palom_photogallery_size = {
    attach: function(context, settings) {
      console.log(settings);
      $(window).resize(function(evt){
        var w = $(window).width();
        console.log(w);
        if (w < 1500){
          $('a .autodialog .photogallery').attr('data-dialog-width', '500');
        }
        else {
          $('a .autodialog .photogallery').attr('data-dialog-width', '1000');
        }
      })

    }
  };
}(jQuery));
