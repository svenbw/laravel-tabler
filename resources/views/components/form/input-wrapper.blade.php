@props(['label', 'name', 'value', 'placeholder' => null, 'col' => null])
@php
	$isInvalid = isset($errors) && $errors->has($name);
	$prependText = $attributes->get('prepend-text');
	$appendText = $attributes->get('append-text');
	$cols = is_string($col) ? join(' ', array_map(fn($col) => 'col-'.$col, explode(' ', $col))) : '';
@endphp
<div @class(['mb-3', $cols])>
	<label @class(['form-label', 'required' => $attributes->has('required')]) for={{ $name }}>{{ $label }}</label>
	@if($prependText || $appendText)
		<div class="input-group input-group-flat">
		@if($prependText)
			<span class="input-group-text">
				{{ $prependText }}
			</span>
		@endif
	@endif
	{{ $slot }}
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
