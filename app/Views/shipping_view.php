<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="checkout-page shipping-page">
    <div class="container">
        <div class="checkout-header text-center">
            <h1>Checkout</h1>
            <div class="checkout-divider"></div>
        </div>

        <div class="checkout-steps">
            <div class="step-item completed">
                <div class="step-circle">&#10003;</div>
                <span>Customer Info</span>
            </div>

            <div class="step-line active"></div>

            <div class="step-item active">
                <div class="step-circle">2</div>
                <span>Shipping</span>
            </div>

            <div class="step-line"></div>

            <div class="step-item">
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
            <div class="shipping-form-card">
                <div class="section-title-wrap">
                    <h2>Shipping Method</h2>
                    <p>Select your preferred delivery option for this placeholder checkout flow.</p>
                </div>

                <div class="shipping-options-wrap">
                    <h3>Select Shipping Option</h3>

                    <label class="shipping-option active">
                        <input type="radio" name="shipping_method" checked>
                        <div class="shipping-option-inner">
                            <div class="shipping-option-left">
                                <div class="shipping-icon">📦</div>
                                <div>
                                    <div class="shipping-name">Standard Shipping</div>
                                    <div class="shipping-desc">Delivered within 3-5 business days.</div>
                                </div>
                            </div>
                            <div class="shipping-price">₱120</div>
                        </div>
                    </label>

                    <label class="shipping-option">
                        <input type="radio" name="shipping_method">
                        <div class="shipping-option-inner">
                            <div class="shipping-option-left">
                                <div class="shipping-icon">🚚</div>
                                <div>
                                    <div class="shipping-name">Express Shipping</div>
                                    <div class="shipping-desc">Faster delivery for urgent orders.</div>
                                </div>
                            </div>
                            <div class="shipping-price">₱220</div>
                        </div>
                    </label>

                    <label class="shipping-option">
                        <input type="radio" name="shipping_method">
                        <div class="shipping-option-inner">
                            <div class="shipping-option-left">
                                <div class="shipping-icon">🌙</div>
                                <div>
                                    <div class="shipping-name">Overnight Shipping</div>
                                    <div class="shipping-desc">Next-day delivery placeholder option.</div>
                                </div>
                            </div>
                            <div class="shipping-price">₱350</div>
                        </div>
                    </label>
                </div>

                <div class="delivery-note-card">
                    <div class="delivery-note-title">
                        <span class="delivery-pin">📍</span>
                        <h4>Estimated Delivery Time</h4>
                    </div>
                    <p>
                        Orders placed today are expected to arrive within the selected delivery window.
                        Final timings will be updated once backend shipping integration is available.
                    </p>
                </div>

                <div class="shipping-actions">
                    <a href="<?= base_url('checkout') ?>" class="back-btn">Back</a>
                    <a href="<?= base_url('payment') ?>" class="continue-btn">Continue to Payment</a>
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