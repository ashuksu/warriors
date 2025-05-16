<?php
$popupId = SectionService::get('popup', 'items', 'p001', 'id');
$popupName = SectionService::get('popup', 'items', 'p001', '$popupName');
?>

<nav id="menu" class="menu" data-block="menu">
    <?php
    render_button([
        'class' => 'button button--close button--transparent',
        'attr' => 'data-element="menu-close"',
    ]);
    ?>

    <div class="menu__list">
        <a class="menu__link link" data-element="link" href="<?= APP_PATH ?>#about">About</a>
        <a class="menu__link link" data-element="link" href="<?= APP_PATH ?>catalog">Catalog</a>
        <a class="menu__link link" data-element="link" href="<?= APP_PATH ?>#faq">FAQ</a>
        <a class="menu__link link" data-element="link" href="<?= APP_PATH ?>#info">Info</a>
        <a class="menu__link link" data-element="link" href="<?= APP_PATH ?>contacts">Contacts</a>
    </div>

    <?php
    render_button([
        'url' => '#popup-' . $popupId,
        'attr' => 'data-element="popup-open"',
        'content' => 'Open ' . $popupName,
    ]);
    ?>
</nav>