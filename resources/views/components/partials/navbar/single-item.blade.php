@props(['item'])
<a class="dropdown-item" href="{{ $item->getRoute() }}">
    @if ($item->hasIcon())
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            {!! $item->getIcon() !!}
        </span>
    @endif
    {{ $item->getName() }}
</a>
