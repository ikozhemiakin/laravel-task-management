@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'hint' => null,
])

<div>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if ($required) required @endif
        {{ $attributes->merge(['class' => 'form-input' . ($errors->has($name) ? ' form-input-error' : '')]) }}
    >
    @error($name)
        <p class="form-error">{{ $message }}</p>
    @enderror
    @if ($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif
</div>
