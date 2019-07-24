<article id="node-{{ $node->nid }}" class="{{ $classes }} clearfix" {{ $attributes }}>
    @if ((!$page && !empty($title)) || !empty($title_prefix) || !empty($title_suffix) || $display_submitted )
        <header>
            {!! render($title_prefix) !!}
            @if (!$page && !empty($title))
                <h2 {!! $title_attributes !!}><a href="{{ $node_url }}">{!! $title !!}</a></h2>
            @endif
            {!! render($title_suffix) !!}
        </header>
    @endif
    <div class="row">
        <div class="col col-xs-12 col-info pub-date">
            <div class="icon"></div>
            <div class="field-values">{!! date('d.m.Y', $created) !!}</div>
        </div>
        <div class="col col-xs-12 col-info field-author">
            <div class="icon"></div>
            <div class="field-values">{!! $name !!}</div>
        </div>
        @foreach(['body', 'field_tags'] as $index)
            @isset($content[$index])
                @php
                    $adv_style = "col-info";
                    if (in_array($index, ['body', 'field_gallery']))
                       $adv_style = "col-text";
                @endphp
                <div class="col col-xs-12 {{$adv_style}} {{str_replace('_', '-', $index)}}">
                    @if ($adv_style == 'col-info')
                        <div class="icon"></div>
                    @endif
                    <div class="field-values">
                        {!! render($content[$index]) !!}
                    </div>
                </div>
            @endisset
        @endforeach
    </div>
</article>
