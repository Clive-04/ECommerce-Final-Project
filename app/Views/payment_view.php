<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="checkout-page payment-page">
    <div class="container">
        <div class="checkout-header text-center">
            <h1>Checkout</h1>
            <div class="checkout-divider"></div>
        </div>

        <div class="checkout-steps">
            <div class="step-item completed">
                <div class="step-circle">1</div>
                <span>Customer Info</span>
            </div>

            <div class="step-line active"></div>

            <div class="step-item completed">
                <div class="step-circle">2</div>
                <span>Shipping</span>
            </div>

            <div class="step-line active"></div>

            <div class="step-item active">
                <div class="step-circle">3</div>
                <span>Payment</span>
            </div>

            <div class="step-line"></div>

            <div class="step-item">
                <div class="step-circle">4</div>
                <span>Confirmation</span>
            </div>
        </div>

        <div class="checkout-layout">
            <div class="payment-form-card">
                <div class="section-title-wrap">
                    <h2>Payment Method</h2>
                    <p>Choose a payment option for this placeholder checkout flow.</p>
                </div>

                <div class="payment-methods">
                    <label class="payment-option compact-option">
                        <input type="radio" name="payment_method">
                        <div class="payment-option-inner">
                            <div class="payment-option-header">
                                <span class="payment-option-title">Cash on Delivery</span>
                            </div>
                            <p class="payment-option-note">Pay when your order arrives at your address.</p>
                        </div>
                    </label>
                </div>

                <div class="payment-actions">
                    <a href="<?= base_url('shipping') ?>" class="back-btn">Back</a>
                    <a href="<?= base_url('confirmation') ?>" class="continue-btn">Continue to Review</a>
                </div>
            </div>

            <aside class="checkout-summary-card">
                <h2>Order Summary</h2>
                <?php if (!empty($orderSummary)): ?>
                    <div class="summary-products">
                        <?php foreach ($orderSummary as $item): ?>
                            <div class="summary-product-line">
                                <span><?= esc($item['name']) ?> x<?= esc($item['quantity']) ?></span>
                                <span>₱<?= number_format($item['total'], 2) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="summary-totals">
                        <div class="summary-line">
                            <span>Subtotal</span>
                            <span>₱<?= number_format($orderTotal, 2) ?></span>
                        </div>
                        <div class="summary-line">
                            <span>Shipping</span>
                            <span>₱<?= number_format($shippingPrices[$shipping] ?? 120, 2) ?></span>
                        </div>
                    </div>
                    <div class="summary-grand-total">
                        <span>Total</span>
                        <span>₱<?= number_format(($orderTotal + ($shippingPrices[$shipping] ?? 120)), 2) ?></span>
                    </div>
                <?php else: ?>
                    <p>Your cart is empty. <a href="<?= base_url('products') ?>">Browse products</a> to add items.</p>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>

<?= view('include/footer') ?>