<section class="info" id="info">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Project Information</h2>
            <p class="section-subtitle">Learn more about the Warriors Project</p>
        </div>
        
        <div class="info__inner">
            <div class="info__content">
                <p>
                    The Warriors Project is a modern PHP application that demonstrates the use of the MVC pattern
                    along with modern frontend tooling like Vite. It serves as a starting point for your own projects.
                </p>
                
                <h3>Key Features</h3>
                <ul>
                    <li>Modern PHP structure with MVC pattern</li>
                    <li>Vite for frontend asset building</li>
                    <li>Docker support for easy deployment</li>
                    <li>Responsive design</li>
                </ul>
                
                <h3>Getting Started</h3>
                <p>
                    To get started with the Warriors Project, please refer to the README.md file for detailed
                    installation and usage instructions.
                </p>
                
                <div class="info__cta">
                    <?php
                    render_button([
                        'url' => 'https://github.com/ashuksu/warriors',
                        'text' => 'View on GitHub',
                        'class' => 'button--primary',
                        'attr' => 'target="_blank"',
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>