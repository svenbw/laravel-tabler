@props(['title' => null, 'tabs', 'active' => null, 'cancel' => null])
@php
    if (($active === null || !array_key_exists($active, $tabs)) && !empty($tabs)) {
        $active = array_keys($tabs)[0];
    }
@endphp
<div
    class="row g-0"
    role="tabpanel"
>
    <div class="col-12 col-md-3 border-end">
        <div @class(['card-body pb-0', 'pt-0' => empty($title)])>
            @if (!empty($title))
                <h4 class="subheader">{{ $title }}</h4>
            @endif
            <div class="list-group list-group-transparent" role="tablist">
                @foreach($tabs as $id => $title)
                    <a
                        data-bs-toggle="list"
                        href="#{{ $id }}"
                        role="tab"
                        @class(['list-group-item list-group-item-action d-flex align-items-center', 'active' => $active === $id])
                    >{{ $title }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-12 col-md-9 d-flex flex-column tab-content">
        {{ $slot }}
    </div>
</div>