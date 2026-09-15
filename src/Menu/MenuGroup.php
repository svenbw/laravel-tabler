<?php

namespace Svenbw\LaravelTabler\Menu;

use Illuminate\Support\Facades\Gate;

class MenuGroup
{
    private array $items;

    private ?array $allowsGates = null;

    private ?array $deniesGates = null;

    public function __construct(private string $name, private int $priority, private ?MenuBuilder $owner = null)
    {
        $this->name = $name;
        $this->priority = $priority;
        $this->owner = $owner;
        $this->items = [];
    }

    public function endGroup(): MenuBuilder
    {
        return $this->owner;
    }

    public function addGroup(string $name, int $priority): self
    {
        return $this->owner->addGroup($name, $priority);
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

    public function name(): string
    {
        return $this->name;
    }

    public function items(): array
    {
        if ($this->allowsGates) {
            if (Gate::allows($this->allowsGates)) {
                return [];
            }
        }

        if ($this->deniesGates) {
            if (! Gate::allows($this->deniesGates)) {
                return [];
            }
        }

        return array_filter($this->items, fn (MenuItem|MenuSeparator $item) => $item->isSeparator() || $item->isAllowed());
    }

    public function priority(): int
    {
        return $this->priority;
    }

    public function allows(array|string $gates): self
    {
        $this->allowsGates = is_array($gates) ? $gates : [$gates];

        return $this;
    }

    public function denies(array|string $gates): self
    {
        $this->deniesGates = is_array($gates) ? $gates : [$gates];

        return $this;
    }
}
