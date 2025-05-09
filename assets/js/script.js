import Preloader from '/assets/js/modules/Preloader.js';

document.addEventListener('DOMContentLoaded', () => {
	Preloader.init();

	const wow = new WOW({mobile: true});
	wow.init();
});