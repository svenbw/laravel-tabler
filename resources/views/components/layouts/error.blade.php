@use('Svenbw\LaravelTabler\Tabler')
@props(['code', 'title' => null, 'message' => null, 'home' => '/'])
@php
    $title ??= Tabler::errorText($code, 'title');
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="robots" content="noindex, nofollow">
        <title>{{ app(Tabler::class)->websiteTitle([$title]) }}</title>
        @include('tabler::components.partials.common.theme')
        @if (! empty(config('tabler.vite')))
            @vite(config('tabler.vite'))
        @endif
    </head>
    <body class="border-top-wide border-primary d-flex flex-column">
        <div class="page page-center">
            <div class="container-tight pt-4 text-center">
                @if(isset($logo))
                    {{ $logo }}
                @else
                    <x-tabler::partials.common.logo :url="$home ?: '/'" />
                @endif
            </div>
            <x-tabler::error :code="$code" :title="$title" :message="$message" :home="$home">
                @isset($action)
                    <x-slot:action>{{ $action }}</x-slot:action>
                @endisset
            </x-tabler::error>
        </div>
    </body>
</html>
