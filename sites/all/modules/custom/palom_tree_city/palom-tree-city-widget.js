(function ($) {

  Drupal.behaviors.palom_tree_city_widget = {
    attach: function(context, settings) {
      var timePrev=0, timePrev2 = 0;
      var thisWidgetId = '';
      var fieldName = settings.palom_tree_city_widget.field_name;

      // Update the tree according to the country id
      function UpdateTree(country_id){
        $.get('/palom-get-info/get-region-and-city-by-geo/'+country_id, function(treeData){
          var tree = $('#palom-tree-city-'+fieldName).fancytree('getTree');
          tree.reload(treeData);
        })
      }

      // Get active node
      function getActiveNode(){
        var node = $('#palom-tree-city-'+fieldName).fancytree("getActiveNode");
        return node;
      }

      // Add a geoobject into the list
      function addGeoObjectToListBox($wrapper, context){

        // If count of inputed dates not more that max count
        var $select = $wrapper.find(".palom-tree-city-listbox select");
        var max_geo = $select.attr("data-cardinality");
        var cnt_geo = $select[0].options.length;
        var node = getActiveNode();

        var geo_in_list = $wrapper.find(".palom-tree-city-listbox select option[value='"+node.data.elem_id+"']");

        if ((max_geo==-1) || (max_geo>cnt_geo)){

          // If this settlement is absent in the list
          if (geo_in_list.length == 0)
            $select.append($("<option value='"+node.data.elem_id+"'>"+node.title+" ("+$('select[name=sel_countries] :selected', context).text()+")</option>"));
        }
        else
        {
          // Display a warning dialog with max count of dates
          $('<div id="palom-tree-select-dialog">Уже добавлено максимальное количество населенных пунктов ('+max_geo+') для данного поля</div>').dialog({
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

      // Remove a geoobject from the list
      function removeGeoObjectFromListBox($wrapper){
        $wrapper.find(".palom-tree-city-listbox select :selected").remove();
        setHiddenField($wrapper);
      }

      // Fill a hidden field with a value
      function setHiddenField($wrapper){

        var $hiddenField = $wrapper.parent('div').find('input[type=hidden]');
        var aGeoTmp = '';

        $wrapper.find(".palom-tree-city-listbox select option").each(function(){
          aGeoTmp += this.value+' ';
        })

        $hiddenField.val(aGeoTmp);
      }


      $('body').once('initiale-tree-city-widget').each(function(){

        $('#palom-tree-city-'+fieldName).fancytree({
          source:[],
          dblclick: function(evt, data){
            var node = data.node;
            var $wrapper = $('#palom-tree-city-widget-'+fieldName);
            addGeoObjectToListBox($wrapper, context);
          },
        });

        var aData = settings.palom_tree_city_widget;

        // Initialization of a country list
        var countries = aData.countries;
        $.each(countries, function(index, value){
          $('select[name="sel_countries"]', context).append('<option value="'+value.tid+'">'+value.name+'</option>');
        });

        // Россия по умолчанию
        $('select[name="sel_countries"] option[value="2"]', context).attr('selected', 'selected');
        UpdateTree(2);

        $('select[name="sel_countries"]', context).on('change', function(evt){
          UpdateTree($(this).val());
        });

        // Initialization of a city list already added
        for (var aFieldName in aData){
          var aObjects = aData[aFieldName]['objects'];
          thisWidgetId = "#palom-tree-city-widget-"+aFieldName;

          $.each(aObjects, function(index, obj){
            $(thisWidgetId + " .palom-tree-city-listbox select").append($("<option value='"+obj.elem_id+"'>"+obj.name+"</option>"));
          })

          var $wrapper = $('#palom-tree-city-widget-'+aFieldName);
          setHiddenField($wrapper);
          $(thisWidgetId + " .palom-tree-city-listbox select").attr("data-cardinality", aData[aFieldName]['cardinality']);
        }
      });

      // Remove an element by double mouse clicking
      $(".palom-tree-city-listbox select", context).on("dblclick", function(){
        var $wrapper = $('#palom-tree-city-widget-'+fieldName);
        removeGeoObjectFromListBox($wrapper, context);
      });

      // Add a city via press a button
      $(".add-city", context).on("click", function(){
        var node = getActiveNode();
        if (node.type == 'city'){
          var $wrapper = $('#palom-tree-city-widget-'+fieldName);
          addGeoObjectToListBox($wrapper, context);
        }
        return false;
      });

      // Remove a city via press a button
      $(".remove-city", context).on("click", function(){
        var $wrapper = $('#palom-tree-city-widget-'+fieldName);
        removeGeoObjectFromListBox($wrapper);
        return false;
      });
    }
  };

}(jQuery));
