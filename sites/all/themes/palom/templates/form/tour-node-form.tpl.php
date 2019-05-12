<ul class="nav nav-tabs">
    <li class="active">
        <a data-toggle="tab" href="#form-tab-main">{{ t('Main information') }}</a>
    </li>
    <li>
        <a data-toggle="tab" href="#form-tab-cities-from">Пункты отправления</a>
    </li>
    <li>
        <a data-toggle="tab" href="#form-tab-descr">{{ t('Description') }}</a>
    </li>
    <li>
        <a data-toggle="tab" href="#form-tab-cost">{{ t('Cost') }}</a>
    </li>
    <li>
        <a data-toggle="tab" href="#form-tab-places">{{ t('Sacred places') }}</a>
    </li>
    <li>
        <a data-toggle="tab" href="#form-tab-additional">{{ t('Additional info') }}</a>
    </li>
</ul>
<div class="tab-content">
    <div id="form-tab-main" class="tab-pane fade in active">
        <div class="row">
            <div class="col-sm-6">
                {!! render($form['field_services']) !!}
            </div>
            <div class="col-sm-6">
                {!! render($form['field_direction']) !!}
            </div>
        </div>
        {!! render($form['title']) !!}
        <div class="row">
            <div class="col-md-8 col-lg-6">
                {!! render($form['field_tour_dates']) !!}
            </div>
            <div class="col-sm-12 col-lg-6">
                {!! render($form['field_transport']) !!}
                {!! render($form['field_route']) !!}
                {!! render($form['field_duration']) !!}
            </div>
        </div>
    </div>
    <div id="form-tab-cities-from" class="tab-pane">
        {!! render($form['field_cities_from']) !!}
    </div>
    <div id="form-tab-descr" class="tab-pane">
        {!! render($form['body']) !!}
    </div>
    <div id="form-tab-cost" class="tab-pane">
        {!! render($form['field_cost']) !!}
        {!! render($form['field_cost_comment']) !!}
    </div>
    <div id="form-tab-places" class="tab-pane">
        {!! render($form['field_places']) !!}
    </div>
    <div id="form-tab-additional" class="tab-pane">
        {!! render($form['field_owners']) !!}
        {!! render($form['additional_settings']) !!}
    </div>
</div>
<div class="row tab-actions">
    {!! render($form['actions']) !!}
</div>
{!! drupal_render_children($form) !!}
