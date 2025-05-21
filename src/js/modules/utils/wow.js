/**
 * Initializes the WOW.js animation library if elements with the 'wow' class exist.
 * WOW.js reveals elements as they enter the viewport with animation.
 *
 * @async
 * @function initWow
 * @returns {Promise<void>} A resolved promise when initialization is complete
 *
 * @example
 * // Import and use in your main script
 * import { initWow } from './modules/utils/wow.js';
 *
 * // Call the function
 * initWow().then(() => {
 *   console.log('WOW animations initialized');
 * });
 */
export const initWow = async () => {
    // Check if any elements with 'wow' class exist in the document
    if (!document.querySelector('.wow')) {
        return Promise.resolve();
    }

    // Check if WOW is already loaded
    if (typeof WOW !== 'undefined') {
        // Create new WOW instance with mobile support enabled
        const wow = new WOW({
            mobile: true, // Enable animations on mobile devices
        });

        // Initialize WOW animations
        wow.init();
        return Promise.resolve();
    }

    // If WOW is not loaded yet, wait for it using a Promise
    return new Promise(resolve => {
        // Use requestIdleCallback to initialize WOW when browser is idle
        const initWhenAvailable = () => {
            if (typeof WOW !== 'undefined') {
                const wow = new WOW({
                    mobile: true,
                });
                wow.init();
                resolve();
            } else {
                // Check again after a short delay
                setTimeout(initWhenAvailable, 100);
            }
        };

        if ('requestIdleCallback' in window) {
            requestIdleCallback(initWhenAvailable);
        } else {
            setTimeout(initWhenAvailable, 100);
        }
    });
};
