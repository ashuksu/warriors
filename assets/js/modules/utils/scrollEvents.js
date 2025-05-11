import {isWindowScroll} from "./helpers.js";

/**
 * Attaches a scroll event listener to the window to trigger specific actions.
 */
export default function scrollEvents() {
    window.addEventListener('scroll', () => {
        setHeaderScrolledState();
        buttonTopActivator(300);
    });
}
/**
 * Sets the scrolled state for the header based on the window's scroll position.
 * Updates a `data-scrolled` attribute on the HTML element.
 */
export function setHeaderScrolledState() {
    const html = document.documentElement;
    const header = document.getElementById('header').offsetHeight
    html.dataset.scrolled = isWindowScroll(header);
}

/**
 * Toggles the "active" state of the "back to top" button based on the window scroll position.
 * @param {number} height - The scroll position threshold (in pixels) to activate the button.
 */
export function buttonTopActivator(height) {
    const buttonTop = document.querySelector('[data-button="top"]');

    if (!buttonTop) return;

    buttonTop.classList.toggle('active', isWindowScroll(height));
}