import Preloader from '/assets/js/modules/Preloader.js';
import Menu from '/assets/js/modules/Menu.js';
import ToggleButton from '/assets/js/modules/ToggleButton.js';
import ScrollToTopButton from "/assets/js/modules/ScrollToTopButton.js";

document.addEventListener('DOMContentLoaded', () => {
	Preloader.init();

	const wow = new WOW({mobile: true});
	wow.init();

	ScrollToTopButton.init();
	new Menu();

	ToggleButton.init();
});