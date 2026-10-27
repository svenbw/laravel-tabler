<?php

namespace Svenbw\LaravelTabler\View\Components\Form;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use Svenbw\LaravelTabler\Helpers\Form;
use Svenbw\LaravelTabler\Helpers\WireModelEntangler;

class Select extends Component
{
    public string $id;

    public function __construct(
        public string $name,
        public Htmlable|string|null $label = null,
        ?string $id = null,
        public mixed $value = '',
        public ?string $col = null,
        public ?array $options = null,
        public ?array $optionGroups = null,
        public bool $multiple = false,
        public bool $allowEmpty = false,
        public Htmlable|string|null $hint = null,
        public ?string $url = null,
        public bool $readonly = false,
        public bool $disabled = false,
        public bool $required = false,
        public bool $create = true,
        public bool $search = true,
        public ?string $dropdownParent = null,
        public array $settings = [],
    ) {
        $this->id = $id ?? str_replace('[]', '', $name);
    }

    public function errorKey(): string
    {
        return Form::errorKey($this->name);
    }

    public function cols(): string
    {
        return Form::colClass($this->col);
    }

    public function config(): array
    {
        return [
            'value' => $this->value,
            'url' => $this->url,
            'multiple' => $this->multiple,
            'allowEmpty' => $this->allowEmpty,
            'create' => $this->create,
            'search' => $this->search,
            'readonly' => $this->readonly,
            'dropdownParent' => $this->dropdownParent,
            'settings' => (object) $this->settings,
        ];
    }

    public function xData(): HtmlString
    {
        return WireModelEntangler::make($this->attributes)->xData('select', $this->config());
    }

    public function isSelected(int|string $key): bool
    {
        if (is_array($this->value)) {
            return in_array((string) $key, array_map('strval', array_is_list($this->value) ? $this->value : array_keys($this->value)), true);
        }

        return is_scalar($this->value) && $this->value !== '' && (string) $this->value === (string) $key;
    }

    public function render()
    {
        return view('tabler::components.form.select');
    }
}
