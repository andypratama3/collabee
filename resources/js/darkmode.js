const STORAGE_KEY = 'collabee-dark-mode';

function getPreferredTheme() {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored) return stored === 'dark';
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

function applyTheme(isDark) {
    if (isDark) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    localStorage.setItem(STORAGE_KEY, isDark ? 'dark' : 'light');
}

function toggleTheme() {
    const isDark = !document.documentElement.classList.contains('dark');
    applyTheme(isDark);
}

applyTheme(getPreferredTheme());

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    if (!localStorage.getItem(STORAGE_KEY)) {
        applyTheme(e.matches);
    }
});

window.toggleDarkMode = toggleTheme;
