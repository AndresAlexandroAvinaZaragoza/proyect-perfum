@props([
    'name',
    'width' => 20,
    'height' => 20
])

@php
    $path = resource_path("views/components/icons/{$name}.svg");
@endphp

@if(file_exists($path))
    {!! str_replace(
        '<svg',
        '<svg width="'.$width.'" height="'.$height.'" fill="currentColor" '.$attributes,
        file_get_contents($path)
    ) !!}
@endif