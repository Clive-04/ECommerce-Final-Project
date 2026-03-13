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
                    <label class="payment-option active">
                        <input type="radio" name="payment_method" checked>
                        <div class="payment-option-inner">
                            <div class="payment-option-header">
                                <span class="payment-option-title">Credit / Debit Card</span>
                            </div>

                            <div class="payment-card-form">
                                <div class="form-group">
                                    <label for="cardNumber">Card Number*</label>
                                    <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456">
                                </div>

                                <div class="form-group">
                                    <label for="cardName">Card Holder Name*</label>
                                    <input type="text" id="cardName" placeholder="Full name on card">
                                </div>

                                <div class="payment-grid">
                                    <div class="form-group">
                                        <label for="expiryDate">Expiry Date*</label>
                                        <input type="text" id="expiryDate" placeholder="MM/YY">
                                    </div>

                                    <div class="form-group">
                                        <label for="ccv">CCV*</label>
                                        <input type="text" id="ccv" placeholder="123">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="payment-option compact-option">
                        <input type="radio" name="payment_method">
                        <div class="payment-option-inner">
                            <div class="payment-option-header">
                                <span class="payment-option-title">E-Wallet</span>
                            </div>
                            <p class="payment-option-note">Use a digital wallet once backend integration is available.
                            </p>
                        </div>
                    </label>

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

                <div class="summary-products">
                    <div class="summary-product-line">
                        <span>Headphone 1</span>
                        <span>₱1,299</span>
                    </div>

                    <div class="summary-product-line">
                        <span>Phone Case 1 x2</span>
                        <span>₱798</span>
                    </div>
                </div>

                <div class="summary-totals">
                    <div class="summary-line">
                        <span>Subtotal</span>
                        <span>₱2,097</span>
                    </div>

                    <div class="summary-line">
                        <span>Shipping</span>
                        <span>₱120</span>
                    </div>

                    <div class="summary-line">
                        <span>Tax</span>
                        <span>TBD</span>
                    </div>
                </div>

                <div class="summary-grand-total">
                    <span>Total</span>
                    <span>₱2,217</span>
                </div>
            </aside>
        </div>
    </div>
</section>

<?= view('include/footer') ?>