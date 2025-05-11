import Overlay from './Overlay.js';

/**
 * Manages modal windows functionality
 */
export default class PopUp {
    constructor() {
        this.overlay = new Overlay();
        this.html = document.documentElement;
        this.activeModal = null;

        this.init();
    }

    /**
     * Initializes modal event handlers
     */
    init() {
        document.addEventListener('click', this.handleClick.bind(this));
    }

//     /**
//      * Handles click events for modal interactions
//      * @param {Event} e - Click event
//      */
//     handleClick(e) {
//         const modalTrigger = e.target.closest('[data-modal]');
//         const closeButton = e.target.closest('[data-modal-close]');
//         const modalOverlay = e.target.closest('.overlay');
//
//         if (modalTrigger) {
//             e.preventDefault();
//             const modalId = modalTrigger.dataset.modal;
//             this.openModal(modalId);
//         }
//
//         if (closeButton || (this.activeModal && (modalOverlay && !e.target.closest('.modal')))) {
//             this.closeModal();
//         }
//     }
//
//     /**
//      * Opens specified modal
//      * @param {string} modalId - PopUp element ID
//      */
//     openModal(modalId) {
//         this.activeModal = document.getElementById(modalId);
//         if (!this.activeModal) return;
//
//         this.overlay.create('modal-opened');
//         this.activeModal.classList.add('active');
//     }
//
//     /**
//      * Closes currently active modal
//      */
//     closeModal() {
//         if (!this.activeModal) return;
//
//         this.overlay.destroy('modal-opened');
//         this.activeModal.classList.remove('active');
//         this.activeModal = null;
//     }
}