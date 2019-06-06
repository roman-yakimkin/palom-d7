<div class="{{ $classes }}">
  {!! render($title_prefix) !!}
  @if ($title)
    {{ $title }}
  @endif
  {!! render($title_suffix) !!}
  @if ($header)
    <div class="view-header">
      {!! $header !!}
    </div>
  @endif

  @if ($exposed)
    <div class="view-filters">
      {!! $exposed !!}
    </div>
  @endif

  @if ($attachment_before)
    <div class="attachment attachment-before">
      {!! $attachment_before !!}
    </div>
  @endif

  @if ($rows)
    <div class="view-content">
      {!! $rows !!}
    </div>
  @elseif ($empty)
    <div class="view-empty">
      {!! $empty !!}
    </div>
  @endif

  @if ($pager)
    {!! $pager !!}
  @endif

  @if ($attachment_after)
    <div class="attachment attachment-after">
      {!! $attachment_after !!}
    </div>
  @endif

  @if ($more)
    {!! $more !!}
  @endif

  @if ($footer)
    <div class="view-footer">
      {!! $footer !!}
    </div>
  @endif

  @if ($feed_icon)
    <div class="feed-icon">
      {!! $feed_icon !!}
    </div>
  @endif

</div>