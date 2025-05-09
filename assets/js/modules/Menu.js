export default class Menu {
	static init() {
		const html = document.documentElement;
		const menu = document.getElementById('menu');
		const menuLinks = document.querySelectorAll('[data-menu="link"]');

		function openMenu() {
			const overlay = document.createElement('div');
			overlay.className = 'overlay';
			document.body.appendChild(overlay);
			html.classList.add('no-scroll', 'menu-opened');
		};

		function closeMenu() {
			html.classList.remove('no-scroll', 'menu-opened');
			const overlay = document.querySelector('.overlay');
			if (overlay) overlay.remove();
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