@props(['label', 'name', 'value' => null, 'placeholder' => null, 'tabindex' => null, 'col' => null, 'readonly' => null, 'disabled' => null, 'format' => null, 'enableTime' => false, 'noCalendar' => false, 'time24hr' => true, 'mode' => 'single', 'icon' => true, 'displayFormat' => null, 'hint' => null])
@use('Svenbw\LaravelTabler\Helpers\WireModelEntangler')
@use('Svenbw\LaravelTabler\Helpers\Form')
@use('Svenbw\LaravelTabler\Tabler')
@php
    $errorKey = Form::errorKey($name);
    $isInvalid = isset($errors) && $errors->has($errorKey);
    $prependText = $attributes->get('prepend-text');
    $appendText = $attributes->get('append-text');
    $cols = Form::colClass($col);
    $componentId = $name . '_' . uniqid();
    $showIcon = $icon && ! $prependText && ! $appendText;

    $format ??= Tabler::dateFormat();
    if ($value instanceof \DateTimeInterface) {
        $value = $value->format($format);
    }

    if ($displayFormat === null && ! $noCalendar) {
        $displayFormat = Tabler::localeDateFormat();
        if ($enableTime) {
            $displayFormat .= $time24hr ? ' H:i' : ' h:i K';
        }
    }

    // Flatpickr options
    $flatpickrOptions = [
        'dateFormat' => $format,
        'enableTime' => $enableTime,
        'noCalendar' => $noCalendar,
        'time_24hr' => $time24hr,
        'mode' => $mode,
    ];
    if ($displayFormat) {
        $flatpickrOptions['altInput'] = true;
        $flatpickrOptions['altFormat'] = $displayFormat;
    }

    // Add any additional options from attributes
    if ($attributes->has('min-date')) {
        $flatpickrOptions['minDate'] = $attributes->get('min-date');
    }
    if ($attributes->has('max-date')) {
        $flatpickrOptions['maxDate'] = $attributes->get('max-date');
    }
    if ($attributes->has('disable')) {
        $flatpickrOptions['disable'] = $attributes->get('disable');
    }
    $config = [
        'value' => $value,
        'locale' => $attributes->get('locale', app()->getLocale()),
        'options' => $flatpickrOptions,
    ];
    $entangler = WireModelEntangler::make($attributes);
@endphp

<div @class(['mb-3', $cols])>
    <label @class(['form-label', 'required' => $attributes->has('required')]) for="{{ $componentId }}">{{ $label }}</label>
    <div wire:ignore x-data="datepicker(@js($config){{ $entangler->hasModel() ? ', '.$entangler->entangle() : '' }})">
        @if($prependText || $appendText)
        <div class="input-group input-group-flat">
            @if($prependText)
            <span class="input-group-text">
                {{ $prependText }}
            </span>
            @endif
        @endif

        @if($showIcon)
        <div class="input-icon">
            <span class="input-icon-addon">
                @if($noCalendar)
                <!-- https://tabler.io/icons/icon/clock -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/><path d="M12 7v5l3 3"/></svg>
                @else
                <!-- https://tabler.io/icons/icon/calendar -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"/><path d="M16 3v4"/><path d="M8 3v4"/><path d="M4 11h16"/><path d="M11 15h1"/><path d="M12 15v3"/></svg>
                @endif
            </span>
        @endif

        <input
            x-ref="input"
            type="text"
            @class(['form-control', 'is-invalid' => $isInvalid, 'ps-0' => !!$prependText, 'text-end pe-0' => !!$appendText])
            name="{{ $name }}"
            id="{{ $componentId }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($attributes->has('readonly') || $readonly) readonly @endif
            @if($attributes->has('disabled') || $disabled) disabled @endif
            @isset($tabindex) tabindex="{{ $tabindex }}" @endif
            @isset($value) value="{{ $value }}" @endisset
            autocomplete="off"
        >

        @if($showIcon)
        </div>
        @endif

        @if($prependText || $appendText)
            @if($appendText)
            <span class="input-group-text">
                {{ $appendText }}
            </span>
            @endif
        </div>
        @endif
    </div>
    
    @if($isInvalid)
    <div class="invalid-feedback d-block">{{ join(', ', $errors->get($errorKey)) }}</div>
    @endif
    @if($hint)
    <small class="form-hint">{{ $hint }}</small>
    @endif
</div>