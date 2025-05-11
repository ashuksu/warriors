/**
 * Manages scroll-related UI elements:
 * - Controls visibility of the "scroll to top" button
 * - Updates header state based on scroll position
 */

export default class ScrollToTopButton {
	static init() {
		const html = document.documentElement;

		window.addEventListener('scroll', () => {
			const isScroll = window.scrollY > 300;
			const isScrollHeight = window.scrollY > document.getElementById('header').offsetHeight;

			document.querySelector('[data-button="top"]').classList.toggle('active', isScroll);
			html.dataset.scrolled = isScrollHeight;
		});
	}
}