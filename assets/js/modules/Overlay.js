/**
 * Utility class for managing overlay and document states
 */
export default class Overlay {
	constructor() {
		this.html = document.documentElement;
	}

	/**
	 * Creates overlay and adds state class to html
	 * @param {string} [stateClass='className'] - Class indicating what's currently opened (menu/popup/etc)
	 */
	create(stateClass = '') {
		const overlay = document.createElement('div');
		overlay.id = 'overlay';
		overlay.className = 'overlay';
		document.body.appendChild(overlay);
		this.html.classList.add('no-scroll', stateClass);
	}

	/**
	 * Destroys overlay and removes state class from html
	 * Removes overlay and state classes from html
	 * @param {string} [stateClass='className'] - Class to be removed
	 */
	destroy(stateClass = '') {
		this.html.classList.remove('no-scroll', stateClass);
		const overlay = document.getElementById('overlay');
		if (overlay) overlay.remove();
	}
}