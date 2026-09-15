# Laravel Tabler

Blade components for the [Tabler](https://tabler.io) admin UI.

Requires PHP 8.1+, Laravel 12 or 13, and Livewire 3.7+.

## Install

```bash
composer require svenbw/laravel-tabler
php artisan vendor:publish --tag=tabler-config
```

The package ships no compiled assets. Your application builds them with Vite, so
point `tabler.vite` at your entry points (it defaults to `resources/sass/app.scss`
and `resources/js/app.js`).

## Usage

Register the menu, typically in a service provider. The navigation renders the
`main` group:

```php
use Svenbw\LaravelTabler\Tabler;

app(Tabler::class)->menu()->addGroup('main')
    ->addItem('Dashboard', 'dashboard')->icon('<i class="ti ti-home"></i>');
```

Everything else is a Blade component under the `tabler::` namespace, see
`resources/views/components`.

## Configuration

`config/tabler.php` covers the navigation style, the logo, linked routes and the
Vite entry points, each documented inline. Translations can be published with
`php artisan vendor:publish --tag=tabler-lang`.

## Credits

Built on [Tabler](https://github.com/tabler/tabler) by Paweł Kuna, MIT licensed.

## License

MIT.
