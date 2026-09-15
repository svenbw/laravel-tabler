<header class="{{$layoutData['cssClasses'] ?? 'navbar navbar-expand-md d-print-none'}}"
    @if(config('tabler.layout.light_topbar') !== null)
        data-bs-theme="{{ config('tabler.layout.light_topbar') ? 'light' : 'dark' }}"
    @endif
>
    @include('tabler::components.partials.common.condensed-container-xl')
</header>
