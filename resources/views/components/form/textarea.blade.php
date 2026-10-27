@props(['label' => null, 'name', 'id' => null, 'value', 'rows' => null, 'col' => null, 'placeholder' => null, 'readonly' => null, 'disabled' => null, 'required' => false, 'autosize' => false, 'hint' => null])
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $errorKey = Form::errorKey($name);
    $isInvalid = isset($errors) && $errors->has($errorKey);
    $cols = Form::colClass($col);
    $id ??= $name;
    $describedBy = Form::describedBy($id, $isInvalid, (bool) $hint);
@endphp
<div {{ $attributes->only('class')->class([Form::margin($attributes->get('class')), $cols]) }}>
    @if(filled($label))
        <label @class(['form-label', 'required' => $required]) for="{{ $id }}">{{ $label }}</label>
    @endif
    <textarea
        @class(['form-control', 'is-invalid' => $isInvalid])
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->whereStartsWith(['wire:', 'x-', '@', 'aria-'])->except(['aria-describedby', 'aria-required', 'aria-invalid']) }}
        @isset($rows) rows="{{ $rows }}" @endisset
        @if($autosize) @unless($attributes->has('x-data')) x-data @endunless x-autosize @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        @if($required) aria-required="true" @endif
        @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
        @if($isInvalid) aria-invalid="true" @endif
    >{{ $value ?? '' }}</textarea>
    @include('tabler::components.partials.form-feedback', ['id' => $id, 'errorKey' => $errorKey])
</div>
