@props(['title', 'value', 'max' => 100, 'barTitle' => 'Score', 'dropdown' => [], 'trend' => null, 'cardUrl' => null, 'absolute' => false, 'color' => 'blue' ])
@php
    $rating = $max > 0 ? 100 * ($value / $max) : 0;
@endphp
<div class="card">
    <div
        class="card-body"
        @if($cardUrl)
            data-card-url="{{ $cardUrl }}"
        @endif
    >
        <div class="d-flex align-items-center">
            <div class="subheader">{{ $title }}</div>
            @if(is_array($dropdown))
                <div class="ms-auto lh-1">
                    <div class="dropdown">
                        <a class="text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            @foreach($dropdown as $title => $url)
                                @if($url === '-')
                                    <hr class="dropdown-divider">
                                @elseif(str_starts_with($url, 'wire:'))
                                    <a class="dropdown-item" href="javascript:void(0)" {{ $url }}>{{ $title }}</a>
                                @else
                                    <a class="dropdown-item" href="{{ $url }}">{{ $title }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="h1 mb-3">
            @if($absolute === true)
            {{ $value }}
            @elseif(is_string($absolute))
            {!! $absolute.$value !!}
            @else
            {{ $rating.'%' }}
            @endif
        </div>
        <div class="d-flex mb-2">
            <div>{{ $barTitle }}</div>
            @if ($trend !== null)
                @if ($trend > 0)
                    <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            {{ 100 * ($trend / $max) }}%
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="3 17 9 11 13 15 21 7" /><polyline points="14 7 21 7 21 14" /></svg>
                        </span>
                    </div>
                @elseif ($trend == 0)
                    <div class="ms-auto">
                        <span class="text-yellow d-inline-flex align-items-center lh-1">
                            0%
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l14 0"></path></svg>
                        </span>
                    </div>
                @elseif ($trend < 0) 
                    <div class="ms-auto">
                        <span class="text-red d-inline-flex align-items-center lh-1">
                            {{ 100 * ($trend / $max) }}%
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7l6 6l4 -4l8 8"></path><path d="M21 10l0 7l-7 0"></path></svg>
                        </span>
                    </div>
                @endif
            @endif
        </div>
        <div class="progress progress-sm">
            <div class="progress-bar bg-{{ $color }}" style="width: {{ $rating }}%" role="progressbar" aria-valuenow="{{ $rating }}" aria-valuemin="0" aria-valuemax="100">
                <span class="visually-hidden">{{ $rating }}% Complete</span>
            </div>
        </div>
    </div>
</div>
