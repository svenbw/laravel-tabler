@props(['legend', 'id' => null, 'separator' => null, 'col' => null, 'hint' => null])
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $cols = Form::colClass($col);
    $separator = $separator !== null;
    $id ??= Form::id('fieldset', $legend);
@endphp
<div class="row">
    @if ($separator)
        <div @class($cols)>
            <hr class="w-card mt-0">
    @endif
        <fieldset @class(['mb-3', ($cols ?: 'col') => !$separator]) id="{{ $id }}" @if($hint) aria-describedby="{{ Form::hintId($id) }}" @endif>
            <legend class="card-title">{{ $legend }}</legend>
            {{ $slot }}
            @if($hint)
                <small class="form-hint" id="{{ Form::hintId($id) }}">{{ $hint }}</small>
            @endif
        </fieldset>
    @if ($separator)
    </div>
    @endif
</div>
