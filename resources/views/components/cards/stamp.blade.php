@props(['icon' => null, 'color' => 'primary'])
<div {{ $attributes->merge(['class' => 'card-stamp']) }}>
    @if ($icon)
        <div class="card-stamp-icon bg-{{ $color }}">
            <x-dynamic-component :component="'tabler-'.$icon" class="icon" />
        </div>
    @else
        {{ $slot }}
    @endif
</div>