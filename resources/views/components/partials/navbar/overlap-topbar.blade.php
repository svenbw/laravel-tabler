@use('Svenbw\LaravelTabler\Tabler')
<header class="{{$layoutData['cssClasses'] ?? 'navbar navbar-expand-md navbar-overlap d-print-none'}}" data-bs-theme="dark">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            @include('tabler::components.partials.common.logo')
        </h1>

        <div class="navbar-nav flex-row order-md-last">

            <div class="nav-item d-none d-md-flex me-3">
                <div class="btn-list">
                    <x-tabler::partials.header.header-button
                        title="Source code"
                    />                    
                </div>
            </div>

            <div class="d-none d-md-flex">
                @include('tabler::components.partials.header.theme-switch')
                @include('tabler::components.partials.header.notifications')
            </div>

            @include('tabler::components.partials.header.profile-right')
        </div>

        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                <ul class="navbar-nav">
                    @each('tabler::components.partials.navbar.dropdown-item', app(Tabler::class)->menu()->getGroup('main')->items(), 'item')
                </ul>
            </div>
        </div>
    </div>
</header>
