<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="catalog container">
    <div class="catalog-header text-center">
        <h2>Explore Our Products</h2>
        <div class="catalog-divider"></div>
    </div>

    <?php
    $selectedCategory = isset($selectedCategory) ? strtolower(preg_replace('/\s+/', '', $selectedCategory)) : '';

    $categories = [
        'All' => '',
        'Headphones' => 'Headphones',
        'Powerbanks' => 'Powerbanks',
        'Phone Cases' => 'Phonecases',
        'Earbuds' => 'Earbuds',
    ];
    ?>

    <div class="catalog-toolbar">
        <div class="catalog-filters">
            <?php foreach ($categories as $label => $value): ?>
                <?php $normalized = strtolower(preg_replace('/\s+/', '', $value)); ?>
                <a href="<?= base_url('/products' . ($value !== '' ? '?category=' . urlencode($value) : '')) ?>" class="filter-btn <?= $selectedCategory === $normalized ? 'active' : '' ?>"><?= esc($label) ?></a>
            <?php endforeach ?>
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
    </div>

    <div class="row g-4">
        <?php if (! empty($products) && is_array($products)): ?>
            <?php foreach ($products as $prod): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card catalog-card">
                        <img src="<?= base_url($prod['image'] ?: 'public/img/product1.jpg') ?>" class="card-img-top catalog-img" alt="<?= esc($prod['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($prod['name']) ?></h5>
                            <p class="price">₱<?= number_format($prod['price'], 2) ?></p>
                            <div class="card-actions">
                                <a href="<?= base_url('product-details?id=' . $prod['id']) ?>" class="btn view-btn">View Product</a>

                                <form action="<?= base_url('/cart/add') ?>" method="post" class="inline-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= esc($prod['id']) ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn cart-btn">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif ?>
    </div>
</section>

<?= view('include/footer') ?>