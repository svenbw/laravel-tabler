@props(['label', 'name', 'id' => null, 'value', 'rows' => null, 'col' => null, 'placeholder' => null, 'readonly' => null, 'disabled' => null, 'autosize' => false])
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
	$errorKey = Form::errorKey($name);
	$isInvalid = isset($errors) && $errors->has($errorKey);
	$cols = Form::colClass($col);
	$id ??= $name;
@endphp
<div @class(['mb-3', $cols])>
	<label @class(['form-label', 'required' => $attributes->has('required')]) for="{{ $id }}">{{ $label }}</label>
	<textarea
		@class(['form-control', 'is-invalid' => $isInvalid])
		name="{{ $name }}"
		id="{{ $id }}"
		{{ $attributes->whereStartsWith(['wire:', 'x-', '@']) }}
		@isset($rows) rows="{{ $rows }}" @endisset
		@if($autosize) @unless($attributes->has('x-data')) x-data @endunless x-autosize @endif
		@if($placeholder) placeholder="{{ $placeholder }}" @endif
		@if($readonly) readonly @endif
		@if($disabled) disabled @endif
	>@isset($value){{ $value }}@endisset</textarea>
	@if($isInvalid)
		<div class="invalid-feedback d-block">{{ join(', ', $errors->get($errorKey)) }}</div>
	@endif
</div>
