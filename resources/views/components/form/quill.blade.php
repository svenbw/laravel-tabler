@props([
    'label',
    'name',
    'value'       => null,
    'placeholder' => null,
    'tabindex'    => null,
    'col'         => null,
    'readonly'    => null,
    'disabled'    => null,
    'height'      => 200,
    'theme'       => 'snow',
    'toolbar'     => null,
])
@php
    $isInvalid = isset($errors) && $errors->has($name);
    $cols      = is_string($col) ? join(' ', array_map(fn($col) => 'col-'.$col, explode(' ', $col))) : '';
    $editorId  = 'quill_' . str_replace(['.', '[', ']'], '_', $name);
    $inputId   = $editorId . '_input';

    if ($disabled || ($readonly || $attributes->has('readonly'))) {
        $resolvedToolbar = false;
    } else {
        $defaultToolbar = [
            [['header' => [1, 2, 3, false] ]],
            ['bold', 'italic', 'underline', 'strike'],
            [[ 'list' => 'ordered' ], [ 'list' => 'bullet' ]],
            ['link', 'image'],
            ['clean']
        ];
        $resolvedToolbar = $toolbar ?? $defaultToolbar;
    }
@endphp

<div @class(['mb-3', $cols])>
    <label @class(['form-label', 'required' => $attributes->get('required')]) for="{{ $inputId }}">
        {{ $label }}
    </label>

    <div
        id="{{ $editorId }}"
        @class(['quill-editor', 'is-invalid' => $isInvalid])
        style="height: {{ (int) $height }}px;"
        @if($attributes->has('autofocus')) data-autofocus="true" @endif
    ></div>

    <input
        type="hidden"
        id="{{ $inputId }}"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $attributes->whereStartsWith('wire:') }}
        {{ $attributes->whereStartsWith('data-') }}
    >

    @if($isInvalid)
        <div class="invalid-feedback d-block">{{ join(', ', $errors->get($name)) }}</div>
    @endif
</div>

@push('scripts')
<script>
(function () {
    const initQuill = () => {
        const container = document.getElementById('{{ $editorId }}');
        const hidden    = document.getElementById('{{ $inputId }}');
        
        if (!container || !hidden || typeof Quill === 'undefined') return;
        if (container.__quill) return;

        const existingToolbar = container.previousElementSibling;
        if (existingToolbar && existingToolbar.classList.contains('ql-toolbar')) {
            existingToolbar.remove();
            console.log('double toolbar fix')
        }

        const quill = new Quill(container, {
            theme: '{{ $theme }}',
            placeholder: '{{ $placeholder ?? '' }}',
            readOnly: {{ ($readonly || $attributes->has('readonly')) ? 'true' : 'false' }},
            modules: {
                toolbar: @js($resolvedToolbar),
            },
        });

        if (hidden.value && quill.root.innerHTML !== hidden.value) {
            quill.root.innerHTML = hidden.value;
        }

        quill.on('text-change', () => {
            hidden.value = quill.getSemanticHTML();

            @if($attributes->whereStartsWith('wire:model')->first())
                hidden.dispatchEvent(new Event('input'));
            @endif
        });

        if ({{ $disabled ? 'true' : 'false' }}) {
            quill.disable();
        }

        container.__quill = quill;
    };

    initQuill();

    document.addEventListener('livewire:navigated', initQuill);
    document.addEventListener('livewire:load', initQuill); 
})();
</script>
@endpush
