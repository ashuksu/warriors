import Preloader from '/assets/js/modules/Preloader.js';
import Menu from '/assets/js/modules/Menu.js';
import {toggleButton} from '/assets/js/modules/helpers.js';
import ScrollToTopButton from "/assets/js/modules/ScrollToTopButton.js";

document.addEventListener('DOMContentLoaded', () => {
	Preloader.init();
	toggleButton();

	const wow = new WOW({mobile: true});
	wow.init();

	ScrollToTopButton.init();
	new Menu();
});