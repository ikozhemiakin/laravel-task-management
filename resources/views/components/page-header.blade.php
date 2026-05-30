@props([
    'title',
    'description' => null,
])

<header {{ $attributes->merge(['class' => 'page-header']) }}>
    <div class="page-header-text">
        <h1 class="page-title">{{ $title }}</h1>
        @if ($description)
            <p class="page-description">{{ $description }}</p>
        @endif
    </div>
    @if (isset($actions))
        <div class="page-header-actions">
            {{ $actions }}
        </div>
    @endif
</header>
