import TomSelect from 'tom-select/dist/esm/tom-select.js';

const render = {
    option: (data, escape) => `<div>
        ${data.icon ? `<i class='${escape(data.icon)} me-2'></i>` : ''}
        <span>${escape(data.text)}</span>
    </div>`,
    item: (data, escape) => `<div>
        ${data.icon ? `<i class='${escape(data.icon)} me-2'></i>` : ''}
        ${escape(data.text)}
    </div>`,
};

const optionsOf = (value) => {
    if (value === null || value === undefined || value === '') {
        return [];
    }
    if (Array.isArray(value)) {
        return value.map((value) => ({ value: String(value) }));
    }
    if (typeof value === 'object') {
        return Object.entries(value).map(([value, text]) => ({ value, text }));
    }

    return [{ value: String(value) }];
};

const search = (url, query) => fetch(url, {
    method: 'POST',
    credentials: 'same-origin',
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
    },
    body: JSON.stringify({ data: { query } }),
}).then((response) => {
    if (!response.ok) {
        throw new Error(`The options could not be loaded (${response.status}).`);
    }

    return response.json();
});

function Select(Alpine) {
    Alpine.data('select', (config, value = config.value) => ({
        value,
        select: null,

        init() {
            const options = config.url !== null
                ? {
                    valueField: 'value',
                    labelField: 'text',
                    searchField: 'text',
                    allowEmptyOption: config.allowEmpty,
                    maxItems: config.multiple ? null : 1,
                    render,
                    shouldLoad: (query) => query.length > 2,
                    load: (query, callback) => {
                        search(config.url, query)
                            .then((data) => callback(data.data))
                            .catch(() => callback());
                    },
                }
                : {
                    create: config.create ?? true,
                    allowEmptyOption: config.allowEmpty,
                    render,
                };

            if (config.search === false && config.url === null) {
                options.controlInput = null;
            }
            if (config.dropdownParent) {
                options.dropdownParent = config.dropdownParent;
            }
            Object.assign(options, config.settings ?? {});

            const select = this.select = new TomSelect(this.$refs.select, options);

            const show = () => {
                const shown = optionsOf(this.value);
                const values = shown.map((option) => option.value);
                const current = [select.getValue()].flat().filter((value) => value !== '').map(String);
                if (values.length === current.length && values.every((value) => current.includes(value))) {
                    return;
                }

                shown.filter((option) => option.text !== undefined).forEach((option) => select.addOption(option));
                values.length ? select.setValue(values, true) : select.clear(true);
            };

            select.on('change', (value) => {
                this.value = value;
            });

            show();
            this.$watch('value', show);
        },

        destroy() {
            this.select?.destroy();
        },
    }));
}

export default Select;
