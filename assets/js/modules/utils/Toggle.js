/**
 * Toggle utility function - toggles 'active' class on both the button and its target element.
 * The target element is identified by the button's href attribute, which should contain an ID.
 *
 * @param {HTMLElement} button - The button element that triggers the toggle
 * @returns {boolean|undefined} - Returns the active state if successful, undefined if there was an error
 *
 * @example
 * // HTML: <button href="#targetId" data-element="toggle">Toggle</button>
 * // JS:
 * import Toggle from './modules/utils/Toggle.js';
 * const button = document.querySelector('[data-element="toggle"]');
 * Toggle(button); // Toggles 'active' class on both button and target element
 */
export default function Toggle(button) {
    // Validate button element
    if (!button) {
        console.error('Toggle: Button element is required');
        return;
    }

    // Get target ID from href attribute
    const href = button.getAttribute('href');
    if (!href) {
        console.error('Toggle: Button must have an href attribute');
        return;
    }

    // Extract ID from href (remove # if present)
    const targetId = href.startsWith('#') ? href.substring(1) : href;

    // Find target element
    const target = document.getElementById(targetId);
    if (!target) {
        console.error(`Toggle: Target element with ID "${targetId}" not found`);
        return;
    }

    // Toggle active class on the button
    const isActive = button.classList.toggle('active');

    // Toggle active class on the target element with the same state as the button
    target.classList.toggle('active', isActive);

    return isActive;
}
