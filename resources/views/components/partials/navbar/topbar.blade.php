@use('Svenbw\LaravelTabler\Tabler')
<x-tabler::partials.header.top />
<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">
                    @each('tabler::components.partials.navbar.dropdown-item', app(Tabler::class)->menu()->getGroup('main')->items(), 'item')
                </ul>
                @include('tabler::components.partials.navbar.search')
            </div>
        </div>
    </div>
</header>
