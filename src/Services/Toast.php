<?php

namespace Svenbw\LaravelTabler\Services;

use Illuminate\Session\Store;
use Livewire\Component;

class Toast
{
    private Store $session;

    private ?Component $sourceComponent = null;

    private const DISPATCH_TO = 'toast';

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function dispatchFrom(Component $sourceComponent): self
    {
        $toast = clone $this;
        $toast->sourceComponent = $sourceComponent;

        return $toast;
    }

    public function success(string $message, ?string $title = null, ?int $delay = 5000): self
    {
        $this->flash($message, $title, 'success', $delay);

        return $this;
    }

    public function error(string $message, ?string $title = null, ?int $delay = 5000): self
    {
        $this->flash($message, $title, 'error', $delay);

        return $this;
    }

    public function flash(string $message, ?string $title, string $type, ?int $delay, ?string $image = null): void
    {
        if ($this->sourceComponent) {
            $this->sourceComponent->dispatch(self::DISPATCH_TO, message: $message, title: $title, type: $type, delay: $delay, image: $image);

            return;
        }

        $this->session->flash('toast', [
            'message' => $message,
            'title' => $title,
            'type' => $type,
            'delay' => $delay,
            'image' => $image,
        ]);
    }
}
