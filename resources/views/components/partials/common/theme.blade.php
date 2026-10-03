{{--
    Applies the colour theme before anything is painted.

    It has to run here, in the head and not deferred: a theme applied from a
    module script arrives after the page is drawn, and every load flashes the
    light theme first. The choice a member made wins; without one the theme
    follows the system.

    The theme is written to a cookie as well, so the server knows which one the
    next request is rendered in; the system fallback is written too, otherwise
    the first request of a member who never touched the switches carries nothing.

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
        var stored = null;

        try {
            stored = window.localStorage.getItem('tabler-theme');
        } catch (error) {
            // A browser that refuses storage still gets a theme.
        }

        var theme = stored || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

        document.documentElement.setAttribute('data-bs-theme', theme);

        document.cookie = 'theme=' + theme + '; path=/; max-age=31536000; SameSite=Lax'
            + (window.location.protocol === 'https:' ? '; Secure' : '');
    })();
</script>
