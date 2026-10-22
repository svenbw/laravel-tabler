@props(['label', 'name', 'value' => '', 'col' => null, 'options' => null, 'optionGroups' => null, 'multiple' => false, 'allowEmpty' => false, 'hint' => null, 'url' => null, 'disabled' => null, 'create' => true, 'search' => true, 'dropdownParent' => null, 'settings' => []])
@use('Svenbw\LaravelTabler\Helpers\WireModelEntangler')
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
	$entangler = WireModelEntangler::make($attributes);
	$cols = Form::colClass($col);
	$id = str_replace('[]','', $name);
	$errorKey = Form::errorKey($name);
	$isInvalid = isset($errors) && $errors->has($errorKey);
	$alpineOn = $attributes->whereStartsWith(['x-on:', '@']);
	$attributes = $attributes->except(array_keys($alpineOn->all()));
	$config = [
		'value' => $value,
		'url' => $url,
		'multiple' => (bool) $multiple,
		'allowEmpty' => (bool) $allowEmpty,
		'create' => (bool) $create,
		'search' => (bool) $search,
		'dropdownParent' => $dropdownParent,
		'settings' => (object) $settings,
	];
@endphp
<div @class(['mb-3', $cols])>
	<label @class(['form-label', 'required' => $attributes->has('required')]) for={{ $id }}>{{ $label }}</label>
	<div @class(['is-invalid' => $isInvalid]) {{ $alpineOn }}>
		<div wire:ignore x-data="select(@js($config){{ $entangler->hasModel() ? ', '.$entangler->entangle() : '' }})">
			<select
				x-ref="select"
				@if($multiple)
					multiple="multiple" 
				@endif
				name="{{ $name }}"
				id="{{ $id }}"
				@class(['is-invalid' => $isInvalid])
				@if($attributes->has('readonly')) readonly @endif
				@if($disabled || $attributes->has('disabled')) disabled @endif
			>
				@if(isset($optionGroups) && is_array($optionGroups))
					@foreach($optionGroups as $group)
						<optgroup label="{{ $group['name'] }}">
							@foreach($group['options'] as $val => $opt)
								<option value="{{ $val }}" 
									@if(is_scalar($value) && (string) $value === (string) $val) selected @endif
									@if(is_array($opt) && array_key_exists('icon', $opt))
									data-icon="{{ $opt['icon'] }}"
									@endif>
									{{ is_array($opt) ? $opt['text'] : $opt }}
								</option>
							@endforeach
						</optgroup>
					@endforeach
				@elseif($options && is_array($options))
					@foreach($options as $val => $opt)
						<option value="{{ $val }}" 
							@if(is_scalar($value) && (string) $value === (string) $val) selected @endif
							@if(is_array($opt) && array_key_exists('icon', $opt))
							data-icon="{{ $opt['icon'] }}"
							@endif>
							{{ is_array($opt) ? $opt['text'] : $opt }}
						</option>
					@endforeach
				@endif
			</select>
		</div>
	</div>
	@if($isInvalid)
		<div class="invalid-feedback d-block">{{ join(', ', $errors->get($errorKey)) }}</div>
	@endif
	@if($hint)
		<small class="form-hint">{{ $hint }}</small>
	@endif
</div>
