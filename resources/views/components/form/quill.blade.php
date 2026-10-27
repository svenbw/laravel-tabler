@props(['label', 'name', 'value' => null, 'placeholder' => null, 'tabindex' => null, 'col' => null, 'readonly' => null, 'disabled' => null, 'required' => false, 'height' => 200, 'theme' => 'snow', 'toolbar' => null, 'hint' => null])
@use('Svenbw\LaravelTabler\Helpers\WireModelEntangler')
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $errorKey = Form::errorKey($name);
    $isInvalid = isset($errors) && $errors->has($errorKey);
    $cols      = Form::colClass($col);
    $editorId  = 'quill_' . str_replace(['.', '[', ']'], '_', $name);
    $inputId   = $editorId . '_input';

    if ($disabled || $readonly) {
        $resolvedToolbar = false;
    } else {
        $defaultToolbar = [
            [['header' => [1, 2, 3, false] ]],
            ['bold', 'italic', 'underline', 'strike'],
            [[ 'list' => 'ordered' ], [ 'list' => 'bullet' ]],
            ['link', 'image'],
            ['clean']
        ];
        $resolvedToolbar = $toolbar ?? $defaultToolbar;
    }

    $entangler = WireModelEntangler::make($attributes);
    $config = [
        'theme' => $theme,
        'placeholder' => $placeholder ?? '',
        'readOnly' => (bool) $readonly,
        'disabled' => (bool) $disabled,
        'autofocus' => $attributes->has('autofocus'),
        'toolbar' => $resolvedToolbar,
        'model' => $entangler->modelName(),
    ];
@endphp

<div
    @class(['mb-3', $cols])
    x-data="{{ $entangler->xData('quillEditor', $config) }}"
>
    <label @class(['form-label', 'required' => $required]) for="{{ $inputId }}">
        {{ $label }}
    </label>

    <div wire:ignore>
        <div
            id="{{ $editorId }}"
            x-ref="editor"
            @class(['quill-editor', 'is-invalid' => $isInvalid])
            style="height: {{ (int) $height }}px;"
        ></div>
    </div>

    <input
        type="hidden"
        id="{{ $inputId }}"
        x-ref="input"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $attributes->whereStartsWith('wire:')->filter(fn ($value, $key) => ! str_starts_with($key, 'wire:model')) }}
        {{ $attributes->whereStartsWith('data-') }}
    >

    @if($isInvalid)
        <div class="invalid-feedback d-block">{{ join(', ', $errors->get($errorKey)) }}</div>
    @endif
    @if($hint)
        <small class="form-hint">{{ $hint }}</small>
    @endif
</div>
