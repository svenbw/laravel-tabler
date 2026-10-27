@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $isInvalid = isset($errors) && $errors->has($errorKey());
    $alpineOn = $attributes->whereStartsWith(['x-on:', '@']);
    $attributes = $attributes->except(array_keys($alpineOn->all()));
@endphp
<div {{ $attributes->only('class')->class([Form::margin($attributes->get('class')), $cols()]) }}>
    @if(filled($label))
        <label @class(['form-label', 'required' => $required]) for="{{ $id }}">{{ $label }}</label>
    @endif
    <div @class(['is-invalid' => $isInvalid]) {{ $alpineOn }}>
        <div wire:ignore x-data="{{ $xData() }}">
            <select
                x-ref="select"
                @if($multiple)
                    multiple="multiple"
                @endif
                name="{{ $name }}"
                id="{{ $id }}"
                @class(['is-invalid' => $isInvalid])
                @if($attributes->has('readonly')) readonly @endif
                @if($disabled) disabled @endif
                @if($required) aria-required="true" @endif
            >
                @if($optionGroups)
                    @foreach($optionGroups as $group)
                        <optgroup label="{{ $group['name'] }}">
                            @foreach($group['options'] as $val => $opt)
                                <option value="{{ $val }}"
                                    @if($isSelected($val)) selected @endif
                                    @if(is_array($opt) && array_key_exists('icon', $opt))
                                    data-icon="{{ $opt['icon'] }}"
                                    @endif>
                                    {{ is_array($opt) ? $opt['text'] : $opt }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                @elseif($options)
                    @foreach($options as $val => $opt)
                        <option value="{{ $val }}"
                            @if($isSelected($val)) selected @endif
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
        <div class="invalid-feedback d-block">{{ join(', ', $errors->get($errorKey())) }}</div>
    @endif
    @if($hint)
        <small class="form-hint">{{ $hint }}</small>
    @endif
</div>
