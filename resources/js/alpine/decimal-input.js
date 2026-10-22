import IMask from 'imask';

function DecimalInput(Alpine) {
    Alpine.data('decimalInput', (config, wireValue = undefined) => ({
        mask: null,
        value: '',
        wireValue: wireValue ?? null,

        init() {
            this.mask = IMask(this.$refs.input, {
                mask: Number,
                scale: config.precision,
                signed: config.signed,
                thousandsSeparator: config.thousandsSeparator,
                padFractionalZeros: config.precision > 0,
                normalizeZeros: true,
                radix: config.decimalSeparator,
                mapToRadix: [config.decimalSeparator === '.' ? ',' : '.'],
                min: config.min,
                max: config.max,
            });

            let start = this.wireValue ?? config.value;
            if (start !== null && start !== undefined && start !== '') {
                this.mask.unmaskedValue = String(start);
            }
            this.value = this.mask.unmaskedValue;

            this.mask.on('accept', () => {
                this.value = this.mask.unmaskedValue;
                this.wireValue = this.value === '' ? null : parseFloat(this.value);
            });

            if (wireValue !== undefined) {
                this.$watch('wireValue', (newValue) => {
                    let current = this.mask.unmaskedValue === '' ? null : parseFloat(this.mask.unmaskedValue);
                    let incoming = newValue === null || newValue === '' ? null : parseFloat(newValue);
                    if (current !== incoming) {
                        this.mask.unmaskedValue = incoming === null ? '' : String(incoming);
                        this.value = this.mask.unmaskedValue;
                    }
                });
            }
        },

        destroy() {
            this.mask?.destroy();
        },
    }));
}

export default DecimalInput;
