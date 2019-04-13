<div class="palom-tree-city-widget" id="palom-tree-city-widget-{{ $field_name }}">
    <div class="row">
        <div class="col-xs-5">
            <select class="form-control form-select" name="sel_countries">
            </select>
        </div>
        <div class="col-xs-2">
            <a class="autodialog btn btn-default"
               data-dialog-ajax="true"
               data-dialog-ajax-disable-redirect="true"
               data-dialog-width="750"
               data-dialog-title="{{ t('New city') }}"
               data-dialog-field="{{ $field_name }}"
               href="/node/add/city">{{ t('New city') }}</a>
        </div>

    </div>
    <div class="row">
        <div class="palom-tree-city-left col-xs-5">
            <div class="palom-tree-city-tree" id="palom-tree-city-{{ $field_name }}">
            </div>
        </div>
        <div class="palom-tree-city-buttons col-xs-2">
            <div>
                <button class="add-city btn btn-default form-control">{{ t('Add') }}</button>
                <button class="remove-city btn btn-default form-control">{{ t('Remove') }}</button>
            </div>
        </div>
        <div class="palom-tree-city-listbox col-xs-5">
            <select class="form-control form-select" name="sel_cities" size="10">
            </select>
        </div>
    </div>
</div>