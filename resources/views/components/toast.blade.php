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
                    type: @js(session()->get('toast.type')),
                    title: @js(session()->get('toast.title')),
                    message: @js(session()->get('toast.message')),
                    delay: @js(session()->get('toast.delay')),
                    icon: null,
                });
            });
        @endif
    </script>
@endpush
