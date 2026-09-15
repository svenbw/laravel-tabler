@props(['header', 'action', 'headerButtons' => null, 'buttons' => null, 'class' => null ])
@php
    use Svenbw\LaravelTabler\Services\CardButtons;

    $headerButtons = CardButtons::make($headerButtons);
    $footerButtons = CardButtons::make($buttons);
    $submitAction = $footerButtons->submitAction();

    $cancel = $attributes->get('cancel');
    $submit = $attributes->get('submit');

    if (is_string($class)) {
        $class = explode(' ', $class);
    }
    if ($class === null || in_array('card', $class)) {
        $class[] = 'card';
    }

@endphp
<div @class($class)>
    @if($submitAction !== null)
        @if(str_starts_with($submitAction, 'wire:'))
            <form {{ $submitAction }} autocomplete="off">
        @else
            <form action="{{ $submitAction }}" method="post" enctype="multipart/form-data" autocomplete="off">
            @csrf
        @endif
    @endif
    @if(isset($header) || ! $headerButtons->isEmpty() || $showTabs)
        <div class="card-header">
            @isset($header)
                <h3 class="card-title">{{ $header }}</h3>
            @endif
            @if($headerButtons->get())
                <div class="card-actions">
                    @foreach($headerButtons as $button)
                        @if($button['liveWireAction'])
                            <button type="button" @class(['btn', 'btn-'.Arr::get($button, 'color', 'link'), Arr::get($button, 'class', 'ms-auto')]) {{ $button['liveWireAction'] }} @disabled(Arr::has($button, 'disabled'))>{{ $button['text'] }}</button>
                        @elseif(Arr::get($button, 'when', true))
                            @if(Arr::has($button, 'disabled'))
                                <a href="javascript:;" @class(['btn disabled', 'btn-'.Arr::get($button, 'color', 'outline-secondary'), Arr::get($button, 'class')])>{{ $button['text'] }}</a>
                            @else
                                <a href="{{ Arr::get($button, 'url', 'javascript:;') }}" @class(['btn', 'btn-'.Arr::get($button, 'color', 'outline-secondary'), Arr::get($button, 'class')])>{{ $button['text'] }}</a>
                            @endif
                        @endif
                    @endforeach
                </div>
            @endif
            @if($showTabs)
                <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                    @foreach($tabs as $tab)
                        <li class="nav-item">
                            <a href="#{{ $tab['ref'] }}" @class(['nav-link', 'active' => $tab['active']]) data-bs-toggle="tab">{{ $tab['text'] }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
    <div @class(['card-body' => !$attributes->has('no-body')])>
        @if ($tabs)
            @if ($showTabs)
                <div class="tab-content">
                    @foreach($tabs as $tab)
                        <div @class(['tab-pane', 'active show' => $tab['active']]) id="{{ $tab['ref'] }}">
                            {{ ${$tab['slot']} }}
                        </div>
                    @endforeach
                </div>
            @else
                {{ ${$tabs[0]['slot']} }}
            @endif
        @else
            {{ $slot }}
        @endif
    </div>

    @if(!$footerButtons->isEmpty())
        <div class="card-footer text-end">
            <div class="d-flex">
                @foreach($footerButtons->get() as $button)
                    @if($button['isSubmit'])
                        <button type="submit" @class(['btn', 'btn-'.Arr::get($button, 'color', 'outline-secondary'), Arr::get($button, 'class', 'ms-auto')]) @disabled(Arr::has($button, 'disabled'))>{{ $button['text'] }}</button>
                    @elseif($button['liveWireAction'])
                        <button type="button" @class(['btn', 'btn-'.Arr::get($button, 'color', 'outline-secondary'), Arr::get($button, 'class', 'ms-auto')]) {{ $button['liveWireAction'] }} @disabled(Arr::has($button, 'disabled'))>{{ $button['text'] }}</button>
                    @elseif(Arr::get($button, 'when', true))
                        @if(Arr::has($button, 'disabled'))
                            <a href="javascript:;" @class(['btn disabled', 'btn-'.Arr::get($button, 'color', 'outline-secondary'), Arr::get($button, 'class')])>{{ $button['text'] }}</a>
                        @else
                            <a href="{{ Arr::get($button, 'url', 'javascript:;') }}" @class(['btn', 'btn-'.Arr::get($button, 'color', 'outline-secondary'), Arr::get($button, 'class')])>{{ $button['text'] }}</a>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    @if($submitAction !== null)
        </form>
    @endif
</div>
