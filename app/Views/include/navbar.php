<nav class="navbar navbar-expand-lg navbar-dark bg-black py-3">

    <div class="container">

        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">VIZIO</a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item px-3">
                    <a class="nav-link" href="<?= base_url('/') ?>">Home</a>
                </li>

                <li class="nav-item px-3">
                    <a class="nav-link" href="<?= base_url('/products') ?>">Products</a>
                </li>

                <li class="nav-item px-3">
                    <a class="nav-link" href="<?= base_url('/cart') ?>">Cart</a>
                </li>

            </ul>

            <div class="d-flex align-items-center">

                <img src="<?= base_url('img/search.png') ?>" width="20" class="me-2">

                <input class="form-control search-bar" type="text">

            </div>

        </div>

    </div>

</nav>