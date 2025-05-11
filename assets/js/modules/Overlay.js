/**
 * Manages overlay element and document states for modals, menus etc.
 */
export default class Overlay {
    constructor() {
        this.html = document.documentElement;
    }

    /**
     * Creates overlay element and adds state classes
     * @param {string} [stateClass=''] - Class name for opened state (e.g. 'menu-opened')
     */
    create(stateClass = '') {
        const overlay = document.createElement('div');
        overlay.id = 'overlay';
        overlay.className = 'overlay';
        document.body.appendChild(overlay);
        this.html.classList.add('no-scroll', stateClass);
    }

    /**
     * Removes overlay element and state classes
     * @param {string} [stateClass=''] - Class name to remove
     */
    destroy(stateClass = '') {
        this.html.classList.remove('no-scroll', stateClass);
        const overlay = document.getElementById('overlay');
        if (overlay) overlay.remove();
    }
}