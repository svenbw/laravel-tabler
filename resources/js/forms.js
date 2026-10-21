// form.select
import TomSelect from 'tom-select/dist/esm/tom-select.js';
window.TomSelect = TomSelect;

// form.decimal-input
import IMask from 'imask';
window.IMask = IMask;

// form.datepicker
import flatpickr from 'flatpickr';
import { Dutch } from 'flatpickr/dist/esm/l10n/nl.js';
flatpickr.l10ns.nl = Dutch;
window.flatpickr = flatpickr;
