<footer class="footer">
    <div class="container">
        <div class="footer__inner">
            <div class="footer__column">
                <h3 class="footer__title">About Us</h3>
                <p class="footer__text">
                    Warriors Project is a modern PHP application using MVC pattern and Vite for frontend asset building.
                </p>
            </div>
            
            <div class="footer__column">
                <h3 class="footer__title">Contact</h3>
                <ul class="footer__list">
                    <li class="footer__item">
                        <a href="mailto:<?= $EMAIL ?? 'ashuksu@gmail.com' ?>" class="footer__link">
                            <?= $EMAIL ?? 'ashuksu@gmail.com' ?>
                        </a>
                    </li>
                    <li class="footer__item">
                        <a href="<?= $TELEGRAM ?? 'https://t.me/ashuksu' ?>" class="footer__link" target="_blank">
                            Telegram
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="footer__column">
                <h3 class="footer__title">Links</h3>
                <ul class="footer__list">
                    <li class="footer__item">
                        <a href="<?= APP_PATH ?>" class="footer__link">Home</a>
                    </li>
                    <li class="footer__item">
                        <a href="<?= APP_PATH ?>catalog.php" class="footer__link">Catalog</a>
                    </li>
                    <li class="footer__item">
                        <a href="<?= APP_PATH ?>contacts.php" class="footer__link">Contacts</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="footer__bottom">
            <p class="footer__copyright">
                &copy; <?= date('Y') ?> Warriors Project. All rights reserved.
            </p>
            <p class="footer__author">
                Created by <a href="<?= $LINK ?? 'https://github.com/ashuksu/' ?>" class="footer__link" target="_blank">ashuksu</a>
            </p>
        </div>
    </div>
</footer>