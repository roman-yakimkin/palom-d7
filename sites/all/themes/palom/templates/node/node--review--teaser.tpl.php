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
            {!! date('d.m.Y', $created) !!}
        </div>
        @foreach(['field_author_display', 'field_services', 'body', 'field_places'] as $index)
            @isset($content[$index])
                <div class="col col-xs-12">
                    {!! render($content[$index]) !!}
                </div>
            @endisset
        @endforeach
    </div>
</article>
