@if ($item->hasSubItems())
    <div class="dropend">
        <a class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
            @if(isset($item['icon']))
                <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="{{ $item['icon'] ?? '' }} {{
                isset($item['icon_color']) ? 'text-' . $item['icon_color'] : ''
            }}"></i>
        </span>
            @endif


            {{ $item['text'] }}
            @isset($item['label'])
                    <span class="badge badge-sm bg-{{ $item['label_color'] ?? 'primary' }} text-uppercase ms-2">{{ $item['label'] }}</span>
            @endisset
        </a>
        <div class="dropdown-menu">
            @each('tabler::components.partials.navbar.dropend', $item['submenu'], 'item')
        </div>
    </div>
@else
    <x-tabler::partials.navbar.single-item
        :item="$item"
    />
@endif
