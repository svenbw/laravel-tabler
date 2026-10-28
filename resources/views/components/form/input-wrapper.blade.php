@props(['label', 'name', 'id' => null, 'value', 'placeholder' => null, 'col' => null, 'required' => false])
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $errorKey = Form::errorKey($name);
    $isInvalid = isset($errors) && $errors->has($errorKey);
    $prependText = $attributes->get('prepend-text');
    $appendText = $attributes->get('append-text');
    $cols = Form::colClass($col);
    $id ??= $name;
@endphp
<div @class(['mb-3', $cols])>
    <label @class(['form-label', 'required' => $required]) for="{{ $id }}">{{ $label }}</label>
    @if($prependText || $appendText)
        <div class="input-group input-group-flat">
        @if($prependText)
            <span class="input-group-text">
                {{ $prependText }}
            </span>
        @endif
    @endif
    {{ $slot }}
    @if($prependText || $appendText)
        @if($appendText)
            <span class="input-group-text">
                {{ $appendText }}
            </span>
        @endif
        </div>
    @endif
    @include('tabler::components.partials.form-feedback', ['id' => $id, 'errorKey' => $errorKey])
</div>
