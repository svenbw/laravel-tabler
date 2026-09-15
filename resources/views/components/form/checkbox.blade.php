@props(['label', 'name', 'value', 'col' => null])
@php
	$cols = is_string($col) ? join(' ', array_map(fn($col) => 'col-'.$col, explode(' ', $col))) : '';
@endphp
<div @class(['mb-2', $cols])>
    <label class="form-check" for="{{ $name }}">
        <input type="checkbox" class="form-check-input" id="{{ $name }}" name="{{ $name }}" />
        <span class="form-check-label">{{ $label }}</span>
    </label>
</div>
