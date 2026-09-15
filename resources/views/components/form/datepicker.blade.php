@props(['label', 'name', 'value' => null, 'placeholder' => null, 'tabindex' => null, 'col' => null, 'readonly' => null, 'disabled' => null, 'format' => 'Y-m-d', 'enableTime' => false, 'noCalendar' => false, 'time24hr' => true, 'mode' => 'single'])
@use('Svenbw\LaravelTabler\Helpers\WireModelEntangler')
@php
    $isInvalid = isset($errors) && $errors->has($name);
    $prependText = $attributes->get('prepend-text');
    $appendText = $attributes->get('append-text');
    $cols = is_string($col) ? join(' ', array_map(fn($col) => 'col-'.$col, explode(' ', $col))) : '';
    $componentId = $name . '_' . uniqid();

    // Flatpickr options
    $flatpickrOptions = [
        'dateFormat' => $format,
        'enableTime' => $enableTime,
        'noCalendar' => $noCalendar,
        'time_24hr' => $time24hr,
        'mode' => $mode,
    ];

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
    if ($attributes->has('locale')) {
        $flatpickrOptions['locale'] = $attributes->get('locale');
    }
    $entangler = WireModelEntangler::make($attributes);
@endphp

<div @class(['mb-3', $cols])>
    <label @class(['form-label', 'required' => $attributes->get('required')]) for="{{ $componentId }}">{{ $label }}</label>
    <div 
        wire:ignore
        x-data="{
            picker: null,
@if($entangler->hasModel())
            wireValue: {{ $entangler->entangle() }},
@else
            wireValue: null,
@endif
            init() {
                this.picker = flatpickr($refs.input, {
                    ...@js($flatpickrOptions),
                    defaultDate: this.wireValue || null,
                    onChange: (selectedDates, dateStr, instance) => {
                        this.wireValue = dateStr;
                    },
                });
            
@if($entangler->hasModel())
                $watch('wireValue', (newValue) => {
                    if (newValue !== picker.input.value) {
                        picker.setDate(newValue, false);
                    }
                });
@endif
            }
        }">
        @if($prependText || $appendText)
        <div class="input-group input-group-flat">
            @if($prependText)
            <span class="input-group-text">
                {{ $prependText }}
            </span>
            @endif
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
    <div class="invalid-feedback d-block">{{ join(', ', $errors->get($name)) }}</div>
    @endif
</div>