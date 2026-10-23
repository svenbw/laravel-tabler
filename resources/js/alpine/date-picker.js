import flatpickr from 'flatpickr';
import { Dutch } from 'flatpickr/dist/esm/l10n/nl.js';
import { French } from 'flatpickr/dist/esm/l10n/fr.js';
import { German } from 'flatpickr/dist/esm/l10n/de.js';

Object.assign(flatpickr.l10ns, { nl: Dutch, fr: French, de: German });

function DatePicker(Alpine) {
    Alpine.data('datePicker', (config, value = config.value) => ({
        value,
        picker: null,

        init() {
            this.picker = flatpickr(this.$refs.input, {
                ...config.options,
                locale: flatpickr.l10ns[config.locale] ? config.locale : 'default',
                defaultDate: this.value || null,
                onChange: (selectedDates, dateStr) => {
                    this.value = dateStr;
                },
            });

            if (this.picker.altInput && this.$refs.input.id) {
                this.picker.altInput.id = this.$refs.input.id;
                this.$refs.input.removeAttribute('id');
            }

            this.$watch('value', (value) => {
                if ((value ?? '') !== this.picker.input.value) {
                    this.picker.setDate(value || null, false);
                }
            });
        },

        destroy() {
            this.picker?.destroy();
        },
    }));
}

export default DatePicker;
