import {isWindowScroll} from "./helpers.js";

/**
 * Initializes scroll event handlers
 */
export default function scrollEvents() {
    window.addEventListener('scroll', () => {
        setHeaderScrolledState();
        buttonTopActivator(300);
    });
}

/**
 * Updates header scroll state
 */
export function setHeaderScrolledState() {
    const html = document.documentElement;
    const header = document.getElementById('header').offsetHeight
    html.dataset.scrolled = isWindowScroll(header);
}

/**
 * Controls "back to top" button visibility
 * @param {number} height - Activation threshold
 */
export function buttonTopActivator(height) {
    const buttonTop = document.querySelector('[data-element="up"]');

    if (!buttonTop) return;

    buttonTop.classList.toggle('active', isWindowScroll(height));
}