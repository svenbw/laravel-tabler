@props([ 'label' => 'Dropdown',  'icon' => null, 'items' => [], 'align' => 'end'])
<div class="dropdown">
    <button {{ $attributes->merge(['class' => 'btn btn-sm dropdown-toggle']) }} type="button" data-bs-toggle="dropdown"  aria-expanded="false">
        @if($icon !== null)
            @if(str_contains($icon, '<svg'))
                {!! $icon !!}
            @else
                <i class="{{ $icon }} me-1"></i>
            @endif
        @endif
        {{ $label }}
    </button>

    <div class="dropdown-menu dropdown-menu-{{ $align }}">
        @foreach($items as $item)
            @if(isset($item['divider']) && $item['divider'])
                <div class="dropdown-divider"></div>
            @else
                @php
                    $isActive = $item['active'] ?? false;
                    $hasBadge = isset($item['badge']);
                    $hasIcon  = isset($item['icon']);
                @endphp

                <a @class(['dropdown-item', 'active' => $isActive])  href="{{ $item['url'] ?? '#' }}"
                   @if(isset($item['wire'])) wire:click.prevent="{{ $item['wire'] }}" @endif
                >
                    @if($hasBadge)
                        <span class="badge {{ $item['badge'] }} me-2"></span>
                    @endif
                    @if($hasIcon)
                        @if(str_contains($item['icon'], '<svg'))
                            {!! $item['icon'] !!}
                        @else
                            <i class="{{ $item['icon'] }} me-2"></i>
                        @endif
                    @endif
                    {{ $item['label'] }}
                </a>
            @endif
        @endforeach
    </div>
</div>