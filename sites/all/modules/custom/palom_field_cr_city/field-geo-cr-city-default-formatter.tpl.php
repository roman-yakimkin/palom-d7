@if (!empty($element['city_url']))
    {!! l($element['city_name'], $element['city_url']) !!}
    @else
    {!! $element['city_name'] !!}
@endif
({{ $element['country_name'] }}@if (!empty($element['region_name'])), {{ $element['region_name'] }}@endif)

