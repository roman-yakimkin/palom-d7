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
        <div class="col col-md-6">
            <div class="infoblock">
                @if (!empty($content['body']))
                {!! render($content['body']) !!}
                @else
                    Пока нет описания
                @endif
            </div>
        </div>
        <div class="col col-md-6">
            <div class="infoblock">
                @foreach(['field_geo'] as $index)
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
            @if(true)
                <div class="infoblock">
                    <h5>Святые места</h5>
                    {!! views_embed_view('places_by_city', 'block_places', $node->nid) !!}
                </div>
            @endif
        </div>
    </div>
</article>
