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
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $errorKey = Form::errorKey($name);
    $isInvalid = isset($errors) && $errors->has($errorKey);
    $cols      = Form::colClass($col);
    $editorId  = 'quill_' . str_replace(['.', '[', ']'], '_', $name);
    $inputId   = $editorId . '_input';
    $isReadonly = $readonly || $attributes->has('readonly');

    if ($disabled || $isReadonly) {
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

    $entangler = \Svenbw\LaravelTabler\Helpers\WireModelEntangler::make($attributes);
    $config = [
        'theme' => $theme,
        'placeholder' => $placeholder ?? '',
        'readOnly' => (bool) $isReadonly,
        'disabled' => (bool) $disabled,
        'toolbar' => $resolvedToolbar,
        'model' => $entangler->modelName(),
    ];
@endphp

<div
    @class(['mb-3', $cols])
    x-data="{
        value: {{ $entangler->hasModel() ? $entangler->entangle() : 'null' }},
        init() {
            const config = @js($config);
            const container = this.$refs.editor;
            const hidden = this.$refs.input;

            if (typeof Quill === 'undefined' || container.__quill) return;

            const quill = new Quill(container, {
                theme: config.theme,
                placeholder: config.placeholder,
                readOnly: config.readOnly,
                modules: {
                    toolbar: config.toolbar,
                },
            });
            container.__quill = quill;

            const show = (html) => quill.setContents(quill.clipboard.convert({ html: html ?? '' }), 'silent');

            // getSemanticHTML gives an empty editor as <p></p> and every space as a no-break space, so lines never
            // wrap: '' when empty, so a required rule fails on it, and all but the last space of a run as a no-break
            // space. A tab would collapse, it is kept as four spaces. \x26 is &, the attribute would decode the entity
            const NBSP = '\x26nbsp;';
            const toHtml = () => {
                if (quill.getContents().ops.every((op) => typeof op.insert === 'string' && op.insert.trim() === '')) {
                    return '';
                }

                return quill.getSemanticHTML()
                    .replace(/\t/g, NBSP.repeat(4))
                    .replace(new RegExp('(?:' + NBSP + ')+', 'g'), (run) => NBSP.repeat(run.length / NBSP.length - 1) + ' ');
            };

            // What the editor holds, the hidden input posts it in a plain form
            let html = config.model ? (this.value ?? '') : hidden.value;
            hidden.value = html;
            if (html) {
                show(html);
            }

            quill.on('text-change', () => {
                html = toHtml();
                hidden.value = html;

                if (config.model) {
                    this.value = html;
                }
            });

            // The editor is wire:ignore'd, so a value changed on the server is applied here
            if (config.model) {
                this.$watch('value', (value) => {
                    if ((value ?? '') !== html) {
                        html = value ?? '';
                        hidden.value = html;
                        show(html);
                    }
                });
            }

            if (config.disabled) {
                quill.disable();
            }
        },
    }"
>
    <label @class(['form-label', 'required' => $attributes->get('required')]) for="{{ $inputId }}">
        {{ $label }}
    </label>

    <div wire:ignore>
        <div
            id="{{ $editorId }}"
            x-ref="editor"
            @class(['quill-editor', 'is-invalid' => $isInvalid])
            style="height: {{ (int) $height }}px;"
            @if($attributes->has('autofocus')) data-autofocus="true" @endif
        ></div>
    </div>

    <input
        type="hidden"
        id="{{ $inputId }}"
        x-ref="input"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $attributes->whereStartsWith('wire:')->filter(fn ($value, $key) => ! str_starts_with($key, 'wire:model')) }}
        {{ $attributes->whereStartsWith('data-') }}
    >

    @if($isInvalid)
        <div class="invalid-feedback d-block">{{ join(', ', $errors->get($errorKey)) }}</div>
    @endif
</div>
