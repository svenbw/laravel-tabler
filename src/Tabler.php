<?php

namespace Svenbw\LaravelTabler;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Container\Container;
use Svenbw\LaravelTabler\Menu\MenuBuilder;
use Svenbw\LaravelTabler\Services\NotificationManager;

class Tabler
{
    private static ?Closure $dateFormatResolver = null;

    private MenuBuilder $menu;

    private NotificationManager $notifications;

    public ?string $detailTitle = null;

    public function __construct(protected Container $container)
    {

        $this->menu = new MenuBuilder;
        $this->notifications = new NotificationManager;
    }

    public function menu(): MenuBuilder
    {
        return $this->menu;
    }

    public function notifications(): NotificationManager
    {
        return $this->notifications;
    }

    public function addDetailTitle(string|array|null $title): void
    {
        if (is_array($title)) {
            $this->detailTitle = implode(' - ', array_reverse($title));
        } else {
            $this->detailTitle = $title;
        }
    }

    public function websiteTitle(?array $breadCrumbs = null): string
    {
        $title = [];

        if ($breadCrumbs !== null) {
            $breadCrumb = array_pop($breadCrumbs);
            $title[] = is_string($breadCrumb) ? __($breadCrumb) : '';
        }

        if ($this->detailTitle !== null) {
            $title[] = $this->detailTitle;
        }

        $siteTitle = config('app.name');

        $title[] = $siteTitle;

        return implode(' - ', array_filter($title));
    }

    public function barStyle(): string
    {
        return config('tabler.layout.bar_style');
    }

    public function hasSidebar(): bool
    {
        return str_contains(config('tabler.layout.bar_style'), 'sidebar');
    }

    /**
     * Resolve the date picker format at render time, e.g. from the preferences of the user.
     */
    public static function dateFormatUsing(?Closure $resolver): void
    {
        self::$dateFormatResolver = $resolver;
    }

    public static function dateFormat(): string
    {
        if (self::$dateFormatResolver) {
            return (self::$dateFormatResolver)();
        }

        return config('tabler.date_format', 'Y-m-d');
    }

    public static function dateLocale(): string
    {
        $locale = app()->getLocale();

        return config('tabler.date_locales.'.$locale, $locale);
    }

    public static function localeDateFormat(): string
    {
        $format = Carbon::now()->locale(self::dateLocale())->getIsoFormats()['L'];

        return strtr($format, [
            'YYYY' => 'Y',
            'YY' => 'y',
            'MMMM' => 'F',
            'MMM' => 'M',
            'MM' => 'm',
            'M' => 'n',
            'DD' => 'd',
            'D' => 'j',
        ]);
    }
}
