@props(['legend', 'separator' => null, 'col' => null])
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $cols = Form::colClass($col);
    $separator = $separator !== null;
@endphp
<div class="row">
    @if ($separator)
        <div @class($cols)>
            <hr class="w-card mt-0">
    @endif
        <fieldset @class(['mb-3', ($cols ?: 'col') => !$separator])>
            <legend class="card-title">{{ $legend }}</legend>
            {{ $slot }}
        </fieldset>
    @if ($separator)
    </div>
    @endif
</div>
