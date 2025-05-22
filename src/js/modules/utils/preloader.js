/**
 * Handles preloader fade out after page load
 */
export default function preloader(params = {}) {
    const defaults = {delay: 0.5, duration: 0.3};
    let {delay, duration} = {...defaults, ...params};

    const preloader = document.getElementById('preloader');

    if (preloader) {
        delay = preloader.dataset.delay ?? delay;
        duration = preloader.dataset.duration ?? duration;

        window.addEventListener('load', () => {
            setTimeout(() => {
                preloader.style.opacity = '0';
                preloader.style.visibility = 'hidden';
                preloader.style.transition = `opacity ${duration}s ease, visibility ${duration}s ease`;
            }, delay * 1000);
        });
    }
}