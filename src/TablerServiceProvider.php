<?php

namespace Svenbw\LaravelTabler;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Svenbw\LaravelTabler\Services\Toast;
use Svenbw\LaravelTabler\View\Components\Form\Card as FormCard;

class TablerServiceProvider extends ServiceProvider
{
    /**
     * The prefix to use for register/load the package resources.
     */
    protected string $packagePrefix = 'tabler';

    private function packagePath(string $path): string
    {
        return dirname(__DIR__).'/'.ltrim($path, '/');
    }

    private function publishKey(string $key): string
    {
        return $this->packagePrefix.'-'.$key;
    }

    public function boot()
    {
        $this->loadTranslations();
        $this->loadViews();
        $this->loadConfig();
    }

    public function register()
    {
        $this->app->singleton(Tabler::class, fn (Container $app) => new Tabler($app));
        $this->app->singleton('toast', fn (Container $app) => $app->make(Toast::class));

        $this->app->register(BladeServiceProvider::class);
    }

    private function loadViews(): void
    {
        $this->loadViewsFrom($this->packagePath('resources/views'), $this->packagePrefix);

        $this->loadViewComponentsAs($this->packagePrefix, [
            'form-card' => FormCard::class,
        ]);
    }

    private function loadConfig(): void
    {
        $path = $this->packagePath('config/tabler.php');
        $this->mergeConfigRecursivelyFrom($path, $this->packagePrefix);

        $this->publishes([
            $path => config_path($this->packagePrefix.'.php'),
        ], $this->publishKey('config'));
    }

    private function mergeConfigRecursivelyFrom(string $path, string $key): void
    {
        if ($this->app->configurationIsCached()) {
            return;
        }

        $config = $this->app->make('config');

        $config->set($key, $this->mergeConfig(require $path, $config->get($key, [])));
    }

    private function mergeConfig(array $package, array $app): array
    {
        foreach ($package as $key => $value) {
            if (! array_key_exists($key, $app)) {
                $app[$key] = $value;

                continue;
            }

            // Keyed arrays merge key by key, so overriding one icon or one logo
            // keeps the rest. A list is replaced outright, otherwise shortening
            // one would leave the tail of the default behind.
            if (is_array($value) && is_array($app[$key]) && ! array_is_list($value) && ! array_is_list($app[$key])) {
                $app[$key] = $this->mergeConfig($value, $app[$key]);
            }
        }

        return $app;
    }

    private function loadTranslations(): void
    {
        $path = $this->packagePath('lang');
        $this->loadTranslationsFrom($path, $this->packagePrefix);

        $this->publishes([
            $path => $this->app->langPath('vendor/'.$this->packagePrefix),
        ], $this->publishKey('lang'));
    }
}
