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
                <div class="review-card">
                    <div class="review-card-header">
                        <h2>Customer Information</h2>
                    </div>

                    <div class="review-info-grid">
                        <div class="review-info-item">
                            <span class="review-label">Name</span>
                            <span class="review-value">Juan Dela Cruz</span>
                        </div>

                        <div class="review-info-item">
                            <span class="review-label">Email</span>
                            <span class="review-value">juan.delacruz@email.com</span>
                        </div>

                        <div class="review-info-item">
                            <span class="review-label">Phone</span>
                            <span class="review-value">0917 123 4567</span>
                        </div>

                        <div class="review-info-item">
                            <span class="review-label">Delivery Address</span>
                            <span class="review-value">123 Sample Street, Quezon City, Metro Manila</span>
                        </div>
                    </div>
                </div>

                <div class="review-card compact-card">
                    <div class="review-card-header">
                        <h2>Payment Method</h2>
                    </div>

                    <div class="review-payment-box">
                        <span class="review-label">Selected Method</span>
                        <span class="review-value">Credit / Debit Card</span>
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card-header">
                        <h2>Ordered Items</h2>
                    </div>

                    <div class="ordered-items-list">
                        <div class="ordered-item">
                            <span>Headphone 1</span>
                            <span>₱1,299</span>
                        </div>

                        <div class="ordered-item">
                            <span>Phone Case 1 x2</span>
                            <span>₱798</span>
                        </div>
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