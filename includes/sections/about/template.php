<?php
$about = SectionService::get('about', 'items');
?>

<?php if (!empty($about) && is_array($about)): ?>
    <section id="about" class="section about">
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
<?php endif; ?>
