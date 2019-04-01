(function ($) {

  Drupal.behaviors.palom_multi_date_widget = {
    attach: function(context, settings) {
      var aData = settings.palom_multi_date_widget;
      console.log(settings);
      var field_name = Object.keys(aData)[0];
      var date_type;

      var dates_saved = '';

      // Add a date to the list
      function addDateToList($wrapper){
        var currentDate = $wrapper.find('.palom-multi-date-calendar').datepicker("getDate");

        // Add a date into lists if it is ansent.
        var formattedDate = sprintf("%02d.%02d.%04d", currentDate.getDate(), currentDate.getMonth()+1, currentDate.getFullYear());
        var formattedDateValue = sprintf("%04d-%02d-%02d", currentDate.getFullYear(), currentDate.getMonth()+1, currentDate.getDate() );

        // If count of inputed dates not more than max count

        var $select = $wrapper.find(".palom-multi-date-listbox select");
        var max_dates = $select.attr("data-cardinality");
        var cnt_dates = $select[0].options.length;

        var date_in_list = $wrapper.find(".palom-multi-date-listbox select option[value='"+formattedDateValue+"']");

        if ((max_dates==-1) || (max_dates>cnt_dates)){

          // If data is not it the list
          if (date_in_list.length == 0)
            $wrapper.find(".palom-multi-date-listbox select ").append($("<option value='"+formattedDateValue+"'>"+formattedDate+"</option>"));
        }
        else
        {
          // Display a warning dialog with max count of datas
          $('<div id="palom-multi-date-dialog">Уже добавлено максимальное количество дат ('+max_dates+') для данного поля</div>').dialog({
            'title': 'Ошибка',
            'modal': true,
            buttons: {
              "Закрыть": function(){
                $(this).dialog('close');
              }
            }
          });
        }

        setHiddenField($wrapper);
      }

      // Remove date from the list
      function removeDateFromList($wrapper){
        $wrapper.find(".palom-multi-date-listbox select :selected").remove();
        setHiddenField($wrapper);
      }

      // Set the hidden wield with the dates
      function setHiddenField($wrapper){
        var $hiddenField = $wrapper.parent('div').find('input[type=hidden]');
        var aDatesTmp = '';

        $wrapper.find(".palom-multi-date-listbox select option").each(function(){
          aDatesTmp += this.value+' ';
        })

        $hiddenField.val(aDatesTmp);
      }

      // Change select dates list value
      function changeSelectDates($wrapper, date_type){
        var $hiddenField = $wrapper.parent('div').find('input[type=hidden]');

        switch (date_type){
          case 'select_dates':
            $("#palom-multi-date-widget-"+field_name+" .select-dates").slideDown();
            $hiddenField.val(dates_saved);
            if (dates_saved == ''){
              $wrapper.find(".palom-multi-date-listbox select").empty();
            }
            dates_saved = '';
            break;
          case 'by_demand':
            $("#palom-multi-date-widget-"+field_name+" .select-dates").slideUp();
            if (dates_saved != '')
              dates_saved = $hiddenField.val();
            $hiddenField.val('2500-01-01');
            break;
          case 'by_picking':
            $("#palom-multi-date-widget-"+field_name+" .select-dates").slideUp();
            if (dates_saved != '')
              dates_saved = $hiddenField.val();
            $hiddenField.val('2600-01-01');
            break;
        }
      }

      // Set select dates
      function setSelectDates(aDates){
         var str = aDates[0];
         var $select = $("#palom-multi-date-widget-"+field_name+" select[name=date_type]");
         var $dates_area = $("#palom-multi-date-widget-"+field_name+" .select-dates");

         // By demand
         if (str.search('2500-01-01') != -1){
            $select.val('by_demand');
            $dates_area.hide();
         }

         // By picking
         else if (str.search('2600-01-01') != -1){
           $select.val('by_picking');
           $dates_area.hide();
         }

         // Some real dates
         else {
           $select.val('select_dates');
           $dates_area.show();
         }
      }

      setSelectDates(aData[field_name]['dates']);

      $('body').once('init-data').each(function(){

        var timePrev=0, timePrev2 = 0;

        $('.palom-multi-date-calendar').datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: 'dd.mm.yy',
          onSelect: function(date, inst){
            var timeNow = $.now();
            var $wrapper = $(this).closest('.palom-multi-date-widget');

            // Perform mouse doucle click
            if ((timeNow - timePrev < 500) && (timePrev - timePrev2 > 500)){
              addDateToList($wrapper);
            }
            timePrev2 = timePrev;
            timePrev = timeNow;
          }
        });

        for (var aFieldName in aData){
          var aDates = aData[aFieldName]['dates'];

          for (var i=0; i<aDates.length; i++){
            var aDate = new Date(aDates[i]);
            var formattedDate = sprintf("%02d.%02d.%04d", aDate.getDate(), aDate.getMonth()+1, aDate.getFullYear());
            var formattedDateValue = sprintf("%04d-%02d-%02d", aDate.getFullYear(), aDate.getMonth()+1, aDate.getDate() );
            $("#palom-multi-date-widget-"+aFieldName+" .palom-multi-date-listbox select").append($("<option value='"+formattedDateValue+"'>"+formattedDate+"</option>"));
          };
          var $wrapper = $('#palom-multi-date-widget-'+aFieldName);
          setHiddenField($wrapper);
          $("#palom-multi-date-widget-"+aFieldName+" .palom-multi-date-listbox select").attr("data-cardinality", aData[aFieldName]['cardinality']);
        }

        $('select[name=date_type]', context).on('change', function(evt){
          var $wrapper = $('#palom-multi-date-widget-'+field_name);
          date_type = evt.target.value;
          changeSelectDates($wrapper, date_type);
        });

        // Double click to delete a date
        $(".palom-multi-date-listbox select", context).on("dblclick", function(){
          var $wrapper = $(this).closest('.palom-multi-date-widget');
          removeDateFromList($wrapper);
        });

        // Adding a date via press a button
        $(".palom-multi-date-widget .add-date", context).on("click", function(){
          var $wrapper = $(this).closest('.palom-multi-date-widget');
          addDateToList($wrapper);
          return false;
        });

        // Removing a date via press a button
        $(".palom-multi-date-widget .remove-date", context).on("click", function(){
          var $wrapper = $(this).closest('.palom-multi-date-widget');
          removeDateFromList($wrapper);
          return false;
        });
      });
    }
  };

}(jQuery));
