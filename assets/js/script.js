import preloader from './modules/utils/preloader.js';
import {toggleButton} from './modules/utils/helpers.js';
import scrollEvents from "./modules/utils/scrollEvents.js";
import Menu from './modules/Menu.js';
import Popup from "./modules/Popup.js";

document.addEventListener('DOMContentLoaded', () => {
    preloader();
    toggleButton();
    scrollEvents();

    const wow = new WOW({mobile: true});
    wow.init();

    new Menu();
    new Popup();
});