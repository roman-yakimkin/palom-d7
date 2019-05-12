<ul class="nav nav-tabs">
    <li class="active">
        <a data-toggle="tab" href="#form-tab-1">{{ t('Main information') }}</a>
    </li>
    <li>
        <a data-toggle="tab" href="#form-tab-2">{{ t('Description') }}</a>
    </li>
    <li>
        <a data-toggle="tab" href="#form-tab-3">{{ t('Photogallery') }}</a>
    </li>
    <li>
        <a data-toggle="tab" href="#form-tab-4">{{ t('Files') }}</a>
    </li>
    <li>
        <a data-toggle="tab" href="#form-tab-5">{{ t('Additional info') }}</a>
    </li>
</ul>
<div class="tab-content">
    <div id="form-tab-1" class="tab-pane fade in active">
        {!! render($form['field_city']) !!}
        {!! render($form['title']) !!}
        {!! render($form['field_address']) !!}
        {!! render($form['field_phones']) !!}
        {!! render($form['field_site_url']) !!}
    </div>
    <div id="form-tab-2" class="tab-pane">
        {!! render($form['body']) !!}
    </div>
    <div id="form-tab-3" class="tab-pane">
        {!! render($form['field_gallery']) !!}
    </div>
    <div id="form-tab-4" class="tab-pane">
        {!! render($form['field_files']) !!}
    </div>
    <div id="form-tab-5" class="tab-pane">
        {!! render($form['field_owners']) !!}
        {!! render($form['additional_settings']) !!}
    </div>
</div>
<div class="tab-actions">
    {!! render($form['actions']) !!}
</div>
