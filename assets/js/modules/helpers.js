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