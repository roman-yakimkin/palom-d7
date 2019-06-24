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
                <h5>Основная информация</h5>
                @foreach(['field_place_type', 'field_city', 'field_place_url'] as $index)
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
        <div class="col col-md-6 col-md-pull-6">
            <div class="infoblock">
                {!! render($content['body']) !!}
            </div>
        </div>
    </div>
</article>
