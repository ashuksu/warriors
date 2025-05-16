import {isWindowScroll} from "./helpers.js";

/**
 * Initializes scroll event handlers with requestAnimationFrame for performance
 */
export default function scrollEvents() {
    let ticking = false;

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                setHeaderScrolledState();
                buttonUpActivator(300);
                ticking = false;
            });
            ticking = true;
        }
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
export function buttonUpActivator(height) {
    const buttonUp = document.querySelector('[data-action="up"]');

    if (!buttonUp) return;

    buttonUp.classList.toggle('active', isWindowScroll(height));
}
