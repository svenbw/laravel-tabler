<?php

namespace Svenbw\LaravelTabler;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Svenbw\LaravelTabler\Helpers\BladeDirectives;

class BladeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::directive('ifDeleteDialog', [BladeDirectives::class, 'ifDeleteDialog']);
        Blade::directive('endifDeleteDialog', [BladeDirectives::class, 'endifDeleteDialog']);
        Blade::directive('deleteDialogAttribute', [BladeDirectives::class, 'deleteDialogAttribute']);
        Blade::directive('appVersion', [BladeDirectives::class, 'appVersion']);
        Blade::directive('appYear', [BladeDirectives::class, 'appYear']);
        Blade::directive('disabled', [BladeDirectives::class, 'disabled']);
    }
}
