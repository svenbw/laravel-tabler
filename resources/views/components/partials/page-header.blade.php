@props(['title' => '', 'pretitle' => null, 'breadcrumbs' => null])
<div class="page-header d-print-none" aria-label="{{ __('tabler::partials.page_header') }}">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                @if (!empty($pretitle))
                    <div class="page-pretitle">{{ $pretitle }}</div>
                @endif
                <h2 class="page-title">{{ $title }}</h2>
            </div>
            <x-tabler::partials.breadcrumbs
                :breadcrumbs="$breadcrumbs"
            />
        </div>
    </div>
</div>