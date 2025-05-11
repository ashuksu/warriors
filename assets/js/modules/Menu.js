import Overlay from './Overlay.js';
import {initNavigationLinks} from './helpers.js';

export default class Menu {
    constructor() {
        this.overlay = new Overlay();
        this.html = document.documentElement;
        this.menu = document.getElementById('menu');
        this.header = document.getElementById('header');
        this.content = document.getElementById('content');

        this.handleClick = this.handleClick.bind(this);

        if (!this.menu) return;

        this.init();
    }

    init() {
        document.addEventListener('click', this.handleClick);

        initNavigationLinks('[data-menu="link"]', {
            targetCallback: () => this.closeMenu(),
            offsetHeight: this.header.offsetHeight / 2
        });
    }

    openMenu() {
        this.overlay.create('menu-opened');
    }

    closeMenu() {
        this.overlay.destroy('menu-opened');
    }

    handleClick(e) {
        const onButtonOpen = e.target.closest('[data-button="menu-open"]');
        const onMenuOpened = this.html.classList.contains('menu-opened');
        const onButtonClose = e.target.closest('[data-button="menu-close"]');
        const onNotMenu = !e.target.closest('#menu');

        if (onButtonOpen) {
            this.openMenu();
            return;
        }

        //miss-click
        if (onMenuOpened && (onButtonClose || onNotMenu)) {
            this.closeMenu();
        }
    }
}