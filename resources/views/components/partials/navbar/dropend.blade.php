@if ($item->hasSubItems())
    <div class="dropend">
        <a class="dropdown-item dropdown-toggle" href=""
           data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
           aria-expanded="false">
            @if ($item->hasIcon())
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    {!! $item->getIcon() !!}
                </span>
            @endif
            {{ $item->getName() }}
        </a>
        <div class="dropdown-menu">
            @each('tabler::components.partials.navbar.multilevel', $item->subItems(), 'item')
        </div>
    </div>
@else
    <x-tabler::partials.navbar.single-item
        :item="$item"
    />
@endif
