@props(['item'])
@if ($item->hasSubItems())
    @each('tabler::components.partials.navbar.multilevel', $item->subItems(), 'item')
@else
    <x-tabler::partials.navbar.single-item
        :item="$item"
    />
@endif
