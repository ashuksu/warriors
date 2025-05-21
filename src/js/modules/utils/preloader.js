/**
 * Handles preloader fade out after page load
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