@props(['label', 'name', 'value' => null, 'placeholder' => null, 'tabindex' => null, 'col' => null, 'readonly' => null, 'disabled' => null,'precision' => 2,'min' => 0,'max' => 999999999])
@use('Svenbw\LaravelTabler\Helpers\WireModelEntangler')
@php
    $isInvalid = isset($errors) && $errors->has($name);
    $prependText = $attributes->get('prepend-text');
    $appendText = $attributes->get('append-text');
    $cols = is_string($col) ? join(' ', array_map(fn($col) => 'col-'.$col, explode(' ', $col))) : '';

    $locale = App::getLocale();
    $formatter = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);
    $decimalSeparator = $formatter->getSymbol(\NumberFormatter::DECIMAL_SEPARATOR_SYMBOL);
    $thousandsSeparator = $formatter->getSymbol(\NumberFormatter::GROUPING_SEPARATOR_SYMBOL);
    $entangler = WireModelEntangler::make($attributes);
@endphp

<div @class(['mb-3', $cols]) 
     x-data="{
        mask: null,
@if($entangler->hasModel())
        wireValue: {{ $entangler->entangle() }},
@else
        wireValue: null,
@endif
        init() {
            this.mask = IMask($refs.decimalInput, {
                mask: Number,
                scale: {{ $precision }},
                signed: false,
                thousandsSeparator: '{{ $thousandsSeparator }}',
                padFractionalZeros: true,
                normalizeZeros: true,
                radix: '{{ $decimalSeparator }}',
                mapToRadix: ['{{ $decimalSeparator === '.' ? ',' : '.' }}'], 
                min: {{ $min }},
                max: {{ $max }}
            });

            $nextTick(() => {
                if (this.wireValue !== null && this.wireValue !== undefined && this.wireValue !== '') {
                    this.mask.value = String(this.wireValue);
                    this.mask.updateValue();
                } else if ('{{ $value }}') {
                    this.mask.value = '{{ $value }}';
                    this.mask.updateValue();
                }
            })

            this.mask.on('accept', () => {
                const unmaskedValue = this.mask.unmaskedValue;
                this.wireValue = unmaskedValue ? parseFloat(unmaskedValue) : null;
            });

@if($entangler->hasModel())
            $watch('wireValue', (newValue, oldValue) => {
                if (newValue !== null && newValue !== undefined && newValue !== '') {
                    const currentUnmasked = this.mask.unmaskedValue;
                    if (parseFloat(currentUnmasked) !== parseFloat(newValue)) {
                        this.mask.value = String(newValue);
                        this.mask.updateValue();
                    }
                } else if (newValue === null || newValue === '') {
                    this.mask.value = '';
                }
            });
@endif            
        }
     }">
    <label @class(['form-label', 'required' => $attributes->get('required')]) for="{{ $name }}">{{ $label }}</label>
    
    @if($prependText || $appendText)
        <div class="input-group input-group-flat">
        @if($prependText)
            <span class="input-group-text">{{ $prependText }}</span>
        @endif
    @endif

    <input
        type="text"
        x-ref="decimalInput"
        @class(['form-control', 'is-invalid' => $isInvalid, 'ps-0' => !!$prependText, 'text-end pe-0' => !!$appendText])
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->whereStartsWith('wire:') }}
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($readonly || $attributes->has('readonly')) readonly @endif
        @if($disabled) disabled @endif
        @isset($tabindex) tabindex="{{ $tabindex }}" @endif
        wire:ignore
    >

    @if($prependText || $appendText)
        @if($appendText)
            <span class="input-group-text">{{ $appendText }}</span>
        @endif
        </div>
    @endif

    @if($isInvalid)
        <div class="invalid-feedback" style="display: block;">{{ join(',', $errors->get($name)) }}</div>
    @endif
</div>