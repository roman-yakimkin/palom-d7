<article id="node-{{ $node->nid }}" class="{{ $classes }} clearfix" {{ $attributes }}>
    @if ((!$page && !empty($title)) || !empty($title_prefix) || !empty($title_suffix) || $display_submitted )
        <header>
            {!! render($title_prefix) !!}
            @if (!$page && !empty($title))
                <h2 {{ $title_attributes }}><a href="{{ $node_url }}">{!! $title !!}</a></h2>
            @endif
            {!! render($title_suffix) !!}
            @if ($display_submitted)
                <span class="submitted">
        {{ $user_picture }}
                    {{ $submitted }}
      </span>
            @endif
        </header>
    @endif
    <div class="row">
        <div class="col col-md-6 col-md-push-6">
            <div class="infoblock">
                <h5>Информация о владельце</h5>
                @foreach(['field_city', 'field_address', 'field_phones', 'field_site_url'] as $index)
                    @isset($content[$index])
                        <div class="row">
                            <div class="col-xs-4 col-md-12 col-lg-4 panel-element-label">
                                {!! $content[$index]['#title'] !!}
                            </div>
                            <div class="col-xs-8 col-md-12 col-lg-8">
                                {!! render($content[$index]) !!}
                            </div>
                        </div>
                    @endisset
                @endforeach
            </div>
            @isset($content['field_gallery'])
                <div class="infoblock visible-lg visible-xl photos-container">
                    <h5>Фотогалерея</h5>
                    {!! render($content['field_gallery']) !!}
                </div>
            @endisset
            @isset($content['field_files'])
                <div class="infoblock visible-md visible-lg visible-xl">
                    <h5>Файлы</h5>
                    {!! render($content['field_files']) !!}
                </div>
            @endisset
            @isset($content['field_places'])
                <div class="infoblock visible-md visible-lg visible-xl">
                    <h5>Близлежащие святые места</h5>
                    {!! render($content['field_places']) !!}
                </div>
            @endisset
        </div>
        <div class="col col-md-6 col-md-pull-6">
            <div class="infoblock">
                <h5>Стоимость</h5>
                @isset($content['field_avg_cost_display'])
                    <div class="row">
                        <div class="col-xs-12">
                        <span class="cost-value">
                        {!! render($content['field_avg_cost_display']) !!}
                        </span>
                            <span class="cost-label">
                        ({!! $content['field_avg_cost_display']['#title'] !!})
                        </span>
                        </div>
                    </div>
                @endisset
                @isset($content['field_cost_comment'])
                    <div class="row">
                        <div class="col-xs-12">
                            {!! render($content['field_cost_comment']) !!}
                        </div>
                    </div>
                @endisset
            </div>
            <div class="infoblock">
                {!! render($content['body']) !!}
            </div>
            @isset($content['field_gallery'])
                <div class="infoblock visible-xs visible-sm photos-container">
                    <h5>Фотогалерея</h5>
                    {!! render($content['field_gallery']) !!}
                </div>
            @endisset
            @isset($content['field_places'])
                <div class="infoblock visible-xs visible-sm">
                    <h5>Близлежащие святые места</h5>
                    {!! render($content['field_places']) !!}
                </div>
            @endisset
            @isset($content['field_files'])
                <div class="infoblock visible-xs visible-sm">
                    <h5>Файлы</h5>
                    {!! render($content['field_files']) !!}
                </div>
            @endisset
        </div>
    </div>
</article>
