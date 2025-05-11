import Overlay from './Overlay.js';
import {initNavigationLinks} from './helpers.js';

/**
 * Represents a Menu component that manages mobile/responsive menu functionality
 * @class
 * @description
 * Handles menu opening/closing, overlay management, and navigation link interactions.
 * Requires corresponding HTML elements with specific data attributes and IDs.
 */

export default class Menu {
    constructor() {
        this.overlay = new Overlay();
        this.html = document.documentElement;
        this.header = document.getElementById('header');
        this.menu = document.getElementById('menu');

        if (!this.menu) return;

        this.init();
    }

    /**
     * Initializes menu event listeners and navigation links
     * @private
     * @description
     * Sets up:
     * 1. Click event delegation for menu interactions
     * 2. Navigation links with menu integration
     */

    init() {
        document.addEventListener('click', this.handleClick.bind(this));

        initNavigationLinks('[data-menu="link"]', {
            targetCallback: () => this.closeMenu(), offsetHeight: this.header.offsetHeight / 2
        });
    }

    /**
     * Handles click events for menu interactions
     * @param {Event} e - Click event object
     * @private
     * @description
     * Manages clicks on:
     * - Menu open button [data-button="menu-open"]
     * - Menu close button [data-button="menu-close"]
     * - Outside menu area (for closing)
     */

    handleClick(e) {
        const onButtonOpen = e.target.closest('[data-button="menu-open"]');
        const isMenuOpened = this.html.classList.contains('menu-opened');
        const onButtonClose = e.target.closest('[data-button="menu-close"]');
        const onNotMenu = !e.target.closest('#menu');

        if (onButtonOpen || onButtonClose) {
            e.preventDefault();
        }

        if (onButtonOpen) {
            this.openMenu();
            return;
        }

        // Close menu on clicking close button or outside menu area (miss-click)
        if (isMenuOpened && (onButtonClose || onNotMenu)) {
            this.closeMenu();
        }
    }

    /**
     * Opens the menu and creates overlay
     * @public
     * @description
     * Creates an overlay with 'menu-opened' class
     * This triggers menu visibility and background dimming
     */

    openMenu() {
        this.overlay.create('menu-opened');
    }

    /**
     * Closes the menu and removes overlay
     * @public
     * @description
     * Removes the overlay with 'menu-opened' class
     * This hides the menu and removes background dimming
     */

    closeMenu() {
        this.overlay.destroy('menu-opened');
    }
}