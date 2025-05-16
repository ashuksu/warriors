<div class="popup" data-element="popup">
    <div class="popup__overlay" data-element="popup-overlay" data-action="close-popup"></div>
    <div class="popup__container">
        <button class="popup__close" data-element="popup-close" data-action="close-popup" aria-label="Close popup">
            <span class="popup__close-icon">×</span>
        </button>
        <div class="popup__content" data-element="popup-content">
            <!-- Popup content will be loaded here -->
        </div>
    </div>
</div>

<script>
    // Popup functionality
    document.addEventListener('DOMContentLoaded', function() {
        const popup = document.querySelector('[data-element="popup"]');
        const popupContent = document.querySelector('[data-element="popup-content"]');
        const closeButtons = document.querySelectorAll('[data-action="close-popup"]');
        
        // Close popup when close button or overlay is clicked
        closeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                popup.classList.remove('popup--active');
                // Clear content after animation completes
                setTimeout(function() {
                    popupContent.innerHTML = '';
                }, 300);
            });
        });
        
        // Close popup when Escape key is pressed
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && popup.classList.contains('popup--active')) {
                popup.classList.remove('popup--active');
                // Clear content after animation completes
                setTimeout(function() {
                    popupContent.innerHTML = '';
                }, 300);
            }
        });
        
        // Function to open popup with content
        window.openPopup = function(content) {
            popupContent.innerHTML = content;
            popup.classList.add('popup--active');
        };
    });
</script>