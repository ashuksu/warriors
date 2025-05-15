<?php
//require_once __DIR__ . '/../../../services/SectionService.php';
$about = SectionService::get('about', 'items');

if (!is_array($about) || empty($about)) {
    $about = [];
    $isHidden = 'hidden';
}
?>

<section id="about" class="section about" <?php $isHidden ?>>
    <div class="container">
        <?php
        foreach ($about as $index => $item) {
            $imageUrl = APP_PATH . 'assets/images/' . $item['image'];
            $isReverse = $index % 2 !== 0;

            include __DIR__ . '/item.php';
        }
        ?>
    </div>
</section>
