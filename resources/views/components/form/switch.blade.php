@props(['label', 'name' => null, 'id' => null, 'value' => 1, 'checked' => false, 'col' => null, 'disabled' => null, 'readonly' => null, 'inline' => false, 'hint' => null])
@include('tabler::components.partials.form-check', [
    'type' => 'checkbox',
    'switch' => true,
    'defaultMargin' => 'mb-3',
    'attributes' => $attributes,
])
