<?php

namespace App\Views;

use App\Core\Container;
use App\Services\ConfigService;
use App\Services\TemplateService;
use App\Services\ViteService;
use App\Views\Sections\Footer;
use App\Views\Sections\Head;
use App\Views\Sections\Header;
use App\Views\Sections\Popup\Popup;
use App\Views\Components\Button;
use App\Views\Components\Preloader;
use Exception;

/**
 * Main layout class for rendering the page structure
 * Handles the overall page layout including header, footer, and content sections
 */
class Layout
{
    /**
     * Render the complete page layout
     *
     * Renders the head, header, content sections, footer, and additional components
     * @param Container $container The DI container.
     * @param array $sections An array of section names to render.
     * @return void
     * @throws Exception
     */
    public static function render(Container $container, array $sections = []): void
    {
        $pageData = $container->getPageData();

        /** @var TemplateService $templateService */
        $templateService = $container->get(TemplateService::class);

        /** @var ViteService $viteService */
        $viteService = $container->get(ViteService::class);

        Head::render($container);
        ?>

        <body data-style="default" class="<?= 'page-' . ($pageData['name'] ?? 'static') ?>" itemscope itemtype="https://schema.org/WebPage">
        <div class="wrapper">

            <?php
            echo Preloader::render(['attr' => 'data-delay="0.1"', 'viteService' => $viteService]);

            Header::render($container);
            ?>

            <main id="content" class="content" role="<?= $pageData['name'] ?? 'main' ?>">
                <h1 hidden>
                    <?= $pageData['h1'] ?? $pageData['title'] ?>
                </h1>

                <?php
                if (!empty($sections) && is_array($sections)) {
                    foreach ($sections as $section) {
                        $sectionClass = 'App\\Views\\Sections\\' . ucfirst($section) . '\\' . ucfirst($section);
                        if (class_exists($sectionClass)) {
                            $sectionClass::render($container);
                        } else {
                            error_log("Layout: Section class '{$sectionClass}' not found for rendering.");
                        }
                    }
                }
                ?>

            </main>

            <?php
            Footer::render($container);
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

        Popup::render($container);

        $templateService->render(__DIR__ . '/Sections/footer-links.php', ['viteService' => $viteService]);
        ?>

        </body>
        </html>

        <?php
    }
}