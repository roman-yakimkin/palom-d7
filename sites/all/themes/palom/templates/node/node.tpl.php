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
            {!! $user_picture !!}
            {!! $submitted !!}
          </span>
        @endif
    </header>
  @endif
  @php
  // Hide comments, tags, and links now so that we can render them later.
  hide($content['comments']);
  hide($content['links']);
  hide($content['field_tags']);
  @endphp
  {!! render($content) !!}
  @php
      $field_tags = render($content['field_tags']);
      $links = render($content['links']);
  @endphp
  @if ($field_tags || $links)
    <footer>
      {!! $field_tags !!}
      {!! $links !!}
    </footer>
  @endif
  {!! render($content['comments']) !!}
</article>
