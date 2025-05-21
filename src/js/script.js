/**
 * Main application script that initializes all required functionality.
 * Uses a combination of immediate loading for critical components and
 * lazy loading for non-critical components to optimize performance.
 *
 * @module script
 */

import preloader from './modules/utils/preloader.js';
import scrollEvents from './modules/utils/scrollEvents.js';
import { initWow } from './modules/utils/wow.js';

/**
 * Initialize core functionality that should be loaded immediately
 */
async function initCoreFeatures() {
    preloader();
    scrollEvents();
    // Initialize WOW.js animations without blocking other operations
    initWow().catch(err => console.warn('WOW initialization error:', err));
}

/**
 * Initialize non-critical components with delayed loading
 */
function initDelayedComponents() {
    // Load Menu with low priority using requestIdleCallback
    if ('requestIdleCallback' in window) {
        requestIdleCallback(async () => {
            const { default: Menu } = await import(
                /* webpackChunkName: "menu" */
                './modules/Menu.js'
                );
            new Menu();
        });
    } else {
        // Fallback for browsers that don't support requestIdleCallback
        setTimeout(async () => {
            const { default: Menu } = await import('./modules/Menu.js');
            new Menu();
        }, 200);
    }
}

/**
 * Handle click events for dynamic components that should only be loaded when needed
 * @param {Event} e - Click event
 */
async function handleClickEvents(e) {
    // Popup handling
    if (e.target.matches('[data-element="popup-open"]')) {
        e.preventDefault();
        const { default: Popup } = await import('./modules/Popup.js');
        const popup = new Popup();
        popup.open(e.target);
    }

    // Toggle handling
    if (e.target.matches('[data-element="toggle"]')) {
        e.preventDefault();
        const { default: Toggle } = await import('./modules/utils/Toggle.js');
        Toggle(e.target);
    }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    initCoreFeatures();
    initDelayedComponents();

    // Set up event delegation for dynamically loaded components
    document.addEventListener('click', handleClickEvents);
});
