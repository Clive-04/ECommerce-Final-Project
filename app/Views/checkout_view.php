<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="checkout-page">
    <div class="container">
        <div class="checkout-header text-center">
            <h1>Checkout</h1>
            <div class="checkout-divider"></div>
        </div>

        <div class="checkout-steps">
            <div class="step-item active">
                <div class="step-circle">1</div>
                <span>Customer Info</span>
            </div>

            <div class="step-line"></div>

            <div class="step-item">
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
            <div class="checkout-form-card">
                <div class="section-title-wrap">
                    <h2>Customer Information</h2>
                    <p>Enter your details below to continue to shipping.</p>
                </div>

                <form>
                    <div class="checkout-grid two-col">
                        <div class="form-group">
                            <label for="firstName">First Name*</label>
                            <input type="text" id="firstName" placeholder="Enter first name">
                        </div>

                        <div class="form-group">
                            <label for="lastName">Last Name*</label>
                            <input type="text" id="lastName" placeholder="Enter last name">
                        </div>
                    </div>

                    <div class="checkout-grid one-col">
                        <div class="form-group">
                            <label for="emailAddress">Email Address*</label>
                            <input type="email" id="emailAddress" placeholder="Enter email address">
                        </div>
                    </div>

                    <div class="checkout-grid one-col">
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number*</label>
                            <input type="text" id="phoneNumber" placeholder="Enter phone number">
                        </div>
                    </div>

                    <div class="checkout-grid one-col">
                        <div class="form-group">
                            <label for="streetAddress">Street Address*</label>
                            <input type="text" id="streetAddress" placeholder="Enter street address">
                        </div>
                    </div>

                    <div class="checkout-grid two-col">
                        <div class="form-group">
                            <label for="city">City*</label>
                            <input type="text" id="city" placeholder="Enter city">
                        </div>

                        <div class="form-group">
                            <label for="province">State/Province*</label>
                            <input type="text" id="province" placeholder="Enter state or province">
                        </div>
                    </div>

                    <div class="checkout-grid one-col">
                        <div class="form-group">
                            <label for="postalCode">Postal Code*</label>
                            <input type="text" id="postalCode" placeholder="Enter postal code">
                        </div>
                    </div>

                    <div class="checkout-action">
                        <a href="<?= base_url('shipping') ?>" class="continue-btn">Continue to Shipping</a>
                    </div>
                </form>
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
                        <span>TBD</span>
                    </div>

                    <div class="summary-line">
                        <span>Tax</span>
                        <span>TBD</span>
                    </div>
                </div>

                <div class="summary-grand-total">
                    <span>Total</span>
                    <span>₱2,097</span>
                </div>
            </aside>
        </div>
    </div>
</section>

<?= view('include/footer') ?>