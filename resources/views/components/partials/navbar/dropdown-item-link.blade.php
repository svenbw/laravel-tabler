@props(['item'])
<li class="nav-item" id="{{ $item->getId() }}">
    <a class="nav-link" href="{{ $item->getRoute() }}">
        @if ($item->hasIcon())
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                {!! $item->getIcon() !!}
            </span>
        @endif
        <span class="nav-link-title">
            {{ $item->getName() }}
        </span>
    </a>
</li>
