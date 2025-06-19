<?php

namespace App\Views;

use App\Core\Container;
use App\Views\Sections\Footer;
use App\Views\Sections\Head;
use App\Views\Sections\Header;
use App\Views\Sections\Popup\Popup;
use function App\Helpers\renderTemplate;
use App\Views\Components\Button;
use App\Views\Components\Preloader;

/**
 * Main layout class for rendering the page structure
 *
 * Handles the overall page layout including header, footer, and content sections
 */
class Layout
{
    /**
     * Render the complete page layout
     *
     * Renders the head, header, content sections, footer, and additional components
     * @param Container $container
     * @param array $sections
     * @return void
     */
    public static function render(Container $container, array $sections = []): void
    {
        $metadata = $container->getPageMetadata();

        if (empty($metadata) || !isset($metadata['name']) || !isset($metadata['title'])) {
            $metadata = [
                'name' => 'default',
                'title' => 'Default Title',
                'h1' => 'Welcome',
                'description' => 'Default description',
                'keywords' => 'default, keywords'
            ];
            error_log("Warning: Layout::render called without valid metadata.");
        }

        if (!defined('PAGE')) {
            define('PAGE', $metadata['name']);
        }

        if (!defined('APP_TITLE')) {
            define('APP_TITLE', $metadata['title']);
        }

        Head::render($container);

        ?>

       <body data-style="default" class="<?= 'page-' . PAGE ?>" itemscope itemtype="https://schema.org/WebPage">
       <div class="wrapper">

            <?php

            echo Preloader::render(['attr' => 'data-delay="0.1"']);

            Header::render();
            ?>

			<main id="content" class="content" role="<?= PAGE ?? 'main' ?>">
				<h1 hidden>
                    <?= $metadata['h1'] ?? $metadata['title'] ?>
				</h1>

                <?php
                if (!empty($sections) && is_array($sections)) {
                    foreach ($sections as $section) {
                        $sectionClass = 'Views\\Sections\\' . ucfirst($section) . '\\' . ucfirst($section);
                        if (class_exists($sectionClass)) {
                            $sectionClass::render($container);
                        }
                    }
                }
                ?>

			</main>

            <?php
            Footer::render();
            ?>

		</div>

        <?php
        echo Button::render([
            'url' => '#content',
            'class' => 'button--up',
            'attr' => 'data-element="link" data-action="up" hidden',
            'aria-label' => 'Scroll to top',
            'role' => 'button',
            'aria-hidden' => true
        ]);

        Popup::render();

        renderTemplate(__DIR__ . '/Sections/footer-links.php');
        ?>

		</body>
		</html>

        <?php
    }
}