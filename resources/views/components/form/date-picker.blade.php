@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $isInvalid = isset($errors) && $errors->has($errorKey());
    $prependText = $attributes->get('prepend-text');
    $appendText = $attributes->get('append-text');
    $showIcon = $icon && ! $prependText && ! $appendText;
@endphp

<div {{ $attributes->only('class')->class([Form::margin($attributes->get('class')), $cols()]) }}>
    @if(filled($label))
        <label @class(['form-label', 'required' => $required]) for="{{ $id }}">{{ $label }}</label>
    @endif
    <div wire:ignore x-data="{{ $xData() }}">
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
            id="{{ $id }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            @if($required) aria-required="true" @endif
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
        <div class="invalid-feedback d-block">{{ join(', ', $errors->get($errorKey())) }}</div>
    @endif
    @if($hint)
        <small class="form-hint">{{ $hint }}</small>
    @endif
</div>
