<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container custom-navbar-grid">

        <div class="nav-side nav-left">
            <a class="navbar-brand custom-brand" href="<?= base_url('/') ?>">VIZIO</a>
        </div>

        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse custom-collapse" id="navbarNav">

            <ul class="navbar-nav custom-nav-links">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/') ?>">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/products') ?>">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/about') ?>">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/cart') ?>">Cart</a>
                </li>

                <?php if (session()->get('role') == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/admin') ?>">Admin</a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="nav-side nav-right">
                <div class="search-wrap">
                    <button type="button" class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                    <input class="form-control search-bar" type="text" placeholder="Search">
                </div>

<<<<<<< HEAD
                <?php if (session()->get('logged_in')): ?>
                    <span class="user-name">
=======

                <?php if(session()->get('logged_in')): ?>

                    <span class="user-name" style="color: #fff;">
>>>>>>> 5c85549d85a554f62712c5a53438f80f9ee32c58
                        Hello, <?= session()->get('user_name') ?>
                    </span>

                    <a href="<?= base_url('/logout') ?>" class="login-btn">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('/login') ?>" class="login-btn">
                        Login
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</nav>
