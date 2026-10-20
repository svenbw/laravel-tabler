@props(['label', 'name', 'value' => 1, 'checked' => false, 'col' => null, 'disabled' => null])
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
	$cols = Form::colClass($col);
	$errorKey = Form::errorKey($name);
	$isInvalid = isset($errors) && $errors->has($errorKey);
	$checked = old($errorKey) !== null ? (string) old($errorKey) === (string) $value : filter_var($checked, FILTER_VALIDATE_BOOL);
@endphp
<div @class(['mb-2', $cols])>
    <label class="form-check" for="{{ $name }}">
        <input
            type="checkbox"
            @class(['form-check-input', 'is-invalid' => $isInvalid])
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ $attributes->whereStartsWith(['wire:', 'x-', '@']) }}
            @checked($checked)
            @disabled($disabled)
        />
        <span class="form-check-label">{{ $label }}</span>
    </label>
    @if($isInvalid)
        <div class="invalid-feedback d-block">{{ join(', ', $errors->get($errorKey)) }}</div>
    @endif
</div>
