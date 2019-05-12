(function ($) {


  Drupal.behaviors.palom_tree_place_widget = {

    attach: function(context, settings) {

      var timePrev=0, timePrev2 = 0;
      var placesWidgetId = '';
      var fieldName = settings.palom_tree_place_widget.field_name;

      // Get the active node
      function getActiveNode(){
        var node = $('#palom-tree-place-'+fieldName).fancytree("getActiveNode");
        return node;
      }

      // Add a geoobject into the list
      function addPlaceToListBox($wrapper, context){

        // Если количество введенных дат не превышает максимальное
        var $select = $wrapper.find(".palom-tree-place-listbox select");
        var max_geo = $select.attr("data-cardinality");
        var cnt_geo = $select[0].options.length;
        var node = getActiveNode();

        var geo_in_list = $wrapper.find(".palom-tree-place-listbox select option[value='"+node.data.elem_id+"']");

        if ((max_geo==-1) || (max_geo>cnt_geo)){

          // Если это святое место отсутствует в списке
          if (geo_in_list.length == 0){
            $select.append($("<option value='"+node.data.elem_id+"'>"+node.title+" "+node.data.geo_str+"</option>"));

          }
        }
        else
        {
          // Display a warning dialog with max count of dates
          $('<div id="palom-tree-select-dialog">Уже добавлено максимальное количество святых мест ('+max_geo+') для данного поля</div>').dialog({
            'title': 'Error',
            'modal': true,
            buttons: {
              "Close": function(){
                $(this).dialog('close');
              }
            }
          });
        }

        setPlaceHiddenField($wrapper);
      }

      // Remove a geoobject from the list
      function removePlaceFromListBox($wrapper, context){
        $wrapper.find(".palom-tree-place-listbox select :selected", context).remove();
        setPlaceHiddenField($wrapper);
      }

      // Fill a hidden fields with values
      function setPlaceHiddenField($wrapper){

        var $hiddenField = $wrapper.parent('div').find('input[type=hidden]');
        var aGeoTmp = '';

        $wrapper.find(".palom-tree-place-listbox select option").each(function(){
          aGeoTmp += this.value+' ';
        });

        $hiddenField.val(aGeoTmp);
      }

      $('body').once('initiale-tree-place-widget').each(function(){

        $('#palom-tree-place-'+fieldName).fancytree({
          source:[],
          dblclick: function(evt, data){
            var node = data.node;
            if (node.data.type == 'place'){
              var $wrapper = $('#palom-tree-place-widget-'+fieldName);
              addPlaceToListBox($wrapper, context);
            }
          },
        });

        var aData = settings.palom_tree_place_widget;

        // Initialization of a country list
        var countries = aData.countries;

        $.each(countries, function(index, value){
          $('select[name="sel_countries_place"]', context).append('<option value="'+value.tid+'">'+value.name+'</option>');
        });

        // Russia by default
        $('select[name="sel_countries_place"] option[value="2"]', context).attr('selected', 'selected');
        UpdateTreePlace(2, fieldName);

        $('select[name="sel_countries_place"]', context).on('change', function(evt){
          UpdateTreePlace($(this).val(), fieldName);
        });

        // Initialization of the added city list
        for (var aFieldName in aData){
          var aObjects = aData[aFieldName]['objects'];

          placesWidgetId = "#palom-tree-place-widget-"+aFieldName;

          $.each(aObjects, function(index, obj){
            $(placesWidgetId + " .palom-tree-place-listbox select").append($("<option value='"+obj.elem_id+"'>"+obj.name+"</option>"));
          })

          var $wrapper = $('#palom-tree-place-widget-'+aFieldName);
          setPlaceHiddenField($wrapper);
          $(placesWidgetId + " .palom-tree-place-listbox select").attr("data-cardinality", aData[aFieldName]['cardinality']);
        }
      });

      // Remove an element by double mouse clicking
      $(".palom-tree-place-listbox select", context).on("dblclick", function(){
        var $wrapper = $('#palom-tree-place-widget-'+fieldName);
        removePlaceFromListBox($wrapper, context);
      });

      // Add a city via press a button
      $(".add-place", context).on("click", function(){
        var node = getActiveNode();
        if (node.data.type == 'place'){
          var $wrapper = $('#palom-tree-place-widget-'+fieldName);
          addPlaceToListBox($wrapper, context);
        }
        return false;
      });

      // Remove a city via press a button
      $(".remove-place", context).on("click", function(){
        var $wrapper = $('#palom-tree-place-widget-'+fieldName);
        removePlaceFromListBox($wrapper, context);
        return false;
      });
    }
  };

  // Update a tree according to id country
  function UpdateTreePlace(country_id, field_name, after_dialog_closed = false){
    $.get('/palom-get-info/get-region-city-place-by-geo/'+country_id, function(treeData){
      var tree = $('#palom-tree-place-'+field_name).fancytree('getTree');
      tree
          .reload(treeData)
          .done(function(){
            if (after_dialog_closed){
              $.get('/palom-get-info/get-last-nid/place', function(response){
                var node = tree.getNodeByKey("node_" + response);
                node.setActive();
              })
            }
          });
    })
  }

  Drupal.ajax.prototype.commands.updatePlaceWidget = function(ajax, response, status){
    $('select[name="sel_countries_place"]').val(response.country_id);
    console.log(response);
    UpdateTreePlace(response.country_id, response.field_name, true);
  }


}(jQuery));
