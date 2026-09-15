@props(['breadcrumbs' => null])
@if(is_array($breadcrumbs) && !empty($breadcrumbs))
    <div class="col-auto ms-auto d-print-none">
        <div class="d-flex">
            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                @php $last = array_pop($breadcrumbs); @endphp
                @foreach($breadcrumbs as $breadcrumb)
                    @if (!property_exists($breadcrumb, 'url'))
                        throw new \Exception('url is requred for breadcrumbs')
                    @endif
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @endforeach
                <li class="breadcrumb-item active" aria-current="page">{{ $last->title }}</li>
            </ol>
        </div>
    </div>
@endif