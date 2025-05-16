import preloader from './modules/utils/preloader.js';
import {toggleButton} from './modules/utils/helpers.js';
import scrollEvents from "./modules/utils/scrollEvents.js";
import Menu from './modules/Menu.js';
import Popup from "./modules/Popup.js";
import {initWow} from './modules/utils/wow.js';

document.addEventListener('DOMContentLoaded', () => {
    preloader();
    toggleButton();
    scrollEvents();

    // Load Menu with low priority
    requestIdleCallback(async () => {
        const {default: Menu} = await import(
            /* webpackChunkName: "menu" */
            './modules/Menu.js'
            );
        new Menu();
    });


    const wow = new WOW({mobile: true});
    wow.init();

    new Menu();
    new Popup();
});