{{--
    Applies the colour theme before anything is painted.

    It has to run here, in the head and not deferred: a theme applied from a
    module script arrives after the page is drawn, and every load flashes the
    light theme first. The choice a member made wins; without one the theme
    follows the system.

    Until the stylesheet has arrived the browser paints its own canvas, white,
    and moving to another page flashes it. The dark canvas is given here, in
    the colour of Tabler's dark body, so there is nothing to see in between.
--}}
<style>
    html[data-bs-theme=dark] {
        color-scheme: dark;
        background-color: #111827;
    }
</style>
<script>
    (function () {
        var name = @js(config('tabler.theme_cookie.name', 'theme'));
        var days = @js((int) config('tabler.theme_cookie.days', 365));
        var root = document.documentElement;

        root.dataset.themeCookie = name;
        root.dataset.themeCookieDays = days;

        var stored = null;

        document.cookie.split('; ').forEach(function (pair) {
            var index = pair.indexOf('=');

            if (pair.slice(0, index) === name && /^(light|dark)$/.test(pair.slice(index + 1))) {
                stored = pair.slice(index + 1);
            }
        });

        root.setAttribute('data-bs-theme', stored || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'));
    })();
</script>
