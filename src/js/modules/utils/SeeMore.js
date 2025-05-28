/**
 * Controls visibility of "See More" buttons based on content height
 * @param {string} selector - CSS selector for toggle buttons
 *
 * Requirements:
 * - Button must have a href attribute pointing to target content (#target-id)
 * - Target content must have data-max-height attribute with values 100, 200, 300 or 400 (px)
 * - If data-max-height is not set, the default height limit is 100px
 *
 * @example HTML:
 * <!-- Set custom max height -->
 * <div id="content" data-max-height="300">Content...</div>
 * <button href="#content" data-element="toggle">See More</button>
 *
 * <!-- Use default 100px height limit -->
 * <div id="content-default">Content...</div>
 * <button href="#content-default" data-element="toggle">See More</button>
 */
export default function SeeMore(selector) {
    document.querySelectorAll(selector).forEach(button => {
        const href = button.getAttribute('href');
        if (!href) return;

        const targetId = href.startsWith('#') ? href.substring(1) : href;

        const target = document.getElementById(targetId);
        if (!target) return;

        const targetMaxHeight = target.dataset.maxHeight ?? 100;

        button.hidden = target.scrollHeight < targetMaxHeight;
    });
}