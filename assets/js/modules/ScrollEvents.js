export default class ScrollEvents {
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