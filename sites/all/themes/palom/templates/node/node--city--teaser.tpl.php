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
        <div class="col col-xs-12">
            @foreach(['field_geo'] as $index)
                @isset($content[$index])
                <div class="row">
                    <div class="col-xs-4 col-md-3 col-lg-2 panel-element-label">
                        {!! $content[$index]['#title'] !!}
                    </div>
                    <div class="col-xs-8 col-md-9 col-lg-10">
                        {!! render($content[$index]) !!}
                    </div>
                </div>
                @endisset
            @endforeach
            @if (!empty($content['body']))
            {!! render($content['body']) !!}
            @endif
        </div>
    </div>
</article>
