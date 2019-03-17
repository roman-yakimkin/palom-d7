<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup templates
 */
?>
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
        <h1 class="page-header">{{ $title }}</h1>
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
