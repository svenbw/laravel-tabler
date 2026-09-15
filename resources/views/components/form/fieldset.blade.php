@props(['legend', 'separator' => null, 'col' => null])
@php
    $cols = is_string($col) ? join(' ', array_map(fn($col) => 'col-'.$col, explode(' ', $col))) : '';
    $separator = $separator !== null;
@endphp
<div class="row">
    @if ($separator)
        <div @class($cols)>
            <hr class="w-card mt-0">
    @endif
        <fieldet @class(['mb-3', ($col ? 'col-'.$col : 'col') => !$separator])>
            <legend class="card-title">{{ $legend }}</legend>
            {{ $slot }}
        </fieldet>
    @if ($separator)
    </div>
    @endif
</div>
