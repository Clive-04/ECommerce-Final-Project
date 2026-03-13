<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="catalog container">
    <div class="catalog-header text-center">
        <h2>Explore Our Products</h2>
        <div class="catalog-divider"></div>
    </div>

    <div class="catalog-toolbar">
        <div class="catalog-filters">
            <button class="filter-btn active">All</button>
            <button class="filter-btn">Headphones</button>
            <button class="filter-btn">Powerbanks</button>
            <button class="filter-btn">Phone Cases</button>
            <button class="filter-btn">Earbuds</button>
        </div>

        <div class="price-filter" id="priceFilter">
            <button class="sort-btn" id="priceFilterToggle" type="button">
                Price
                <span class="sort-chevron"></span>
            </button>

            <div class="price-filter-menu" id="priceFilterMenu">
                <button class="price-option active" type="button">Low to High</button>
                <button class="price-option" type="button">High to Low</button>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-lg-4 col-md-6">
                <div class="card catalog-card">
                    <img src="<?= base_url('public/img/headphone1.jpg') ?>" class="card-img-top catalog-img"
                        alt="Headphone 1">
                    <div class="card-body">
                        <h5 class="card-title">Headphone 1</h5>
                        <p class="price">₱1,299</p>
                        <div class="card-actions">
                            <a href="<?= base_url('product-details') ?>" class="btn view-btn">View Product</a>
                            <button class="btn cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card catalog-card">
                    <img src="<?= base_url('img/headphone2.jpg') ?>" class="card-img-top catalog-img" alt="Headphone 2">
                    <div class="card-body">
                        <h5 class="card-title">Headphone 2</h5>
                        <p class="price">₱1,499</p>
                        <div class="card-actions">
                            <button class="btn view-btn">View Product</button>
                            <button class="btn cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card catalog-card">
                    <img src="<?= base_url('img/powerbank1.jpg') ?>" class="card-img-top catalog-img" alt="Powerbank 1">
                    <div class="card-body">
                        <h5 class="card-title">Powerbank 1</h5>
                        <p class="price">₱899</p>
                        <div class="card-actions">
                            <button class="btn view-btn">View Product</button>
                            <button class="btn cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card catalog-card">
                    <img src="<?= base_url('img/powerbank2.jpg') ?>" class="card-img-top catalog-img" alt="Powerbank 2">
                    <div class="card-body">
                        <h5 class="card-title">Powerbank 2</h5>
                        <p class="price">₱999</p>
                        <div class="card-actions">
                            <button class="btn view-btn">View Product</button>
                            <button class="btn cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card catalog-card">
                    <img src="<?= base_url('img/case1.jpg') ?>" class="card-img-top catalog-img" alt="Phone Case 1">
                    <div class="card-body">
                        <h5 class="card-title">Phone Case 1</h5>
                        <p class="price">₱399</p>
                        <div class="card-actions">
                            <button class="btn view-btn">View Product</button>
                            <button class="btn cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card catalog-card">
                    <img src="<?= base_url('img/case2.jpg') ?>" class="card-img-top catalog-img" alt="Phone Case 2">
                    <div class="card-body">
                        <h5 class="card-title">Phone Case 2</h5>
                        <p class="price">₱499</p>
                        <div class="card-actions">
                            <button class="btn view-btn">View Product</button>
                            <button class="btn cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card catalog-card">
                    <img src="<?= base_url('img/earbuds1.jpg') ?>" class="card-img-top catalog-img" alt="Earbuds 1">
                    <div class="card-body">
                        <h5 class="card-title">Earbuds 1</h5>
                        <p class="price">₱799</p>
                        <div class="card-actions">
                            <button class="btn view-btn">View Product</button>
                            <button class="btn cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card catalog-card">
                    <img src="<?= base_url('img/earbuds2.jpg') ?>" class="card-img-top catalog-img" alt="Earbuds 2">
                    <div class="card-body">
                        <h5 class="card-title">Earbuds 2</h5>
                        <p class="price">₱999</p>
                        <div class="card-actions">
                            <button class="btn view-btn">View Product</button>
                            <button class="btn cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</section>

<?= view('include/footer') ?>