/**
 * Dark mode — single source of truth is the 'dark' class on <html>.
 * 
 * Flow:
 * 1. FOUC script in <head> reads localStorage and sets class BEFORE render.
 * 2. Alpine reads the class on init and tracks it as reactive `darkMode` for UI icons.
 * 3. toggleDarkMode() updates class + localStorage + dispatches event.
 * 4. On wire:navigate (SPA navigation), the <html> persists so class stays.
 *    Alpine re-syncs via livewire:navigated listener.
 * 5. This module provides a global fallback toggle and handles system preference changes.
 */

// Global toggle for non-Alpine contexts
window.toggleDarkMode = function() {
    const isDark = !document.documentElement.classList.contains('dark');
    document.documentElement.classList.toggle('dark', isDark);
    localStorage.setItem('darkMode', isDark ? 'true' : 'false');
    window.dispatchEvent(new CustomEvent('darkModeChanged', { detail: { isDark } }));
};

// System preference changes (only when no manual preference stored)
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    if (localStorage.getItem('darkMode') === null) {
        document.documentElement.classList.toggle('dark', e.matches);
        window.dispatchEvent(new CustomEvent('darkModeChanged', { detail: { isDark: e.matches } }));
    }
});
