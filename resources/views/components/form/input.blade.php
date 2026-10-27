@props(['label' => null, 'name', 'id' => null, 'value', 'placeholder' => null, 'type' => null, 'tabindex' => null, 'col' => null, 'readonly' => null, 'disabled' => null, 'required' => false, 'hint' => null])
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $errorKey = Form::errorKey($name);
    $isInvalid = isset($errors) && $errors->has($errorKey);
    $prependText = $attributes->get('prepend-text');
    $appendText = $attributes->get('append-text');
    $type = $attributes->has('password') ? 'password' : $type ?? 'text';
    $cols = Form::colClass($col);
    $id ??= $name;
@endphp
<div {{ $attributes->only('class')->class([Form::margin($attributes->get('class')), $cols]) }}>
    @if(filled($label))
        <label @class(['form-label', 'required' => $required]) for="{{ $id }}">{{ $label }}</label>
    @endif
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
        id="{{ $id }}"
        {{ $attributes->whereStartsWith(['wire:', 'x-', '@']) }}
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($attributes->has('autonumeric')) data-auto-numeric @endif
        @if($attributes->has('autofocus')) autofocus @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        @if($required) aria-required="true" @endif
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
        <div class="invalid-feedback d-block">{{ join(', ', $errors->get($errorKey)) }}</div>
    @endif
    @if($hint)
        <small class="form-hint">{{ $hint }}</small>
    @endif
</div>
