<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="product-details-page">
    <div class="container">
        <div class="product-details-card">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5">
                    <div class="product-image-panel">
                        <img src="<?= base_url(isset($product['image']) ? $product['image'] : 'public/img/product1.jpg') ?>" alt="<?= isset($product['name']) ? esc($product['name']) : 'Product' ?>" class="product-main-image">
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="product-content">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert success-alert">
                                <?= esc(session()->getFlashdata('success')) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert error-alert">
                                <?= esc(session()->getFlashdata('error')) ?>
                            </div>
                        <?php endif; ?>

                        <div class="product-title-wrap">
                            <h1><?= isset($product['name']) ? esc($product['name']) : 'Product' ?></h1>
                        </div>

                        <div class="product-rating-row">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">4.8 rating</span>
                        </div>

                        <div class="product-price-wrap">
                            <span class="product-price">₱<?= isset($product['price']) ? number_format($product['price'], 2) : '0.00' ?></span>
                            <span class="product-price-note">Inclusive of placeholder pricing</span>
                        </div>

                        <div class="product-summary-box">
                            <h3>Short Description</h3>
                            <p>
                                <?= nl2br(esc($product['short_description'] ?? $product['description'] ?? 'No short description available.')) ?>
                            </p>
                        </div>

                        <div class="product-meta-grid">
                            <div class="meta-card">
                                <span class="meta-label">Category</span>
                                <span class="meta-value"><?= isset($product['category']) ? esc($product['category']) : 'Uncategorized' ?></span>
                            </div>

                            <div class="meta-card">
                                <span class="meta-label">Availability</span>
                                <span class="meta-value <?= (isset($product['stock']) && $product['stock'] > 0) ? 'in-stock' : 'out-stock' ?>"><?php if (isset($product['stock'])) { echo ($product['stock'] > 0) ? 'In Stock' : 'Out of Stock'; } else { echo 'N/A'; } ?></span>
                            </div>
                        </div>

                        <div class="quantity-row">
                            <span class="qty-label">Quantity</span>
                            <div class="qty-box" data-max="<?= isset($product['stock']) ? (int) $product['stock'] : 1 ?>">
                                <button type="button" class="qty-btn" id="qtyMinus">−</button>
                                <span class="qty-value" id="qtyValue">1</span>
                                <button type="button" class="qty-btn" id="qtyPlus">+</button>
                                <input type="hidden" name="quantity" id="qtyInput" value="1">
                            </div>
                        </div>

                        <div class="product-actions">
                            <form action="<?= base_url('/cart/add') ?>" method="post" class="inline-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= isset($product['id']) ? esc($product['id']) : '' ?>">
                                <input type="hidden" name="quantity" id="addToCartQuantity" value="1">
                                <button class="detail-cart-btn" type="submit" <?= (isset($product['stock']) && $product['stock'] <= 0) ? 'disabled' : '' ?>>Add to Cart</button>
                            </form>

                            <form action="<?= base_url('/cart/buy') ?>" method="post" class="inline-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= isset($product['id']) ? esc($product['id']) : '' ?>">
                                <input type="hidden" name="quantity" id="buyNowQuantity" value="1">
                                <button class="detail-buy-btn" type="submit" <?= (isset($product['stock']) && $product['stock'] <= 0) ? 'disabled' : '' ?>>Buy Now</button>
                            </form>
                        </div>

                        <script>
                            (function() {
                                const maxStock = parseInt(document.querySelector('.qty-box').dataset.max, 10) || 1;
                                const qtyValueEl = document.getElementById('qtyValue');
                                const qtyInput = document.getElementById('qtyInput');
                                const addToCartQty = document.getElementById('addToCartQuantity');
                                const buyNowQty = document.getElementById('buyNowQuantity');

                                function setQuantity(value) {
                                    const qty = Math.max(1, Math.min(maxStock, value));
                                    qtyValueEl.textContent = qty;
                                    qtyInput.value = qty;
                                    addToCartQty.value = qty;
                                    buyNowQty.value = qty;
                                }

                                document.getElementById('qtyMinus').addEventListener('click', function() {
                                    setQuantity(parseInt(qtyValueEl.textContent, 10) - 1);
                                });

                                document.getElementById('qtyPlus').addEventListener('click', function() {
                                    setQuantity(parseInt(qtyValueEl.textContent, 10) + 1);
                                });

                                // Ensure inputs stay in sync if manually changed
                                setQuantity(1);
                            })();
                        </script>

                    </div>
                </div>
            </div>
        </div>

        <div class="product-info-area">
            <div class="info-block">
                <div class="info-heading-box">
                    <h2>Product Specifications</h2>
                </div>
                <p>
                    <?= nl2br(esc($product['specifications'] ?? 'No specifications available.')) ?>
                </p>
            </div>

            <div class="info-block">
                <div class="info-heading-box">
                    <h2>Product Description</h2>
                </div>
                <p>
                    <?= nl2br(esc($product['description'] ?? 'No product description available.')) ?>
                </p>
            </div>
        </div>
    </div>
</section>

<?= view('include/footer') ?>