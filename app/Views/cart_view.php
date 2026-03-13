<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="cart-page">
    <div class="container">
        <div class="cart-header text-center">
            <h1>My Shopping Cart</h1>
            <div class="cart-divider"></div>
        </div>

        <div class="cart-layout">
            <div class="cart-items-panel">
                <div class="cart-table-head">
                    <span>Product</span>
                    <span>Price</span>
                    <span>Total</span>
                </div>

                <div class="cart-item">
                    <div class="cart-product">
                        <div class="cart-product-image">
                            <img src="<?= base_url('img/headphone1.jpg') ?>" alt="Headphone 1">
                        </div>

                        <div class="cart-product-info">
                            <h3>Headphone 1</h3>
                            <p class="cart-product-meta">Wireless over-ear audio with immersive sound and soft ear
                                cushions.</p>

                            <div class="cart-qty-box">
                                <button type="button" class="cart-qty-btn">−</button>
                                <span class="cart-qty-value">1</span>
                                <button type="button" class="cart-qty-btn">+</button>
                            </div>

                            <div class="cart-item-actions">
                                <a href="#">Remove</a>
                                <a href="<?= base_url('product-details') ?>">Edit</a>
                            </div>
                        </div>
                    </div>

                    <div class="cart-price">₱1,299</div>
                    <div class="cart-total">₱1,299</div>
                </div>

                <div class="cart-item">
                    <div class="cart-product">
                        <div class="cart-product-image">
                            <img src="<?= base_url('img/case1.jpg') ?>" alt="Phone Case 1">
                        </div>

                        <div class="cart-product-info">
                            <h3>Phone Case 1</h3>
                            <p class="cart-product-meta">Shock-resistant everyday protection with a slim premium finish.
                            </p>

                            <div class="cart-qty-box">
                                <button type="button" class="cart-qty-btn">−</button>
                                <span class="cart-qty-value">2</span>
                                <button type="button" class="cart-qty-btn">+</button>
                            </div>

                            <div class="cart-item-actions">
                                <a href="#">Remove</a>
                                <a href="<?= base_url('product-details') ?>">Edit</a>
                            </div>
                        </div>
                    </div>

                    <div class="cart-price">₱399</div>
                    <div class="cart-total">₱798</div>
                </div>
            </div>

            <aside class="cart-summary">
                <div class="summary-card">
                    <h2>Summary</h2>

                    <div class="promo-section">
                        <label for="promoCode">Do you have a promo code?</label>
                        <div class="promo-form">
                            <input type="text" id="promoCode" placeholder="Enter code">
                            <button type="button">Apply</button>
                        </div>
                    </div>

                    <div class="summary-lines">
                        <div class="summary-line summary-main">
                            <span>Subtotal</span>
                            <span>₱2,097</span>
                        </div>

                        <div class="summary-line">
                            <span>Shipping</span>
                            <span>TBD</span>
                        </div>

                        <div class="summary-line">
                            <span>Sales Tax</span>
                            <span>TBD</span>
                        </div>
                    </div>

                    <div class="summary-total">
                        <span>Estimated Total</span>
                        <span>₱2,097</span>
                    </div>

                    <a href="<?= base_url('checkout') ?>" class="checkout-btn">Checkout</a>
                </div>
            </aside>
        </div>
    </div>
</section>

<?= view('include/footer') ?>