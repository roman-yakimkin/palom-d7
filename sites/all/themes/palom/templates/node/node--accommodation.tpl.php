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
        @foreach(['field_city', 'field_address', 'field_phones', 'field_site_url', 'field_cost_str', 'field_cost_comment', 'body', 'field_gallery', 'field_places', 'field_files'] as $index)
            @isset($content[$index])
                @php
                    $adv_style = "col-info";
                    if (in_array($index, ['body', 'field_cost_comment', 'field_gallery']))
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
