import Overlay from './Overlay.js';
import {initNavigationLinks} from './utils/helpers.js';

/**
 * Manages mobile menu functionality and overlay integration
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
     * Initializes menu event handlers and navigation
     * @private
     */
    init() {
        document.addEventListener('click', this.handleClick.bind(this));

        initNavigationLinks('[data-element="link"]', {
            targetCallback: () => this.close(), offsetHeight: this.header.offsetHeight / 2
        });
    }

    handleClick(e) {
        const onButtonOpen = e.target.closest('[data-element="menu-open"]');
        const isMenuOpened = this.html.classList.contains('menu-opened');
        const onButtonClose = e.target.closest('[data-element="menu-close"]');
        const onNotMenu = !e.target.closest('#menu');

        if (onButtonOpen || onButtonClose) {
            e.preventDefault();
        }

        if (onButtonOpen) {
            this.open();
            return;
        }

        // Close menu on clicking close button or outside menu area (miss-click)
        if (isMenuOpened && (onButtonClose || onNotMenu)) {
            this.close();
        }
    }

    /**
     * Opens menu and open overlay
     * @public
     */
    open() {
        this.overlay.open('menu-opened');
    }

    /**
     * Closes menu and close overlay
     * @public
     */
    close() {
        this.overlay.close('menu-opened');
    }
}