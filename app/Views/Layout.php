<?php

namespace Views;

use App\Views\Sections\Popup\Popup;
use Views\Components\Button;
use Views\Components\Preloader;
use Views\Sections\Footer;
use Views\Sections\Head;
use Views\Sections\Header;
use function Helpers\renderTemplate;

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
     *
     * @param array $data Data to be passed to the layout and sections
     * @return void
     */
    public static function render($data = [])
    {
        extract($data);

        Head::render([]);

        ?>

		<body data-style="default" class="<?= 'page-' . PAGE ?>" itemscope itemtype="https://schema.org/WebPage">
		<div class="wrapper">

            <?php

            echo Preloader::render(['attr' => 'data-delay="0.1"']);

            Header::render();
            ?>

			<main id="content" class="content" role="<?= PAGE ?? 'main' ?>">
				<h1 hidden>
                    <?= PAGES[PAGE]['h1'] ?? PAGES[PAGE]['title'] ?>
				</h1>

                <?php
                if (!empty($sections) && is_array($sections)) {
                    foreach ($sections as $section) {
                        $sectionClass = 'Views\\Sections\\' . ucfirst($section) . '\\' . ucfirst($section);
                        if (class_exists($sectionClass)) {
                            $sectionClass::render($data);
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

        renderTemplate(__DIR__ . '/Sections/footer-links.php', []);
        ?>

		</body>
		</html>

        <?php
    }
}