<header class="header">
    <div class="container">
        <div class="header__inner">
            <!-- Logo -->
            <a href="<?= APP_PATH ?>" class="logo">
                <img src="<?= APP_PATH ?>assets/images/logo/logo.svg" alt="Warriors Logo" class="logo__img">
                <span class="logo__text">Warriors</span>
            </a>
            
            <!-- Navigation -->
            <nav class="nav">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="<?= APP_PATH ?>" class="nav__link <?= PAGE === 'main' ? 'nav__link--active' : '' ?>">Home</a>
                    </li>
                    <li class="nav__item">
                        <a href="<?= APP_PATH ?>catalog.php" class="nav__link <?= PAGE === 'catalog' ? 'nav__link--active' : '' ?>">Catalog</a>
                    </li>
                    <li class="nav__item">
                        <a href="<?= APP_PATH ?>contacts.php" class="nav__link <?= PAGE === 'contacts' ? 'nav__link--active' : '' ?>">Contacts</a>
                    </li>
                </ul>
            </nav>
            
            <!-- Mobile menu button -->
            <button class="menu-button" aria-label="Toggle menu" data-element="button" data-action="toggle-menu">
                <span class="menu-button__line"></span>
                <span class="menu-button__line"></span>
                <span class="menu-button__line"></span>
            </button>
        </div>
    </div>
</header>