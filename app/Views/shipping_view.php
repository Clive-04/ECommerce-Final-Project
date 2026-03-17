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
            <?php $cart = $cart ?? []; ?>
            <?php $shipping = $shipping ?? 'standard'; ?>
            <?php $errors = $errors ?? []; ?>
            <?php $success = $success ?? null; ?>

            <div class="shipping-form-card">
                <div class="section-title-wrap">
                    <h2>Shipping Method</h2>
                    <p>Select your preferred delivery option for this placeholder checkout flow.</p>
                </div>

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

                <form action="<?= base_url('shipping/save') ?>" method="post" id="shippingForm">
                    <?= csrf_field() ?>

                    <div class="shipping-options-wrap">
                        <h3>Select Shipping Option</h3>

                        <?php
                            $options = [
                                'standard' => [
                                    'label' => 'Standard Shipping',
                                    'desc' => 'Delivered within 3-5 business days.',
                                    'price' => 120,
                                    'icon' => '📦',
                                ],
                                'express' => [
                                    'label' => 'Express Shipping',
                                    'desc' => 'Faster delivery for urgent orders.',
                                    'price' => 220,
                                    'icon' => '🚚',
                                ],
                                'overnight' => [
                                    'label' => 'Overnight Shipping',
                                    'desc' => 'Next-day delivery placeholder option.',
                                    'price' => 350,
                                    'icon' => '🌙',
                                ],
                            ];
                        ?>

                        <?php foreach ($options as $key => $opt): ?>
                            <label class="shipping-option">
                                <input type="radio" name="shipping_method" value="<?= esc($key) ?>" <?= ($shipping === $key) ? 'checked' : '' ?>>
                                <div class="shipping-option-inner">
                                    <div class="shipping-option-left">
                                        <div class="shipping-icon"><?= esc($opt['icon']) ?></div>
                                        <div>
                                            <div class="shipping-name"><?= esc($opt['label']) ?></div>
                                            <div class="shipping-desc"><?= esc($opt['desc']) ?></div>
                                        </div>
                                    </div>
                                    <div class="shipping-price">₱<?= number_format($opt['price'], 2) ?></div>
                                </div>
                            </label>
                        <?php endforeach; ?>
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
                        <button type="submit" class="continue-btn">Continue to Payment</button>
                    </div>
                </form>
            </div>

            <aside class="checkout-summary-card">
                <h2>Order Summary</h2>

                <?php $subtotal = 0; ?>
                <?php foreach ($cart as $item): ?>
                    <?php $subtotal += $item['total']; ?>
                <?php endforeach; ?>

                <?php
                    $shippingPrices = [
                        'standard' => 120,
                        'express' => 220,
                        'overnight' => 350,
                    ];
                    $shippingCost = $shippingPrices[$shipping] ?? $shippingPrices['standard'];
                    $grandTotal = $subtotal + $shippingCost;
                ?>

                <?php if (! empty($cart) && is_array($cart)): ?>
                    <div class="summary-products">
                        <?php foreach ($cart as $item): ?>
                            <div class="summary-product-line">
                                <span><?= esc($item['name']) ?> x<?= esc($item['quantity']) ?></span>
                                <span>₱<?= number_format($item['total'], 2) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="summary-totals">
                        <div class="summary-line">
                            <span>Subtotal</span>
                            <span id="summarySubtotal">₱<?= number_format($subtotal, 2) ?></span>
                        </div>

                        <div class="summary-line">
                            <span>Shipping</span>
                            <span id="summaryShipping">₱<?= number_format($shippingCost, 2) ?></span>
                        </div>
                    </div>

                    <div class="summary-grand-total">
                        <span>Total</span>
                        <span id="summaryTotal">₱<?= number_format($grandTotal, 2) ?></span>
                    </div>
                <?php else: ?>
                    <p>Your cart is empty. <a href="<?= base_url('products') ?>">Browse products</a> to add items.</p>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>

<script>
(function () {
    const formatCurrency = (value) => {
        return '₱' + value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    };

    const shippingPrices = {
        standard: 120,
        express: 220,
        overnight: 350,
    };

    const subtotal = <?= json_encode($subtotal) ?>;

    const summaryShipping = document.getElementById('summaryShipping');
    const summaryTotal = document.getElementById('summaryTotal');

    const updateSummary = (shippingMethod) => {
        const shippingCost = shippingPrices[shippingMethod] ?? shippingPrices.standard;
        if (summaryShipping) summaryShipping.textContent = formatCurrency(shippingCost);
        if (summaryTotal) summaryTotal.textContent = formatCurrency(subtotal + shippingCost);
    };

    document.querySelectorAll('input[name="shipping_method"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            updateSummary(radio.value);
        });
    });
})();
</script>

<?= view('include/footer') ?>