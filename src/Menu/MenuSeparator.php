<?php

namespace Svenbw\LaravelTabler\Menu;

class MenuSeparator
{
    public function __construct(private MenuGroup|MenuItemList $owner)
    {
        $this->owner = $owner;
    }

    public function addItem(string $name, ?string $route = null, array $arguments = []): MenuItem
    {
        return $this->owner->addItem($name, $route, $arguments);
    }

    public function isSeparator(): bool
    {
        return true;
    }
}
