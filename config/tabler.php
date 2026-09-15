<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    | Named routes the package links to. Every value is passed to route(), so
    | it has to be the name of a route the application defines. A name that
    | does not resolve throws a RouteNotFoundException at the moment the view
    | containing the link is rendered.
    |
    |     notifications  The "view all" button at the bottom of the
    |                    notifications dropdown in the header. Only resolved
    |                    when that dropdown is actually rendered.
    |
    */

    'routes' => [
        'notifications' => 'user.notifications',
    ],

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    | bar_style picks the navigation the base layout renders. The value is the
    | name of a partial in resources/views/components/partials/navbar, so an
    | application can drop its own partial in that namespace and name it here.
    | The styles that ship with the package:
    |
    |     'topbar'          horizontal bar, the menu on a second row
    |     'condensed-top'   horizontal bar, the menu beside the brand
    |     'overlap-topbar'  dark bar that the page content overlaps
    |     'sidebar'         vertical bar down the left
    |
    | Tabler::hasSidebar() reports whether the chosen style is a sidebar one,
    | for applications that need to adapt their own markup to match.
    |
    |     light_sidebar      pins the 'sidebar' bar to the light or the dark
    |                        Bootstrap theme. null follows the page theme
    |     light_topbar       the same, for the 'condensed-top' bar
    |     enable_top_header  only for 'sidebar'. Renders
    |                        partials.header.sidebar-top after the sidebar, an
    |                        extra header carrying the search form, the theme
    |                        switch, notifications and the profile menu
    |
    */

    'layout' => [
        'bar_style' => 'topbar',
        'light_sidebar' => true,
        'light_topbar' => null,
        'enable_top_header' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Extra views
    |--------------------------------------------------------------------------
    | Application views that the package renders inside its own chrome. Each
    | value is a view name, resolved with view() and rendered without any data,
    | or null to render nothing. A view name that does not exist throws.
    |
    |     top_bar  Somewhere to hang application specific controls, a tenant
    |              switcher or a quick action button for instance. Rendered
    |              beside the theme switch and the notifications bell by the
    |              'topbar' style, and in the vertical nav by 'sidebar'. The
    |              other bar styles ignore it.
    |
    */

    'views' => [
        'top_bar' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    | The images shown next to the application name in the navbar brand, one
    | per theme. `light` is shown in the light theme, `dark` in the dark theme.
    |
    | A value that starts with a slash or carries a scheme is used as the image
    | URL as-is:
    |
    |     '/img/logo.svg'                 a file in the public directory
    |     'https://cdn.example/logo.svg'  an absolute URL
    |     '//cdn.example/logo.svg'        protocol relative
    |     'data:image/svg+xml,...'        inlined
    |
    | Anything else is treated as a Vite asset path and resolved through
    | Vite::asset(), which is what the defaults below do. Note that a Vite path
    | must exist in the build manifest, otherwise Vite::asset() throws.
    |
    | Set `dark` to null to use the light image for both themes, or set both to
    | null to show the application name without an image.
    |
    */

    'logo' => [
        'light' => 'resources/images/logo.svg',
        'dark' => 'resources/images/logo-dark.svg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Vite
    |--------------------------------------------------------------------------
    | The entry points the layouts hand to @vite. The package ships no compiled
    | assets of its own, these are the application's, so each one has to exist
    | in its Vite build manifest.
    |
    | Set this to null, or an empty array, when the application loads its
    | assets some other way. The layouts then emit no @vite tag at all.
    |
    */

    'vite' => [
        'resources/sass/app.scss',
        'resources/js/app.js',
    ],

];
