@if ($item->hasSubItems())
    <li class="nav-item dropdown" id="{{ $item->getId() }}">
        <a @class(['nav-link dropdown-toggle', 'show' => $item->isActive()])
            href=""
            data-bs-toggle="dropdown"
            data-bs-auto-close="outside" 
            role="button"
            aria-expanded="{{ $item->isActive() ? 'true' : 'false' }}">
            @if ($item->hasIcon())
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    {!! $item->getIcon() !!}
                </span>
            @endif
            <span class="nav-link-title">
                {{ $item->getName()}} 
            </span>
        </a>
        <div @class(['dropdown-menu', 'show' => $item->isActive()])>
            <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                    @if ($item->hasSubItems())
                        @each('tabler::components.partials.navbar.multilevel', $item->subItems(), 'item')
                    @else
                        <x-tabler::partials.navbar.submenu-dropdown-item
                            :item="$item"
                        />
                    @endif
                </div>
            </div>
        </div>
    </li>
@else
    <x-tabler::partials.navbar.dropdown-item-link
        :item="$item"
    />
@endif
