@use('Svenbw\LaravelTabler\Tabler')
@props(['title', 'pretitle' => null, 'breadcrumbs' => null, 'size' => 'xl'])
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['hide-overflow' => $attributes->has('hide-overflow')])>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ app(Tabler::class)->websiteTitle() }}</title>
        @include('tabler::components.partials.common.theme')
        @if (! empty(config('tabler.vite')))
            @vite(config('tabler.vite'))
        @endif
    </head>
    <body class="layout-fluid">
        <div class="page">
            <x-dynamic-component :component="'tabler::partials.navbar.'.app(Tabler::class)->barStyle()" />
            <div class="page-wrapper">
                @if(!empty($title))
                    <x-tabler::partials.page-header
                        :title="$title"
                        :pretitle="$pretitle"
                        :breadcrumbs="$breadcrumbs"
                    />
                @endif
                @hasSection('page')
                    <div class="page-body">
                        <div class="container-xl">
                            @yield('page')
                        </div>
                    </div>
                @endif
                <x-tabler::error />
                <x-tabler::toast />
                <x-tabler::partials.footer.bottom />
            </div>
        </div>
        @livewireScriptConfig
        @stack('scripts')
    </body>
</html>
