<?php

namespace App\Views\Components;

/**
 * Button component class
 *
 * Provides functionality to render HTML buttons or links with button styling
 */
class Button
{
    /**
     * Renders a button using an anchor tag with configurable options
     *
     * @param array{
     * url?: string,
     * class?: string,
     * attr?: string,
     * content?: string,
     * tag?: string,
     * aria-label?: string,
     * aria-expanded?: string|bool,
     * aria-controls?: string,
     * role?: string,
     * aria-hidden?: bool,
     * } $params Button configuration.
     * @return string Rendered HTML button or anchor tag.
     */
    public static function render(array $params = []): string
    {
        extract($params);

        // default params
        $url = $url ?? '#';
        $url = htmlspecialchars($url, ENT_QUOTES);
        $class = isset($class) ? "button {$class}" : 'button';
        $class = htmlspecialchars($class, ENT_QUOTES);
        $attr = $attr ?? '';
        $content = $content ?? '';
        $tag = $tag ?? 'link'; // 'link' for <a>, 'button' for <button>

        // ADDED: Accessibility attributes
        $ariaLabel = !empty($params['aria-label']) ? 'aria-label="' . htmlspecialchars($params['aria-label'], ENT_QUOTES) . '"' : '';
        $ariaExpanded = isset($params['aria-expanded']) ? 'aria-expanded="' . ($params['aria-expanded'] ? 'true' : 'false') . '"' : '';
        $ariaControls = !empty($params['aria-controls']) ? 'aria-controls="' . htmlspecialchars($params['aria-controls'], ENT_QUOTES) . '"' : '';
        $role = !empty($params['role']) ? 'role="' . htmlspecialchars($params['role'], ENT_QUOTES) . '"' : '';
        $ariaHidden = isset($params['aria-hidden']) ? 'aria-hidden="' . ($params['aria-hidden'] ? 'true' : 'false') . '"' : '';

        ob_start();
		?>

        <?php if ($tag === 'button'): ?>

			<button class="<?= $class ?>"
				<?= $attr ?>
				<?= $ariaLabel ?>
				<?= $ariaExpanded ?>
				<?= $ariaControls ?>
				<?= $role ?>
			>
				<?= $content ?>
			</button>

		<?php else: /* tag is 'link' */ ?>

			<a href="<?= $url ?>"
			   class="<?= $class ?>"
				<?= $attr ?>
				<?= $ariaLabel ?>
				<?= $ariaExpanded ?>
				<?= $ariaControls ?>
				<?= $role ?>
				<?= $ariaHidden ?>
			>
				<?= $content ?>
			</a>

		<?php endif;

        return ob_get_clean();
    }
}
