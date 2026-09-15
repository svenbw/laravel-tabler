@props(['label', 'name', 'value', 'col' => null, 'placeholder' => null, 'readonly' => null, 'disabled' => null])
@php
	$isInvalid = isset($errors) && $errors->has($name);
	$cols = is_string($col) ? join(' ', array_map(fn($col) => 'col-'.$col, explode(' ', $col))) : '';
@endphp
<div @class(['mb-3', $cols])>
	<label @class(['form-label', 'required' => $attributes->has('required')]) for={{ $name }}>{{ $label }}</label>
	<textarea
		type="text"
		@class(['form-control', 'is-invalid' => $isInvalid])
		name="{{ $name }}"
		id="{{ $name }}"
		{{ $attributes->whereStartsWith('wire:') }}
		@if($placeholder) placeholder="{{ $placeholder }}" @endif
		@if($readonly) readonly @endif
		@if($disabled) disabled @endif
	>@isset($value){{ $value }}@endisset</textarea>
	@if($isInvalid)
		<div class="invalid-feedback">{{ join(',', $errors->get($name)) }}</div>
	@endif
</div>
