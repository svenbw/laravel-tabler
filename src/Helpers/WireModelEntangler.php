<?php

namespace Svenbw\LaravelTabler\Helpers;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;
use Illuminate\View\ComponentAttributeBag;

class WireModelEntangler
{
    private ?string $modifiers = null;

    private ?string $model = null;

    public function __construct(ComponentAttributeBag $attributes, string $name = 'model')
    {
        if ($attributes->whereStartsWith('wire:model')->isEmpty()) {
            return;
        }

        $wireModel = $attributes->wire($name);

        $this->model = $wireModel->value;
        $wireModelModifiers = $attributes->wire('model')->modifiers()->join('.');
        if (! empty($wireModelModifiers)) {
            $this->modifiers = $wireModelModifiers;
        }
    }

    public static function make(ComponentAttributeBag $attributes, string $name = 'model'): self
    {
        return new self($attributes, $name);
    }

    public function hasModel(): bool
    {
        return $this->model !== null;
    }

    public function modelName(): ?string
    {
        return $this->model;
    }

    public function entangle(): string
    {
        return sprintf('$wire.entangle(\'%s\')%s', $this->model, $this->modifiers ? '.'.$this->modifiers : '');
    }

    public function xData(string $component, mixed $config): HtmlString
    {
        $arguments = Js::from($config)->toHtml();
        if ($this->hasModel()) {
            $arguments .= ', '.e($this->entangle());
        }

        return new HtmlString($component.'('.$arguments.')');
    }

    public function wireProperty(): string
    {
        return $this->model ? sprintf('$wire.%s', $this->model) : '';
    }
}
