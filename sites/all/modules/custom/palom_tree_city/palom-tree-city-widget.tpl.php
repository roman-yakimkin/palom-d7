<div class="palom-tree-city-widget" id="palom-tree-city-widget-{{ $field_name }}">
    <div class="row">
        <div class="col-xs-5">
            <select class="form-control form-select" name="sel_countries">
            </select>
        </div>
    </div>
    <div class="row">
        <div class="palom-tree-city-left col-xs-5">
            <div class="palom-tree-city-tree" id="palom-tree-city-{{ $field_name }}">
            </div>
        </div>
        <div class="palom-tree-city-buttons col-xs-3">
            <button class="add-city btn btn-default form-control">{{ t('Add a city') }}</button>
            <button class="remove-city btn btn-default form-control">{{ t('Remove a city') }}</button>
        </div>
        <div class="palom-tree-city-listbox col-xs-4">
            <select class="form-control form-select" name="sel_cities" size="10">
            </select>
        </div>
    </div>
</div>