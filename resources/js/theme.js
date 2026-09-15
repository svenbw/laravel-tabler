const STORAGE_KEY = 'tabler-theme';
const COOKIE_NAME = 'theme';
const COOKIE_MAX_AGE = 60 * 60 * 24 * 365;

const systemTheme = () => (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

const storedTheme = () => {
    try {
        return window.localStorage.getItem(STORAGE_KEY);
    } catch (error) {
        return null;
    }
};

const applyTheme = (theme) => document.documentElement.setAttribute('data-bs-theme', theme);

const rememberInCookie = (theme) => {
    document.cookie = `${COOKIE_NAME}=${theme}; path=/; max-age=${COOKIE_MAX_AGE}; SameSite=Lax`
        + (window.location.protocol === 'https:' ? '; Secure' : '');
};

export const setTheme = (theme) => {
    try {
        window.localStorage.setItem(STORAGE_KEY, theme);
    } catch (error) {
        // Remembering is a convenience, switching is not.
    }

    rememberInCookie(theme);

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
            const theme = event.matches ? 'dark' : 'light';

            rememberInCookie(theme);
            applyTheme(theme);
        }
    });
}
