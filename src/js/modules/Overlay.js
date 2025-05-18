/**
 * Manages overlay element and document states for modals, menus etc.
 */
export default class Overlay {
    constructor() {
        this.html = document.documentElement;
        this.overlay = document.getElementById('overlay');

        if (!this.overlay) {
            this.overlay = document.createElement('div');
            this.overlay.id = 'overlay';
            this.overlay.className = 'overlay';
            this.overlay.hidden = true;
            document.body.appendChild(this.overlay);
        }
        ;
    }

    /**
     * Creates overlay element and adds state classes
     * @param {string} [stateClass=''] - Class name for opened state (e.g. 'menu-opened')
     */
    open(stateClass = '') {
        this.overlay.hidden = false;
        this.html.classList.add('overlay-opened', stateClass);
    }

    /**
     * Removes overlay element and state classes
     * @param {string} [stateClass=''] - Class name to remove
     */
    close(stateClass = '') {
        this.overlay.hidden = true;
        this.html.classList.remove('overlay-opened', stateClass);
    }
}