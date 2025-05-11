/**
 * Smoothly scrolls to specified element
 * @param {HTMLElement} element - A target element to scroll to
 * @param {number} [offset=0] - Offset from element's top in pixels
 * @param {('smooth'|'auto'|'instant')} [behavior='smooth'] - Scroll behavior type
 */

export function scrollToElement(element, offset = 0, behavior = 'smooth') {
    if (!element) return;

    const top = element.offsetTop - offset;

    window.scrollTo({
        top,
        behavior
    });
}

/**
 * Sets up click event delegation for toggle buttons in the document.
 * Handles elements with [data-button="toggle"] attribute.
 * When clicked:
 * - Toggles 'active' class on the button
 * - Toggles 'active' class on the target element (specified by button's href attribute)
 * - Prevents default click behavior
 *
 * @example
 * // HTML structure:
 * // <button data-button="toggle" href="target-id">Toggle Button</button>
 * // <div id="target-id">Target Content</div>
 *
 * toggleButton(); // Initialize toggle functionality
 */

export function toggleButton() {
    document.addEventListener('click', e => {
        const button = e.target.closest('[data-button="toggle"]');

        if (!button) return;

        e.preventDefault();
        const isActive = button.classList.toggle('active');
        const targetId = button.getAttribute('href');
        const target = document.getElementById(targetId);

        if (!target) return;

        target.classList.toggle('active', isActive);
    });
}