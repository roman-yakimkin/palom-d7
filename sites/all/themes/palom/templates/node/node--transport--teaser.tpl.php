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
    <div class="row row-cost">
        @isset($content['field_avg_cost_display'])
            <div class="hidden-xs col-sm-4 col-md-2 panel-element-label">
                Стоимость
            </div>
            <div class="col-xs-12 col-sm-8 col-md-10">
        <span class="cost-value">
        {!! render($content['field_avg_cost_display']) !!}
        </span>
                <span class="cost-label">
        ({!! $content['field_avg_cost_display']['#title'] !!})
        </span>
            </div>
        @endisset
    </div>
    <div class="row row-info">
        <div class="col col-xs-12 col-md-6">
            @foreach(['field_city', 'field_address'] as $index)
                @isset($content[$index])
                    <div class="row">
                        <div class="hidden-xs col-sm-4 panel-element-label">
                            {!! $content[$index]['#title'] !!}
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            {!! render($content[$index]) !!}
                        </div>
                    </div>
                @endisset
            @endforeach
        </div>
        <div class="col col-md-6">
            @foreach(['field_phones', 'field_site_url'] as $index)
                @isset($content[$index])
                    <div class="row">
                        <div class="hidden-xs col-sm-4 panel-element-label">
                            {!! $content[$index]['#title'] !!}
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            {!! render($content[$index]) !!}
                        </div>
                    </div>
                @endisset
            @endforeach
        </div>
    </div>
</article>
