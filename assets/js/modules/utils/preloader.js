/**
 * Handles the fading and hiding of a preloader element once the page has fully loaded.
 * The preloader element is identified by the ID 'preloader'.
 */
export default function preloader() {
    const preloader = document.getElementById('preloader');

    if (preloader) {
        window.addEventListener('load', () => {
            preloader.style.opacity = '0';
            preloader.style.visibility = 'hidden';
            preloader.style.transition = 'opacity 0.5s ease, visibility 0.5s ease';
        });
    }
}