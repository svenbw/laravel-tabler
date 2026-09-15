<div class="list-group-item">
    <div class="row align-items-center">
        <div class="col-auto">
            @if(!$notification->isRead())
                <span class="status-dot status-dot-animated bg-red d-block"></span>
            @endif
        </div>
        <div class="col text-truncate">
            <a href="#" class="text-body d-block">{{ $notification->title }}</a>
            <div class="d-block text-secondary text-truncate mt-n1">
                {{ $notification->message }}
            </div>
        </div>
        {{--
        <div class="col-auto">
            <a href="#" class="list-group-item-actions">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-muted icon-2">
                    <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                </svg>
            </a>
        </div>
        --}}
    </div>
</div>
