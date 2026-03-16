<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="checkout-page confirmation-page">
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

            <div class="step-item completed">
                <div class="step-circle">3</div>
                <span>Payment</span>
            </div>

            <div class="step-line active"></div>

            <div class="step-item active">
                <div class="step-circle">4</div>
                <span>Confirmation</span>
            </div>
        </div>

        <div class="checkout-layout">
            <div class="confirmation-main">
                <?php $customer = $customer ?? []; ?>
                <?php $cart = $cart ?? []; ?>
                <?php $shipping = $shipping ?? 'standard'; ?>
                <?php $paymentMethod = $paymentMethod ?? 'Cash on Delivery'; ?>

                <?php $subtotal = 0; ?>
                <?php foreach ($cart as $item): ?>
                    <?php $subtotal += $item['total']; ?>
                <?php endforeach; ?>

                <?php
                    $shippingOptions = [
                        'standard' => ['label' => 'Standard Shipping', 'price' => 120],
                        'express' => ['label' => 'Express Shipping', 'price' => 220],
                        'overnight' => ['label' => 'Overnight Shipping', 'price' => 350],
                    ];
                    $shippingLabel = $shippingOptions[$shipping]['label'] ?? $shippingOptions['standard']['label'];
                    $shippingCost = $shippingOptions[$shipping]['price'] ?? $shippingOptions['standard']['price'];
                    $grandTotal = $subtotal + $shippingCost;

                    $fullName = trim(($customer['first_name'] ?? '') . ' ' . ($customer['last_name'] ?? '')) ?: 'N/A';
                    $deliveryAddress = [];
                    if (! empty($customer['street_address'])) {
                        $deliveryAddress[] = $customer['street_address'];
                    }
                    if (! empty($customer['city'])) {
                        $deliveryAddress[] = $customer['city'];
                    }
                    if (! empty($customer['state_province'])) {
                        $deliveryAddress[] = $customer['state_province'];
                    }
                    if (! empty($customer['postal_code'])) {
                        $deliveryAddress[] = $customer['postal_code'];
                    }
                    $deliveryAddress = $deliveryAddress ? implode(', ', $deliveryAddress) : 'N/A';
                ?>

                <div class="review-card">
                    <div class="review-card-header">
                        <h2>Customer Information</h2>
                    </div>

                    <div class="review-info-grid">
                        <div class="review-info-item">
                            <span class="review-label">Name</span>
                            <span class="review-value"><?= esc($fullName) ?></span>
                        </div>

                        <div class="review-info-item">
                            <span class="review-label">Email</span>
                            <span class="review-value"><?= esc($customer['email'] ?? 'N/A') ?></span>
                        </div>

                        <div class="review-info-item">
                            <span class="review-label">Phone</span>
                            <span class="review-value"><?= esc($customer['phone_number'] ?? 'N/A') ?></span>
                        </div>

                        <div class="review-info-item">
                            <span class="review-label">Delivery Address</span>
                            <span class="review-value"><?= esc($deliveryAddress) ?></span>
                        </div>
                    </div>
                </div>

                <div class="review-card compact-card">
                    <div class="review-card-header">
                        <h2>Payment Method</h2>
                    </div>

                    <div class="review-payment-box">
                        <span class="review-label">Selected Method</span>
                        <span class="review-value"><?= esc($paymentMethod) ?></span>
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card-header">
                        <h2>Ordered Items</h2>
                    </div>

                    <div class="ordered-items-list">
                        <?php if (! empty($cart) && is_array($cart)): ?>
                            <?php foreach ($cart as $item): ?>
                                <div class="ordered-item">
                                    <span><?= esc($item['name']) ?> x<?= esc($item['quantity']) ?></span>
                                    <span>₱<?= number_format($item['total'], 2) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Your cart is empty.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="confirmation-actions">
                    <a href="<?= base_url('payment') ?>" class="back-btn">Back</a>
                    <button type="button" class="place-order-btn" data-bs-toggle="modal"
                        data-bs-target="#orderSuccessModal">
                        Place Order
                    </button>

                </div>
            </div>

            <aside class="checkout-summary-card">
                <h2>Order Summary</h2>

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
                            <span>₱<?= number_format($subtotal, 2) ?></span>
                        </div>

                        <div class="summary-line">
                            <span>Shipping (<?= esc($shippingLabel) ?>)</span>
                            <span>₱<?= number_format($shippingCost, 2) ?></span>
                        </div>
                    </div>

                    <div class="summary-grand-total">
                        <span>Total</span>
                        <span>₱<?= number_format($grandTotal, 2) ?></span>
                    </div>
                <?php else: ?>
                    <p>Your cart is empty. <a href="<?= base_url('products') ?>">Browse products</a> to add items.</p>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>
<div class="modal fade order-success-modal" id="orderSuccessModal" tabindex="-1"
    aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content order-success-content">
            <div class="modal-body text-center">
                <div class="success-badge">Order Confirmed</div>
                <h2 id="orderSuccessModalLabel">Thank You for Your Purchase</h2>
                <p>
                    Your order has been placed successfully. We appreciate your trust in VIZIO.
                </p>

                <a href="<?= base_url('products') ?>" class="success-continue-btn">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>

<?= view('include/footer') ?>