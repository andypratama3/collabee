const STORAGE_KEY = 'darkMode';

function getPreferredTheme() {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored !== null) return stored === 'true';
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

function applyTheme(isDark) {
    if (isDark) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    
    // Dispatch event for chart components to react
    window.dispatchEvent(new CustomEvent('darkModeChanged', { detail: { isDark } }));
}

function toggleTheme() {
    const isDark = !document.documentElement.classList.contains('dark');
    applyTheme(isDark);
    localStorage.setItem(STORAGE_KEY, isDark ? 'true' : 'false');
}

// Apply on initial load (don't write to storage if no preference exists yet)
applyTheme(getPreferredTheme());

// Listen for system preference changes (only if no manual override stored)
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    if (localStorage.getItem(STORAGE_KEY) === null) {
        applyTheme(e.matches);
    }
});

window.toggleDarkMode = toggleTheme;
