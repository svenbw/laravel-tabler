@use('Svenbw\LaravelTabler\Tabler')
@php $in_sidebar = isset($in_sidebar) ? $in_sidebar : false; @endphp
<div @class(['nav-item dropdown d-none d-md-flex', 'me-3' => !$in_sidebar])>
    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="{{ __('tabler::notifications.show_notifications') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"/>
            <path d="M9 17v1a3 3 0 0 0 6 0v-1"/>
        </svg>
        @if (app(Tabler::class)->notifications()->exist())
            <span class="badge bg-red"></span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-card dropdown-menu-end">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('tabler::notifications.last_updates') }}</h3>
            </div>
            <div class="list-group list-group-flush list-group-hoverable">
                @each('tabler::components.partials.header.notification-item', app(Tabler::class)->notifications()->all(), 'notification')
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <a href="{{ route(config('tabler.routes.notifications')) }}" class="btn btn-2 w-100">{{ __('tabler::notifications.view_all') }}</a>
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-2 w-100">{{ __('tabler::notifications.mark_as_read') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
