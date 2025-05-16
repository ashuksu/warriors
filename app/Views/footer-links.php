<!-- JavaScript includes -->
<script src="<?= APP_PATH ?>assets/js/script.js"></script>

<?php if (defined('PAGE')): ?>
    <!-- Page-specific JavaScript -->
    <?php if (PAGE === 'main'): ?>
    <!-- Main page specific scripts -->
    <?php elseif (PAGE === 'catalog'): ?>
    <!-- Catalog page specific scripts -->
    <script src="<?= APP_PATH ?>assets/js/catalog.js"></script>
    <?php elseif (PAGE === 'contacts'): ?>
    <!-- Contacts page specific scripts -->
    <script src="<?= APP_PATH ?>assets/js/contacts.js"></script>
    <?php endif; ?>
<?php endif; ?>

<!-- Vite HMR support in development mode -->
<?php if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'localhost:3000'): ?>
<script type="module">
    import { createHotContext } from '/@vite/client';
    import.meta.hot = createHotContext('/');
</script>
<?php endif; ?>