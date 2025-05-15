import Overlay from './Overlay.js';
import {closeMenu, getElementIdByHash} from "./utils/helpers.js";

/**
 * Manages pop-up windows functionality
 */
export default class Popup {
    constructor() {
        this.overlay = new Overlay();
        this.html = document.documentElement;

        this.init();
    }

    /**
     * Initializes event listeners for the application
     */
    init() {
        document.addEventListener('click', this.handleClick.bind(this));
    }

    /**
     * Handles click events to toggle a popup state.
     * @param {Event} e - The click event object.
     */
    handleClick(e) {
        const buttonPopupOpen = e.target.closest('[data-element="popup-open"]');
        const isPopupOpened = this.html.classList.contains('popup-opened');
        const buttonPopupClose = e.target.closest('[data-element="popup-close"]');
        const missClick = !e.target.closest('[data-block="popup"]');

        if (buttonPopupOpen || buttonPopupClose) {
            e.preventDefault();
        }

        if (buttonPopupOpen) {
            if (isPopupOpened) this.close();

            closeMenu();
            this.open(buttonPopupOpen);
            return;
        }

        if (isPopupOpened && (buttonPopupClose || missClick)) {
            this.close();
        }
    }

    /**
     * Opens a popup by adding the 'active' class and setting up the overlay
     * @param {HTMLElement} button - The button that triggers the popup
     */
    open(button) {
        const popup = getElementIdByHash(button);

        if (!popup) return;

        popup.classList.add('active');
        this.overlay.open('popup-opened');
    }

    /**
     * Closes all active popups and removes the overlay.
     */
    close() {
        document.querySelectorAll('[data-block="popup"]').forEach(el => el.classList.remove('active'));
        this.overlay.close('popup-opened');
    }
}