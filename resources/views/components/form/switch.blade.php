@props(['label', 'name', 'value' => 1, 'col' => null, 'readonly' => null, 'disabled' => null])
@php
    $checked = (($attributes->get('checked') === 1) || ($attributes->get('checked') === true)) ? 'checked' : '';
    $cols = is_string($col) ? join(' ', array_map(fn($col) => 'col-'.$col, explode(' ', $col))) : '';
@endphp
<div @class(['mb-3', $cols])>
    <label class="form-check form-switch" for="{{ $name }}">
        <input
            class="form-check-input"
            type="checkbox"
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $attributes->whereStartsWith('wire:') }}
            value="{{ $value }}"
            {{ $checked }}
        >
        <span class="form-check-label">{{ $label }}</span>
    </label>
</div>
