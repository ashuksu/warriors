<?php

namespace Views\Sections;

use Views\Components\Image;
use function Helpers\getPath;

/**
 * Footer section class
 *
 * Handles rendering of the site footer with logo, copyright information, and links
 */
class Footer
{
    /**
     * Render the footer section
     *
     * Outputs the footer with logo, copyright text, and external links
     *
     * @param array $params Parameters for the footer section
     * @return void
     */
    public static function render($params = [])
    {
        extract($params);

        // Default link if not provided
        $LINK = $LINK ?? 'https://github.com/ashuksu';
        ?>

		<footer id="footer" class="footer" role="contentinfo">
			<div class="container">
				<div class="inner inner-style footer__inner">
					<a href="<?= APP_PATH ?>" class="logo">

                        <?php
                        echo Image::render([
                            'url' => getPath('dist/assets/images/logo/logo-3.svg'),
                            'alt' => 'logo-footer',
                            'width' => 70,
                            'height' => 70,
                        ]);
                        ?>

					</a>
					<p class="footer__text">
						Copyright © <?= date("Y"); ?>
					</p>
					<a href="<?= $LINK ?>"
					   class="footer__link link"
					   target="_blank"
					   rel="noopener noreferrer"
					   aria-label="Go to GitHub">
						ASHUKSU
					</a>
				</div>
			</div>
		</footer>

        <?php
    }
}