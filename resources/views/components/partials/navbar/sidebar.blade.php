@use('Svenbw\LaravelTabler\Tabler')
@php $viewResource = config('tabler.views.top_bar'); @endphp
<aside class="{{$layoutData['cssClasses'] ?? 'navbar navbar-vertical navbar-expand-lg'}}"
    @if(config('tabler.layout.light_sidebar') !== null)
        data-bs-theme="{{ config('tabler.layout.light_sidebar') ? 'light' : 'dark' }}"
    @endif
>
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            @include('tabler::components.partials.common.logo')
        </h1>
        
        <div class="navbar-nav flex-column d-none d-lg-block" style="flex-grow: unset;">
            @include('tabler::components.partials.header.profile-right')
            <div class="nav-item d-flex-row">
                <div class="d-none d-md-flex justify-content-end mt-2">
                    @include('tabler::components.partials.header.theme-switch')
                    @include('tabler::components.partials.header.notifications', ['in_sidebar' => true])
                </div>
            </div>
            @if ($viewResource)
                {!! view($viewResource)->render() !!}
            @endif
        </div>

        <div class="navbar-nav flex-row order-md-last d-lg-none">
            <div class="d-none d-md-flex">
                @include('tabler::components.partials.header.theme-switch')
                @include('tabler::components.partials.header.notifications')
            </div>
            @include('tabler::components.partials.header.profile-right')
        </div>

        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                @each('tabler::components.partials.navbar.dropdown-item', app(Tabler::class)->menu()->getGroup('main')->items(), 'item')
            </ul>
        </div>
    </div>
</aside>

@if(config('tabler.layout.enable_top_header'))
    @include('tabler::components.partials.header.sidebar-top')
@endif
