<?php

namespace Svenbw\LaravelTabler\Menu;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Gate;

class MenuItem
{
    private ?array $activeForRoutes = null;

    private bool $activeForChildRoutes = false;

    private ?string $icon = null;

    private MenuItemList $subItems;

    private ?array $allowsGates = null;

    private $id = null;

    public function __construct(private MenuGroup|MenuItemList $owner, private string $name, private ?string $route = null, private array $arguments = [])
    {
        $this->name = $name;
        $this->route = $route;
        $this->arguments = $arguments;
        $this->owner = $owner;
        $this->subItems = new MenuItemList;
    }

    public function addItem(string $name, ?string $route = null, array $arguments = []): self
    {
        return $this->owner->addItem($name, $route, $arguments);
    }

    public function addSeperator(): MenuSeparator
    {
        return $this->owner->addSeperator($this);
    }

    public function addGroup(string $name): MenuGroup
    {
        return $this->owner->addGroup($name, 0);
    }

    public function withSubItems(callable $callback)
    {
        $callback($this->subItems);

        return $this;
    }

    public function icon(string|Htmlable $icon): self
    {
        $this->icon = ($icon instanceof Htmlable) ? $icon->toHtml() : $icon;

        return $this;
    }

    public function activeForChildRoutes()
    {
        $this->activeForChildRoutes = true;

        return $this;
    }

    public function activeForRoute(array|string|null $route)
    {
        if (is_array($route)) {
            $this->activeForRoutes = array_merge([$this->route], $route);
        } elseif (is_string($route)) {
            $this->activeForRoutes = [$this->route, $route];
        } else {
            $this->activeForRoutes = null;
        }

        return $this;
    }

    public function allows(array|string $gates): self
    {
        $this->allowsGates = is_array($gates) ? $gates : [$gates];

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function hasIcon(): bool
    {
        return $this->icon !== null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function hasSubItems(): bool
    {
        return $this->subItems->hasItems();
    }

    public function subItems(): array
    {
        return $this->subItems->items();
    }

    public function subItemsToArray(): array
    {
        return $this->subItems->itemsToArray();
    }

    public function toArray(): array
    {
        return [
            'title' => $this->name,
            'href' => $this->getRoute(),
            'active' => $this->isActive(),
        ];
    }

    public function isSeparator(): bool
    {
        return false;
    }

    public function isActive(): bool
    {
        if ($this->activeForChildRoutes) {
            if (request()->routeIs($this->activeForChildRoutes)) {
                return true;
            }
        } elseif ($this->activeForRoutes !== null) {
            if (request()->routeIs($this->activeForRoutes)) {
                return true;
            }
        }

        if (request()->routeIs([$this->route])) {
            return true;
        }

        foreach ($this->subItems() as $item) {
            if ($item->isActive()) {
                return true;
            }
        }

        return false;
    }

    public function isAllowed(): bool
    {
        return Gate::allows($this->allowsGates);
    }

    public function getRoute(): string
    {
        if ($this->route === null) {
            return 'javascript:void(0);';
        }

        if ($this->route === '#') {
            return '#';
        }

        return route($this->route, $this->arguments);
    }

    public function getId(): string
    {
        if ($this->id === null) {
            $this->id = 'sb'.md5(serialize([$this->name, $this->route, $this->icon, $this->arguments]));
        }

        return $this->id;
    }
}
