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

/**
 * Handles navigation link clicks with smooth scrolling and menu integration
 * @param {Event} e - Click event object
 * @param {HTMLAnchorElement} link - The clicked navigation link
 * @param {Object} options - Configuration options
 * @param {Function} [options.targetCallback] - Optional callback function to execute after navigation (e.g., closing a menu)
 * @param {number} [options.offsetHeight=0] - Header height in pixels to offset scroll position
 * @returns {void}
 *
 * @description
 * - Handles both same-page and cross-page navigation with hash links
 * - Provides smooth scrolling to target elements
 * - Supports offset for fixed headers
 * - Can trigger a callback after navigation (useful for mobile menu closing)
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
 * Initializes click handlers for navigation links matching the specified selector
 * @param {string} selector - CSS selector for navigation links
 * @param {Object} [options={}] - Configuration options passed to handleNavigationClick
 * @param {Function} [options.targetCallback] - Optional callback after navigation
 * @param {number} [options.offsetHeight] - Header height for scroll offset
 * @returns {void}
 *
 * @example
 * // Initialize navigation for all links with class 'nav-link'
 * initNavigationLinks('.nav-link', {
 *   offsetHeight: 60, // 60px header offset
 *   targetCallback: () => closeMenu()
 * });
 */

export function initNavigationLinks(selector, options = {}) {
    document.addEventListener('click', (e) => {
        const link = e.target.closest(selector);
        if (!link) return;

        // e.preventDefault;
        handleNavigationClick(e, link, options);
    });
}
