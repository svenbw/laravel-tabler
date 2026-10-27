@use('Illuminate\Support\HtmlString')
@use('Svenbw\LaravelTabler\Tabler')
@props(['code' => null, 'title' => null, 'message' => null, 'home' => '/'])
@php
    $code ??= $__env->yieldContent('code') ?: null;
    $message ??= $__env->hasSection('message') ? new HtmlString($__env->yieldContent('message')) : null;
@endphp
@if(filled($code))
    <div class="container-tight py-4">
        <div class="empty">
            <div class="empty-header">{{ $code }}</div>
            <p class="empty-title">{{ $title ?? Tabler::errorText($code, 'title') }}</p>
            <p class="empty-subtitle text-secondary">{{ $message ?? Tabler::errorText($code, 'message') }}</p>
            @if(isset($action))
                @if($action->isNotEmpty())
                    <div class="empty-action">{{ $action }}</div>
                @endif
            @elseif($home !== false)
                <div class="empty-action">
                    <a href="{{ $home }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon" width="24" height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            <path d="M5 12l6 6"></path>
                            <path d="M5 12l6 -6"></path>
                        </svg>
                        {{ __('tabler::errors.home') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif
