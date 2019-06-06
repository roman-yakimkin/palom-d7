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
                    @foreach([$content['field_geo'], $content['field_site_url']] as $field)
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
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Описание
                </div>
                <div class="panel-body">
                    {!! render($content['body']) !!}
                </div>
            </div>
        </div>
    </div>
</article>
