<header id="navbar" role="banner" class="{{ $navbar_classes }}">
  <div class="{{ $container_class }}">
    <div class="navbar-header">
      @if ($logo)
        <a class="logo navbar-btn pull-left" href="{{ $front_page }}" title="{{ t('Home') }}">
          <img src="{{ $logo }}" alt="{{ @t('Home') }}" />
        </a>
      @endif

      @if (!empty($site_name))
        <a class="name navbar-brand" href="{{ $front_page }}" title="{{ t('Home') }}">{{ $site_name }}</a>
      @endif

      @if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation']))
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
          <span class="sr-only">{{ t('Toggle navigation') }}</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      @endif
    </div>

    @if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation']))
      <div class="navbar-collapse collapse" id="navbar-collapse">
        <nav role="navigation">
          @if (!empty($primary_nav))
            {!! render($primary_nav) !!}
          @endif
          @if (!empty($secondary_nav))
            {!!  render($secondary_nav) !!}
          @endif
          @if (!empty($page['navigation']))
            {!! render($page['navigation']) !!}
          @endif
        </nav>
      </div>
    @endif
  </div>
</header>

<div class="main-container {{ $container_class }}">

  <header role="banner" id="page-header">
    @if (!empty($site_slogan))
      <p class="lead">{{ $site_slogan }}</p>
    @endif

    {!! render($page['header']) !!}
  </header> <!-- /#page-header -->

  <div class="row">

    @if (!empty($page['sidebar_first']))
      <aside class="col-sm-3" role="complementary">
        {!! render($page['sidebar_first']) !!}
      </aside>  <!-- /#sidebar-first -->
    @endif

    <section {!! $content_column_class !!}>
      @if (!empty($page['highlighted']))
        <div class="highlighted jumbotron">{!! render($page['highlighted']) !!}</div>
      @endif
      @if (!empty($breadcrumb))
          {!! $breadcrumb !!}
      @endif
      <a id="main-content"></a>
      {!! render($title_prefix) !!}
      @if (!empty($title))
        <h1 class="page-header">{!! $title !!}</h1>
      @endif
      {!! render($title_suffix) !!}
      {!! $messages !!}
      @if (!empty($tabs))
        {!! render($tabs) !!}
      @endif
      @if (!empty($page['help']))
        {!! render($page['help']) !!}
      @endif
      @if (!empty($action_links))
        <ul class="action-links">{!! render($action_links) !!}</ul>
      @endif
      {!! render($page['content']) !!}
    </section>

    @if (!empty($page['sidebar_second']))
      <aside class="col-sm-3" role="complementary">
        {!! render($page['sidebar_second']) !!}
      </aside>  <!-- /#sidebar-second -->
    @endif

  </div>
</div>

@if (!empty($page['footer']))
  <footer class="footer {{ $container_class }}">
    {!! render($page['footer']) !!}
  </footer>
@endif
