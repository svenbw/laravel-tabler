const NBSP = '&nbsp;';

function QuillEditor(Alpine, { uploadUrl = null } = {}) {
    let loading = null;
    const loadQuill = () => (loading ??= import('../quill.js').then(({ default: registerQuill }) => registerQuill({ uploadUrl })));

    Alpine.data('quillEditor', (config, value = null) => ({
        value,
        quill: null,

        async init() {
            const Quill = await loadQuill();
            const container = this.$refs.editor;
            const hidden = this.$refs.input;
            if (container.__quill) {
                return;
            }

            const quill = this.quill = new Quill(container, {
                theme: config.theme,
                placeholder: config.placeholder,
                readOnly: config.readOnly,
                modules: {
                    toolbar: config.toolbar,
                },
            });
            container.__quill = quill;
            if (config.describedBy) {
                quill.root.setAttribute('aria-describedby', config.describedBy);
            }
            if (config.invalid) {
                quill.root.setAttribute('aria-invalid', 'true');
            }

            const show = (html) => quill.setContents(quill.clipboard.convert({ html: html ?? '' }), 'silent');

            const toHtml = () => {
                if (quill.getContents().ops.every((op) => typeof op.insert === 'string' && op.insert.trim() === '')) {
                    return '';
                }

                return quill.getSemanticHTML()
                    .replace(/\t/g, NBSP.repeat(4))
                    .replace(new RegExp('(?:' + NBSP + ')+', 'g'), (run) => NBSP.repeat(run.length / NBSP.length - 1) + ' ');
            };

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
            } else if (config.autofocus && !config.readOnly) {
                quill.setSelection(quill.getLength(), 0);
            }
        },
    }));
}

export default QuillEditor;
