@props([
    'variant' => 'primary',
    'tag' => 'button',
    'href' => null,
])

@php
    $variantClass = match ($variant) {
        'secondary' => 'btn-secondary',
        'danger' => 'btn-danger',
        'sm' => 'btn-sm',
        default => 'btn-primary',
    };
    $class = 'btn '.$variantClass;
@endphp

@if ($tag === 'a')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>{{ $slot }}</a>
@else
    <button type="{{ $attributes->get('type', 'button') }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </button>
@endif
