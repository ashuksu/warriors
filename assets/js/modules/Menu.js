import Overlay from './Overlay.js';
export default class Menu {
	constructor() {
		this.overlay = new Overlay();

		this.html = document.documentElement;
		this.menu = document.getElementById('menu');
		this.menuLinks = document.querySelectorAll('[data-menu="link"]');
		this.header = document.getElementById('header');
		this.content = document.getElementById('content');

		this.handleClick = this.handleClick.bind(this);
		this.handleLinkClick = this.handleLinkClick.bind(this);

		if (!this.menu) return;

		this.init();
	}

	init() {
		document.addEventListener('click', this.handleClick);
		this.menuLinks.forEach(link => link.addEventListener('click', this.handleLinkClick));
	}

	openMenu() {
		this.overlay.create('menu-opened');
	}

	closeMenu() {
		this.overlay.destroy('menu-opened');
	}

	/**
	 * Smoothly scrolls to specified element
	 * @param {HTMLElement} element - Target element to scroll to
	 * @param {number} [offset=0] - Offset from element's top in pixels
	 * @param {('smooth'|'auto'|'instant')} [behavior='smooth'] - Scroll behavior type
	 */

	scrollToElement(element, offset = 0, behavior = 'smooth') {
		if (!element) return;

		const top = element.offsetTop - offset;

		window.scrollTo({
			top,
			behavior
		});
	}

	handleClick(e) {
		const onButtonOpen = e.target.closest('[data-button="menu-open"]');
		const onMenuOpened = this.html.classList.contains('menu-opened');
		const onButtonClose = e.target.closest('[data-button="menu-close"]');
		const onNotMenu = !e.target.closest('#menu');

		if (onButtonOpen) {
			this.openMenu();
			return;
		}

		//miss-click
		if (onMenuOpened && (onButtonClose || onNotMenu)) {
			this.closeMenu();
		}
	}

	handleLinkClick(e) {
		const link = e.currentTarget;
		const selector = link.hash.substring(1) || 'content';
		const target = document.getElementById(selector);

		if (link.href === window.location.href) {
			e.preventDefault();
			this.scrollToElement(target);
			return;
		}

		if (link.hash) {
			if (target) {
				this.scrollToElement(target, this.header.offsetHeight / 2);
				this.closeMenu();
				e.preventDefault();
			}
		}
	}

	/**
	 * Cleanup method, Removes all event listeners to prevent memory leaks
	 * Called when the menu component is no longer needed (being destroyed/unmounted)
	 */

	destroy() {
		document.removeEventListener('click', this.handleClick);
		this.menuLinks.forEach(link =>
			link.removeEventListener('click', this.handleLinkClick)
		);
	}
}