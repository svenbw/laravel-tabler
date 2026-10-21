@props(['label', 'name', 'value', 'col' => null, 'placeholder' => null, 'readonly' => null, 'disabled' => null, 'autosize' => false])
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
	$errorKey = Form::errorKey($name);
	$isInvalid = isset($errors) && $errors->has($errorKey);
	$cols = Form::colClass($col);
@endphp
<div @class(['mb-3', $cols])>
	<label @class(['form-label', 'required' => $attributes->has('required')]) for={{ $name }}>{{ $label }}</label>
	<textarea
		type="text"
		@class(['form-control', 'is-invalid' => $isInvalid])
		name="{{ $name }}"
		id="{{ $name }}"
		{{ $attributes->whereStartsWith('wire:') }}
		@if($autosize) x-data x-init="autosize($el)" @endif
		@if($placeholder) placeholder="{{ $placeholder }}" @endif
		@if($readonly) readonly @endif
		@if($disabled) disabled @endif
	>@isset($value){{ $value }}@endisset</textarea>
	@if($isInvalid)
		<div class="invalid-feedback d-block">{{ join(', ', $errors->get($errorKey)) }}</div>
	@endif
</div>
