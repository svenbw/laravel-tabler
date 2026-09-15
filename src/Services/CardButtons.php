<?php

namespace Svenbw\LaravelTabler\Services;

class CardButtons
{
    public ?string $submitAction = null;

    private array $buttons = [];

    public function __construct($config)
    {
        if (! $config || count($config) === 0) {
            return null;
        }

        $this->buttons = [];
        foreach ($config as $key => $button) {
            $buttonData = $button;
            $buttonData['isSubmit'] = false;
            $buttonData['liveWireAction'] = '';

            if (array_key_exists('submit', $button) && ! array_key_exists('wire:click', $button)) {
                $buttonData['isSubmit'] = true;
                if (! array_key_exists('color', $button)) {
                    $buttonData['color'] = 'primary';
                }
                if (is_string($button['submit'])) {
                    $this->submitAction = $button['submit'];
                } else {
                    $this->submitAction = '';
                }
            }
            if (in_array('submit', $button, true)) {
                $buttonData['isSubmit'] = true;
                $this->submitAction = '';
                if (! array_key_exists('color', $button)) {
                    $buttonData['color'] = 'primary';
                }
            }
            if (in_array('disabled', $button, true)) {
                $buttonData['disabled'] = true;
                unset($buttonData[$key]);
            } elseif (array_key_exists('disabled', $button)) {
                if ($button['disabled'] === false) {
                    unset($buttonData['disabled']);
                }
            }
            if (array_key_exists('wire:click', $button)) {
                $buttonData['liveWireAction'] = 'wire:click='.$button['wire:click'];
                unset($buttonData['wire:click']);
                if (array_key_exists('submit', $button) && ! array_key_exists('color', $button)) {
                    $buttonData['color'] = 'primary';
                }

            }
            if (array_key_exists('wire:submit', $button)) {
                $this->submitAction = 'wire:submit.prevent='.$button['wire:submit'];
                $buttonData['isSubmit'] = true;
                unset($buttonData['wire:submit']);
            }
            $this->buttons[] = $buttonData;
        }
    }

    public static function make($config): self
    {
        return new self($config);
    }

    public function submitAction(): ?string
    {
        return $this->submitAction;
    }

    public function isEmpty(): bool
    {
        return $this->buttons === [];
    }

    public function get(): ?array
    {
        return $this->buttons;
    }
}
