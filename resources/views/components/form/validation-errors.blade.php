@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">Er ging iets mis</div>

        <ul class="list-group list-group-flush mt-3">
            @foreach ($errors->all() as $error)
                <li class="list-group-item">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
