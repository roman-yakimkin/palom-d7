<div class="palom-multi-date-widget" id="palom-multi-date-widget-<?php print $field_name; ?>">
    <div class="row">
        <select class="form-control form-select" name="date_type">
            <option value="select_dates"><?php print t('Select dates'); ?></option>
            <option value="by_demand"><?php print t('By demand'); ?></option>
            <option value="by_picking"><?php print t('By group picking'); ?></option>
        </select>
    </div>
    <div class="row select-dates">
        <div class="palom-multi-date-listbox col-xs-3">
            <select class="form-control form-select"  name="sel_tour_dates" size="13">
            </select>
        </div>
        <div class="palom-multi-date-buttons col-xs-3">
            <div>
                <button class="add-date btn btn-default form-control">
                    <?php print t('Add'); ?>
                </button>
                <button class="remove-date btn btn-default form-control">
                    <?php print t('Remove'); ?>
                </button>
            </div>
        </div>
        <div class="palom-multi-date-calendar col-xs-6">
        </div>
    </div>
</div>
