<?php

namespace Svenbw\LaravelTabler\Menu;

class MenuItemList
{
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function addItem(string $name, ?string $route = null, array $arguments = []): MenuItem
    {
        $item = new MenuItem($this, $name, $route, $arguments);
        $this->items[] = $item;

        return $item;
    }

    public function addSeperator(): MenuSeparator
    {
        $item = new MenuSeparator($this);
        $this->items[] = $item;

        return $item;
    }

    public function items(): array
    {
        return array_filter($this->items, fn (MenuItem $item) => $item->isAllowed());
    }

    public function itemsToArray(): array
    {
        $result = [];
        foreach ($this->items() as $item) {
            $result[] = $item->toArray();
        }

        return $result;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
