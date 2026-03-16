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

                <?php $customer = $customer ?? []; ?>
                <?php $errors = $errors ?? []; ?>
                <?php $success = $success ?? null; ?>

                <?php if ($success): ?>
                    <div class="alert success-alert">
                        <?= esc($success) ?>
                    </div>
                <?php endif; ?>

                <?php if (! empty($errors) && is_array($errors)): ?>
                    <div class="alert error-alert">
                        <ul>
                            <?php foreach ($errors as $fieldError): ?>
                                <li><?= esc($fieldError) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('checkout/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="checkout-grid two-col">
                        <div class="form-group">
                            <label for="firstName">First Name*</label>
                            <input type="text" id="firstName" name="first_name" value="<?= esc(old('first_name', $customer['first_name'] ?? '')) ?>" placeholder="Enter first name">
                        </div>

                        <div class="form-group">
                            <label for="lastName">Last Name*</label>
                            <input type="text" id="lastName" name="last_name" value="<?= esc(old('last_name', $customer['last_name'] ?? '')) ?>" placeholder="Enter last name">
                        </div>
                    </div>

                    <div class="checkout-grid one-col">
                        <div class="form-group">
                            <label for="emailAddress">Email Address*</label>
                            <input type="email" id="emailAddress" name="email" value="<?= esc(old('email', $customer['email'] ?? '')) ?>" placeholder="Enter email address">
                        </div>
                    </div>

                    <div class="checkout-grid one-col">
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number*</label>
                            <input type="text" id="phoneNumber" name="phone_number" value="<?= esc(old('phone_number', $customer['phone_number'] ?? '')) ?>" placeholder="Enter phone number">
                        </div>
                    </div>

                    <div class="checkout-grid one-col">
                        <div class="form-group">
                            <label for="streetAddress">Street Address*</label>
                            <input type="text" id="streetAddress" name="street_address" value="<?= esc(old('street_address', $customer['street_address'] ?? '')) ?>" placeholder="Enter street address">
                        </div>
                    </div>

                    <div class="checkout-grid two-col">
                        <div class="form-group">
                            <label for="city">City*</label>
                            <input type="text" id="city" name="city" value="<?= esc(old('city', $customer['city'] ?? '')) ?>" placeholder="Enter city">
                        </div>

                        <div class="form-group">
                            <label for="province">State/Province*</label>
                            <input type="text" id="province" name="state_province" value="<?= esc(old('state_province', $customer['state_province'] ?? '')) ?>" placeholder="Enter state or province">
                        </div>
                    </div>

                    <div class="checkout-grid one-col">
                        <div class="form-group">
                            <label for="postalCode">Postal Code*</label>
                            <input type="text" id="postalCode" name="postal_code" value="<?= esc(old('postal_code', $customer['postal_code'] ?? '')) ?>" placeholder="Enter postal code">
                        </div>
                    </div>

                    <div class="checkout-action">
                        <button type="submit" class="continue-btn">Continue to Shipping</button>
                    </div>
                </form>
            </div>

            <aside class="checkout-summary-card">
                <h2>Order Summary</h2>

                <?php $cart = session()->get('cart') ?? []; ?>

                <?php if (! empty($cart) && is_array($cart)): ?>
                    <?php $subtotal = 0; ?>
                    <div class="summary-products">
                        <?php foreach ($cart as $item): ?>
                            <?php $subtotal += $item['total']; ?>
                            <div class="summary-product-line">
                                <span><?= esc($item['name']) ?> x<?= esc($item['quantity']) ?></span>
                                <span>₱<?= number_format($item['total'], 2) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="summary-totals">
                        <div class="summary-line">
                            <span>Subtotal</span>
                            <span>₱<?= number_format($subtotal, 2) ?></span>
                        </div>

                        <div class="summary-line">
                            <span>Shipping</span>
                            <span>TBD</span>
                        </div>
                    </div>

                    <div class="summary-grand-total">
                        <span>Total</span>
                        <span>₱<?= number_format($subtotal, 2) ?></span>
                    </div>
                <?php else: ?>
                    <p>Your cart is empty. <a href="<?= base_url('products') ?>">Browse products</a> to add items.</p>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>

<?= view('include/footer') ?>