@props([
    'label',
    'name',
    'required' => false,
    'placeholder' => null,
])

<div>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        @if ($required) required @endif
        {{ $attributes->merge(['class' => 'form-input' . ($errors->has($name) ? ' form-input-error' : '')]) }}
    >
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>
    @error($name)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
