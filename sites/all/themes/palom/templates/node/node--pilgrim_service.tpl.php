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
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Основная информация
                </div>
                <div class="panel-body">
                @foreach([$content['field_city'], $content['field_address'], $content['field_phones'], $content['field_site_url']] as $field)
                    <div class="row">
                        <div class="col-xs-4 col-md-12 panel-element-label">
                            {!! $field['#title'] !!}
                        </div>
                        <div class="col-xs-8 col-md-12">
                            {!! render($field) !!}
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            <div class="panel panel-default hidden-xs hidden-sm">
                <div class="panel-heading">
                    Файлы
                </div>
                <div class="panel-body">
                    {!! render($content['field_files']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Описание
                </div>
                <div class="panel-body">
                    {!! render($content['body']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="autodialog" href="/photogallery/{{$node->nid}}">Фотографии</a>
                </div>
                <div class="panel-body">
                @for($i=0; $i<4; $i++)
                   @if (isset($content['field_gallery'][$i]))
                        <a href="/photogallery/{{ $node->nid }}" class="autodialog photogallery"
                           data-dialog-width="80%"
                           data-dialog-resizable="false"
                           data-dialog-draggable="false"
                          >
                            {!! render($content['field_gallery'][$i]) !!}
                        </a>
                   @endif
                @endfor
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Файлы
                </div>
                <div class="panel-body">
                    {!! render($content['field_files']) !!}
                </div>
            </div>
        </div>
    </div>
</article>
