@props(['label', 'name', 'value', 'placeholder' => null, 'type' => null, 'tabindex' => null, 'col' => null, 'readonly' => null, 'disabled' => null])
@php
	$isInvalid = isset($errors) && $errors->has($name);
	$prependText = $attributes->get('prepend-text');
	$appendText = $attributes->get('append-text');
	$type = $attributes->has('password') ? 'password' : $type ?? 'text';
	$cols = is_string($col) ? join(' ', array_map(fn($col) => 'col-'.$col, explode(' ', $col))) : '';
@endphp
<div @class(['mb-3', $cols])>
	<label @class(['form-label', 'required' => $attributes->get('required')]) for={{ $name }}>{{ $label }}</label>
	@if($prependText || $appendText)
		<div class="input-group input-group-flat">
		@if($prependText)
			<span class="input-group-text">
				{{ $prependText }}
			</span>
		@endif
	@endif
	<input
		type="{{ $type }}"
		@class(['form-control', 'is-invalid' => $isInvalid, 'ps-0' => !!$prependText, 'text-end pe-0' => !!$appendText])
		name="{{ $name }}"
		id="{{ $name }}"
		{{ $attributes->whereStartsWith('wire:') }}
		@if($placeholder) placeholder="{{ $placeholder }}" @endif
		@if($attributes->has('readonly')) readonly @endif
		@if($attributes->has('autonumeric')) data-auto-numeric @endif
		@if($attributes->has('autofocus')) autofocus @endif
		@if($readonly) readonly @endif
		@if($disabled) disabled @endif
		@isset($tabindex) tabindex="{{ $tabindex }}" @endif
		@isset($value) value="{{ $value }}" @endisset
	>
	@if($prependText || $appendText)
		@if($appendText)
			<span class="input-group-text">
				{{ $appendText }}
			</span>
		@endif
		</div>
	@endif
	@if($isInvalid)
		<div class="invalid-feedback">{{ join(',', $errors->get($name)) }}</div>
	@endif
</div>
