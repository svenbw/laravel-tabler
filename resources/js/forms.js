import TomSelect from 'tom-select/dist/esm/tom-select.js';
import IMask from 'imask';
import flatpickr from 'flatpickr';

import Select from './alpine/select.js';
import DecimalInput from './alpine/decimal-input.js';
import DatePicker from './alpine/date-picker.js';
import Autosize from './alpine/autosize.js';

Object.assign(window, { TomSelect, IMask, flatpickr });

export const plugins = [Select, DecimalInput, DatePicker, Autosize];

export default function install(Alpine) {
    plugins.forEach((plugin) => Alpine.plugin(plugin));
}
