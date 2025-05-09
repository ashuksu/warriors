import Preloader from '/assets/js/modules/Preloader.js';
import ScrollEvents from '/assets/js/modules/ScrollEvents.js';
import Menu from '/assets/js/modules/Menu.js';

document.addEventListener('DOMContentLoaded', () => {
	Preloader.init();

	const wow = new WOW({mobile: true});
	wow.init();

	ScrollEvents.init();
	Menu.init();
});