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
            <div class="infoblock border-bottom">
            @foreach(['field_services', 'field_tour_dates', 'field_direction', 'field_route', 'field_transport', 'field_duration', 'field_cities_from'] as $index)
                @isset($content[$index])
                <div class="row">
                    <div class="col-xs-12 col-sm-3 panel-element-label">
                        {!! $content[$index]['#title'] !!}
                    </div>
                    <div class="col-xs-12 col-sm-9">
                        {!! render($content[$index]) !!}
                    </div>
                </div>
                @endisset
            @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-6 col-md-push-6">
            <div class="infoblock">
                @isset($content['field_cost_display'])
                <div class="row">
                    <div class="col-xs-12">
                        от <span class="cost-value">{!! render($content['field_cost_display']) !!}</span>
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
            @isset($content['field_places'])
            <div class="infoblock visible-md visible-lg visible-xl">
                <h5>Cвятые места</h5>
                {!! render($content['field_places']) !!}
            </div>
            @endisset
        </div>
        <div class="col col-md-6 col-md-pull-6">
            <div class="infoblock">
                {!! render($content['body']) !!}
            </div>
            @isset($content['field_places'])
                <div class="infoblock visible-xs visible-sm">
                    <h5>Святые места</h5>
                    {!! render($content['field_places']) !!}
                </div>
            @endisset
        </div>
    </div>
</article>
