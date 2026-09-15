@props(['type' => null])
<div {{ $attributes->merge(['class' => 'card'.($type === null ? '' : ' bg-'.$type.'-lt')]) }}>

    @isset($stamp)
        <x-tabler::cards.stamp>
            {{$stamp}}
        </x-tabler::cards.stamp>
    @endisset

    @isset($ribbon)
        {{$ribbon}}
    @endisset

    @isset($header)
        <x-tabler::cards.header>
            {{$header}}
        </x-tabler::cards.header>
    @endisset

    @isset($body)
        <x-tabler::cards.body>
            {{$body}}
        </x-tabler::cards.body>
    @endisset

    @isset($footer)
        <x-tabler::cards.footer>
            {{$footer}}
        </x-tabler::cards.footer>
    @endisset

</div>
