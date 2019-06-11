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
    @if (!empty($content['field_gallery']))
        <div class="row row-photos">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body photos-container">
                        @for($i=0; $i<8; $i++)
                            @isset($content['field_gallery'][$i])
                                <a href="/photogallery/{{ $node->nid }}" class="autodialog photogallery photo-{{$i+1}}"
                                   data-dialog-width="80%"
                                   data-dialog-resizable="false"
                                   data-dialog-draggable="false"
                                >
                                    {!! render($content['field_gallery'][$i]) !!}
                                </a>
                            @endisset
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6 col-md-push-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Информация о владельце
                </div>
                <div class="panel-body">
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
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Стоимость
                </div>
                <div class="panel-body">
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
            </div>
            @isset($content['field_files'])
                <div class="panel panel-default visible-md visible-lg visible-xl">
                    <div class="panel-heading">
                        Файлы
                    </div>
                    <div class="panel-body">
                        {!! render($content['field_files']) !!}
                    </div>
                </div>
            @endisset
            @isset($content['field_places'])
                <div class="panel panel-default visible-md visible-lg visible-xl">
                    <div class="panel-heading">
                        Близлежащие святые места
                    </div>
                    <div class="panel-body">
                        {!! render($content['field_places']) !!}
                    </div>
                </div>
            @endisset
        </div>
        <div class="col-md-6 col-md-pull-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Описание
                </div>
                <div class="panel-body">
                    {!! render($content['body']) !!}
                </div>
            </div>
            @isset($content['field_places'])
                <div class="panel panel-default visible-xs visible-sm">
                    <div class="panel-heading">
                        Близлежащие святые места
                    </div>
                    <div class="panel-body">
                        {!! render($content['field_places']) !!}
                    </div>
                </div>
            @endisset
            @isset($content['field_files'])
                <div class="panel panel-default visible-xs visible-sm">
                    <div class="panel-heading">
                        Файлы
                    </div>
                    <div class="panel-body">
                        {!! render($content['field_files']) !!}
                    </div>
                </div>
            @endisset
        </div>
    </div>
</article>
