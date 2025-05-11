import Preloader from '/assets/js/modules/Preloader.js';
import ScrollEvents from '/assets/js/modules/ScrollEvents.js';
import Menu from '/assets/js/modules/Menu.js';
import ToggleButton from '/assets/js/modules/ToggleButton.js';

document.addEventListener('DOMContentLoaded', () => {
	Preloader.init();

	const wow = new WOW({mobile: true});
	wow.init();

	ScrollEvents.init();

	const menu = new Menu();

	ToggleButton.init();
});