export const initWow = () => {
    if (document.querySelector('.wow')) {
        window.addEventListener('load', () => {
            if (typeof WOW !== 'undefined') {
                const wow = new WOW({mobile: true});
                wow.init();
            }
        });
    }
    return Promise.resolve();
};
