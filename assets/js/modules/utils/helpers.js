/**
 * Scrolls page to specified element
 * @param {HTMLElement} element - Target element
 * @param {number} [offset=0] - Top offset in pixels
 * @param {('smooth'|'auto'|'instant')} [behavior='smooth'] - Scroll behavior
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
 * Initializes toggle buttons functionality
 */
export function toggleButton() {
    document.addEventListener('click', e => {
        const button = e.target.closest('[data-element="toggle"]');

        if (!button) return;

        e.preventDefault();
        const isActive = button.classList.toggle('active');
        const targetId = button.getAttribute('href');
        const target = document.getElementById(targetId);

        if (!target) return;

        target.classList.toggle('active', isActive);
    });
}

/**
 * Returns the DOM element by extracting the ID from the element's hash property.
 * @param {HTMLAnchorElement} element - Anchor element with a hash (e.g., #section).
 * @returns {HTMLElement|null} The target element or null if not found.
 */
export function getElementIdByHash(element) {
    const selector = element.hash.substring(1);
    return document.getElementById(selector);
}

/**
 * Handles navigation link click event
 * @param {Event} e - Click event
 * @param {HTMLAnchorElement} link - Clicked link
 * @param {Object} options - Configuration
 * @param {Function} [options.targetCallback] - Callback after navigation
 * @param {number} [options.offsetHeight=0] - Header offset
 */
export function handleNavigationClick(e, link, {targetCallback = null, offsetHeight = 0} = {}) {
    const selector = link.hash.substring(1);
    const target = document.getElementById(selector);

    // Same page link
    if (link.href === window.location.href) {
        e.preventDefault();
        scrollToElement(target);
        return;
    }

    // Hash link with an existing target
    if (link.hash && target) {
        e.preventDefault();
        scrollToElement(target, offsetHeight);
    }

    if (targetCallback) targetCallback();
}

/**
 * Sets up navigation links click handlers
 * @param {string} selector - Links selector
 * @param {Object} [options={}] - Configuration options
 * @param {Function} [options.targetCallback] - Callback function to execute after navigation
 * @param {number} [options.offsetHeight] - Offset height for scrolling
 */

export function initNavigationLinks(selector, options = {}) {
    document.addEventListener('click', (e) => {
        const link = e.target.closest(selector);
        if (!link) return;

        handleNavigationClick(e, link, options);
    });
}

/**
 * Checks if window scroll exceeds height
 * @param {number} height - Threshold in pixels
 * @returns {boolean}
 */
export function isWindowScroll(height) {
    return window.scrollY > height;
}

/**
 * Closes the menu if it is open and the close button exists.
 */
export function closeMenu() {
    const html = document.documentElement;
    const buttonMenuClose = document.querySelector('[data-element="menu-close"]');

    if (html.classList.contains('menu-opened') && buttonMenuClose) {
        buttonMenuClose.click();
    }
}