export const COOKIE_NAME = document.documentElement.dataset.themeCookie || 'theme';
export const COOKIE_DAYS = Number(document.documentElement.dataset.themeCookieDays) || 365;

const systemTheme = () => (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

const storedTheme = () => {
    const match = document.cookie.match(new RegExp('(?:^|; )' + COOKIE_NAME.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '=(light|dark)(?:;|$)'));

    return match ? match[1] : null;
};

const applyTheme = (theme) => document.documentElement.setAttribute('data-bs-theme', theme);

export const setTheme = (theme) => {
    document.cookie = `${COOKIE_NAME}=${theme}; path=/; max-age=${COOKIE_DAYS * 86400}; SameSite=Lax`
        + (window.location.protocol === 'https:' ? '; Secure' : '');

    applyTheme(theme);
};

export default function initTheme() {
    applyTheme(storedTheme() || systemTheme());

    document.addEventListener('click', (event) => {
        const theme = event.target.closest('[data-theme-switch]')?.dataset.themeSwitch;

        if (theme) {
            event.preventDefault();
            setTheme(theme);
        }
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
        if (storedTheme() === null) {
            applyTheme(event.matches ? 'dark' : 'light');
        }
    });
}
