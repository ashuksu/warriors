<?php
$popups = [
    [
        'name' => 'first',
        'title' => 'First',
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque, sunt.',
        'button' => [
            'url' => $LINK,
            'attr' => 'target="_blank"',
            'content' => 'GitHub'
        ],
    ],
    [
        'name' => 'second',
        'title' => 'Second',
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, ad doloremque explicabo fuga officia optio possimus quis rem repellendus voluptatum! Aut blanditiis dolore dolores doloribus ducimus, illo porro quis repellat?',
        'button' => [
            'url' => APP_PATH,
            'content' => 'Go Home'
        ],
    ],

];

foreach ($popups as $index => &$item) {
    if (isset($item['button'])) {
        ob_start();
        render_button($item['button']);
        $item['button'] = ob_get_clean();
    }

    include $dir . 'includes/sections/popup/template.php';
}
?>
