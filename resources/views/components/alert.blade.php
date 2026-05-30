@props(['type' => 'success'])

@php
    $class = match ($type) {
        'warning' => 'alert-warning',
        default => 'alert-success',
    };
@endphp

<div {{ $attributes->merge(['class' => $class, 'role' => 'alert']) }}>
    {{ $slot }}
</div>
