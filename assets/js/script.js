import preloader from './modules/utils/preloader.js';
import Menu from './modules/Menu.js';
import {toggleButton} from './modules/utils/helpers.js';
import scrollEvents from "./modules/utils/scrollEvents.js";

document.addEventListener('DOMContentLoaded', () => {
    preloader();
    toggleButton();
    scrollEvents();

    const wow = new WOW({mobile: true});
    wow.init();

    new Menu();
});