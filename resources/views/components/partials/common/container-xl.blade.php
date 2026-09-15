<div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
        <x-tabler::partials.common.logo />
    </h1>
    <div class="navbar-nav flex-row order-md-last">

        <div class="nav-item d-none d-md-flex me-3">
            @php
                $viewResource = config('tabler.views.top_bar');
                if ($viewResource) {
                    echo view($viewResource)->render();
                }
            @endphp
        </div>

        <div class="d-none d-md-flex">
            <x-tabler::partials.header.theme-switch />
            <x-tabler::partials.header.notifications />
        </div>

        <x-tabler::partials.header.profile-right />
    </div>
</div>
