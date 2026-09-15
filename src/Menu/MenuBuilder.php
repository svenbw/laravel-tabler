<?php

namespace Svenbw\LaravelTabler\Menu;

class MenuBuilder
{
    private array $groups;

    public function __construct()
    {
        $this->groups = [];
    }

    public function addGroup($name, int $priority = 0): MenuGroup
    {
        $group = new MenuGroup($name, $priority, $this);

        $this->groups[$name] = $group;

        return $group;
    }

    public function groups(): array
    {
        uasort($this->groups, fn (MenuGroup $g1, MenuGroup $g2) => $g1->priority() - $g2->priority());

        return $this->groups;
    }

    public function getGroup(string $name): MenuGroup
    {
        return $this->groups[$name];
    }
}
