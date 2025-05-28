/**
 * Controls visibility of "See More" buttons based on content height
 * @param {string} selector - CSS selector for toggle buttons
 *
 * Requirements:
 * - Button must have href attribute pointing to target content (#target-id)
 * - Target content must have data-max-height attribute (default: 100px)
 *
 * @example HTML:
 * <div id="content" data-max-height="300">Content...</div>
 * <button href="#content" data-element="toggle">See More</button>
 */
export default function SeeMore(selector) {
    document.querySelectorAll(selector).forEach(button => {
        const href = button.getAttribute('href');
        if (!href) return;

        const targetId = href.startsWith('#') ? href.substring(1) : href;

        const target = document.getElementById(targetId);
        if (!target) return;

        const targetMaxHeight = target.dataset.maxHeight ?? 100;

        button.hidden = target.offsetHeight < targetMaxHeight;
    });
}