@use('Svenbw\LaravelTabler\Tabler')
@auth
@php
    $user = Auth()->user();
@endphp
    <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="{{ __('tabler::menu.user') }}">
            <span class="avatar">{{ $user->initials }}</span>
            <div class="d-none d-xl-block ps-2">
                <div>{{ $user->name }}</div>
                <div class="mt-1 small text-muted">Software Engineer</div>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            @foreach(app(Tabler::class)->menu()->getGroup('header')->items() as $item)
                @if ($item->isSeparator())
                    <div class="dropdown-divider"></div>
                @else
                    <a href="{{ $item->getRoute() }}" class="dropdown-item">{{ $item->getName()}}</a>
                @endif
            @endforeach
        </div>
    </div>
@endif
