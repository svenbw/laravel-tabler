@props(['url' => '/'])
@php
    $logos = [];
    foreach (['light', 'dark'] as $variant) {
        $path = config('tabler.logo.'.$variant);
        $logos[$variant] = blank($path)
            ? null
            : (preg_match('#^(?:/|[a-z][a-z0-9+.-]*:)#i', $path) === 1 ? $path : Vite::asset($path));
    }

    $logos['dark'] ??= $logos['light'];
@endphp
<a href="{{ $url }}" class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
    @if($logos['light'])
        <img src="{{ $logos['light'] }}" class="hide-theme-dark" width="32" height="32" alt="{{ config('app.name') }}">
    @endif
    @if($logos['dark'])
        <img src="{{ $logos['dark'] }}" class="hide-theme-light" width="32" height="32" alt="{{ config('app.name') }}">
    @endif
    {{ config('app.name') }}
</a>
