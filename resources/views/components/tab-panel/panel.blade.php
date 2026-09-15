@props(['title' => null, 'id', 'submit' => null])
@aware(['active' => null, 'tabs', 'cancel'])
@php
    if(empty($title) && array_key_exists($id, $tabs)) {
        $title = $tabs[$id];
    }
@endphp
{{--
<form
    action=""
    method="post"
    enctype="multipart/form-data"
    autocomplete="off"
    id="{{ $id }}"
    role="tabpanel"
    @class(['tab-pane', 'active' => $active === $id])
>
    @csrf
    @empty($submit)
        <input type="hidden" name="_panel" value="{{ $id }}" autocomplete="off">
    @endempty
--}}
    <div
        @class(['tab-pane', 'container', 'active' => $active === $id])
        id="{{ $id }}"
        role="tabpanel"        
    >
        @isset($title)
            <h2 class="mb-4">{{ $title }}</h2>
        @endisset
        <div>

            {{ $slot}}
        </div>
    </div>
{{--
    <div class="card-footer bg-transparent mt-auto">
        <div class="btn-list justify-content-end">
            @isset($cancel)
                <a href="{{ $cancel }}" class="btn btn-1">{{ __('common.cancel') }}</a>
            @endisset
            <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
        </div>
    </div>

</form>
--}}
