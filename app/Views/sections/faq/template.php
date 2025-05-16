<section class="faq" id="faq">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Find answers to common questions about the Warriors Project</p>
        </div>
        
        <div class="faq__inner">
            <div class="accordion">
                <div class="accordion__item">
                    <div class="accordion__header" data-element="accordion-header">
                        <h3 class="accordion__title">What is the Warriors Project?</h3>
                        <span class="accordion__icon"></span>
                    </div>
                    <div class="accordion__content">
                        <p>
                            The Warriors Project is a modern PHP application that demonstrates the use of the MVC pattern
                            along with modern frontend tooling like Vite. It serves as a starting point for your own projects.
                        </p>
                    </div>
                </div>
                
                <div class="accordion__item">
                    <div class="accordion__header" data-element="accordion-header">
                        <h3 class="accordion__title">How do I run the project?</h3>
                        <span class="accordion__icon"></span>
                    </div>
                    <div class="accordion__content">
                        <p>
                            You can run the project using PHP's built-in server, Live Server, or Docker. See the README.md file
                            for detailed instructions on how to run the project.
                        </p>
                    </div>
                </div>
                
                <div class="accordion__item">
                    <div class="accordion__header" data-element="accordion-header">
                        <h3 class="accordion__title">What are the system requirements?</h3>
                        <span class="accordion__icon"></span>
                    </div>
                    <div class="accordion__content">
                        <p>
                            The project requires PHP 8.0 or later, Node.js 14 or later, and optionally Docker and Docker Compose
                            for containerized deployment.
                        </p>
                    </div>
                </div>
                
                <div class="accordion__item">
                    <div class="accordion__header" data-element="accordion-header">
                        <h3 class="accordion__title">How do I contribute to the project?</h3>
                        <span class="accordion__icon"></span>
                    </div>
                    <div class="accordion__content">
                        <p>
                            Contributions are welcome! Please feel free to submit a Pull Request on GitHub or contact the project
                            maintainer at ashuksu@gmail.com.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Accordion functionality
    document.addEventListener('DOMContentLoaded', function() {
        const accordionHeaders = document.querySelectorAll('[data-element="accordion-header"]');
        
        accordionHeaders.forEach(function(header) {
            header.addEventListener('click', function() {
                const item = this.parentElement;
                const isActive = item.classList.contains('accordion__item--active');
                
                // Close all items
                document.querySelectorAll('.accordion__item').forEach(function(item) {
                    item.classList.remove('accordion__item--active');
                });
                
                // Open clicked item if it wasn't already open
                if (!isActive) {
                    item.classList.add('accordion__item--active');
                }
            });
        });
    });
</script>