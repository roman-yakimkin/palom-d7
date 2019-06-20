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
    @isset($content['field_author_display'])
    <div class="row">
        <div class="hidden-xs col-sm-4 col-md-2 panel-element-label">
            Опубликован
        </div>
        <div class="col-xs-12 col-sm-8 col-md-10">
            <span class="date_review">{!! date('d.m.Y', $created) !!}</span>, автор - <span class="author-review">{!! render($content['field_author_display']) !!}</span>
        </div>
    </div>
    @endisset
    @isset($content['field_services'])
        <div class="row">
            <div class="hidden-xs col-sm-4 col-md-2 panel-element-label">
                Организатор
            </div>
            <div class="col-xs-12 col-sm-8 col-md-10">
                {!! render($content['field_services']) !!}
            </div>
        </div>
    @endisset
    @isset($content['body'])
    <div class="row">
        <div class="col col-xs-12">
            {!! render($content['body']) !!}
        </div>
    </div>
    @endisset
    @isset($content['field_places'])
    <div class="row">
        <div class="hidden-xs col-sm-4 col-md-2 panel-element-label">
            Святые места
        </div>
        <div class="col-xs-12 col-sm-8 col-md-10">
            {!! render($content['field_places']) !!}
        </div>
    </div>
    @endisset
</article>
