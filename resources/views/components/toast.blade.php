@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('toast', options => {
                ToastHelper.show(options);
            })
        });
        @if (session()->has('toast.message'))
            document.addEventListener('DOMContentLoaded', () => {
                ToastHelper.show({
                    type: '{{ session()->get('toast.type') }}',
                    title: '{{ session()->get('toast.title') }}',
                    message: '{{ session()->get('toast.message') }}',
                    delay: {{ session()->get('toast.delay', 'null') }},
                    icon: null,
                });
            });
        @endif
    </script>
@endpush
