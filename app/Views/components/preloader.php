<div class="preloader" data-element="preloader">
    <div class="preloader__inner">
        <div class="preloader__spinner"></div>
        <div class="preloader__text">Loading...</div>
    </div>
</div>

<script>
    // Hide preloader when page is loaded
    window.addEventListener('load', function() {
        const preloader = document.querySelector('[data-element="preloader"]');
        if (preloader) {
            setTimeout(function() {
                preloader.classList.add('preloader--hidden');
                setTimeout(function() {
                    preloader.style.display = 'none';
                }, 500);
            }, 500);
        }
    });
</script>