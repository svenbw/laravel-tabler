@props(['label' => null, 'name', 'id' => null, 'value' => null, 'placeholder' => null, 'tabindex' => null, 'col' => null, 'readonly' => null, 'disabled' => null, 'required' => false, 'precision' => 2, 'min' => 0, 'max' => 999999999, 'signed' => false, 'plain' => null, 'hint' => null])
@use('Svenbw\LaravelTabler\Helpers\WireModelEntangler')
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $errorKey = Form::errorKey($name);
    $isInvalid = isset($errors) && $errors->has($errorKey);
    $prependText = $attributes->get('prepend-text');
    $appendText = $attributes->get('append-text');
    $cols = Form::colClass($col);
    $id ??= $name;
    $entangler = WireModelEntangler::make($attributes);
    $plain = (bool) ($plain ?? config('tabler.decimal_plain', false));

    $formatter = new \NumberFormatter(App::getLocale(), \NumberFormatter::DECIMAL);
    $config = [
        'precision' => (int) $precision,
        'signed' => (bool) $signed,
        'min' => $signed && (float) $min === 0.0 ? -$max : $min,
        'max' => $max,
        'decimalSeparator' => $formatter->getSymbol(\NumberFormatter::DECIMAL_SEPARATOR_SYMBOL),
        'thousandsSeparator' => $formatter->getSymbol(\NumberFormatter::GROUPING_SEPARATOR_SYMBOL),
        'value' => $value,
    ];
@endphp
<div {{ $attributes->only('class')->class([Form::margin($attributes->get('class')), $cols]) }} x-data="{{ $entangler->xData('decimalInput', $config) }}">
    @if(filled($label))
        <label @class(['form-label', 'required' => $required]) for="{{ $id }}">{{ $label }}</label>
    @endif

    @if($prependText || $appendText)
        <div class="input-group input-group-flat">
        @if($prependText)
            <span class="input-group-text">{{ $prependText }}</span>
        @endif
    @endif

    <input
        type="text"
        inputmode="decimal"
        x-ref="input"
        @class(['form-control', 'is-invalid' => $isInvalid, 'ps-0' => !!$prependText, 'text-end' => !!$appendText || !!$prependText, 'pe-0' => !!$appendText])
        id="{{ $id }}"
        @unless($plain) name="{{ $name }}" @endunless
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        @if($required) aria-required="true" @endif
        @isset($tabindex) tabindex="{{ $tabindex }}" @endif
        autocomplete="off"
        wire:ignore
    >
    @if($plain)
        <input type="hidden" name="{{ $name }}" x-bind:value="value" @if($disabled) disabled @endif>
    @endif

    @if($prependText || $appendText)
        @if($appendText)
            <span class="input-group-text">{{ $appendText }}</span>
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
