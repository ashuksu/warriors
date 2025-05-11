import Overlay from './Overlay.js';
export default class Menu {
	static init() {
		this.overlay = new Overlay();

		const html = document.documentElement;
		const menu = document.getElementById('menu');
		const menuLinks = document.querySelectorAll('[data-menu="link"]');

		function openMenu() {
			this.overlay.create('menu-opened');
		};

		function closeMenu() {
			this.overlay.destroy('menu-opened');
		};

		document.addEventListener('click', e => {
			const onButtonOpen = e.target.closest('[data-button="menu-open"]');
			const onMenuOpened = html.classList.contains('menu-opened');
			const onButtonClose = e.target.closest('[data-button="menu-close"]');
			const onNotMenu = !e.target.closest('#menu');

			if (onButtonOpen) {
				openMenu();
				return;
			}

			if (onMenuOpened && (onButtonClose || onNotMenu)) {
				closeMenu();
			}
		});

		menuLinks.forEach(link => {
			link.addEventListener('click', e => {
				if (link.href === window.location.href) {
					e.preventDefault();

					window.scrollTo({
						top: document.getElementById('content').offsetTop,
						behavior: 'smooth',
					});
				}

				if (link.hash) {
					const target = document.getElementById(link.hash.substring(1));

					if (target) {
						window.scrollTo({
							top: target.offsetTop - document.getElementById('header').offsetHeight / 2,
							behavior: 'smooth',
						});

						closeMenu();
						e.preventDefault();
					}
				}
			});
		});
	}
}