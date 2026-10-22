@props(['label', 'name' => null, 'id' => null, 'value' => 1, 'checked' => false, 'col' => null, 'disabled' => null, 'readonly' => null, 'inline' => false, 'hint' => null])
@include('tabler::components.partials.form-check', [
    'type' => 'checkbox',
    'switch' => false,
    'defaultMargin' => 'mb-2',
    'attributes' => $attributes,
])
