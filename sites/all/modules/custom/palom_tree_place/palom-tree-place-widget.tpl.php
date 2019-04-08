<div class="palom-tree-place-widget" id="palom-tree-place-widget-{{ $field_name }}">
    <div class="row">
        <div class="col-xs-5">
            <select class="form-control form-select" name="sel_countries_place">
            </select>
        </div>
    </div>
    <div class="row">
        <div class="palom-tree-place-left col-xs-5">
            <div class="palom-tree-place-tree" id="palom-tree-place-{{ $field_name }}">
            </div>
        </div>
        <div class="palom-tree-place-buttons col-xs-2">
            <div>
                <button class="add-place btn btn-default form-control">{{ t('Add') }}</button>
                <button class="remove-place btn btn-default form-control">{{ t('Remove') }}</button>
            </div>
        </div>
        <div class="palom-tree-place-listbox col-xs-5">
            <select class="form-control form-select" name="sel_cities" size="10">
            </select>
        </div>
    </div>
</div>