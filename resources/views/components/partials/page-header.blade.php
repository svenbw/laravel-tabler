@props(['title' => '', 'pretitle' => null, 'breadcrumbs' => null])
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                @if (!empty($pretitle))
                    <div class="page-pretitle">{{ $pretitle }}</div>
                @endif
                <h1 class="page-title">{{ $title }}</h1>
            </div>
            <x-tabler::partials.breadcrumbs
                :breadcrumbs="$breadcrumbs"
            />
        </div>
    </div>
</div>
