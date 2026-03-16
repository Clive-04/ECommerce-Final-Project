<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="cart-page">
    <div class="container">
        <div class="cart-header text-center">
            <h1>My Shopping Cart</h1>
            <div class="cart-divider"></div>
        </div>

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

        <div class="cart-layout">
            <div class="cart-items-panel">
                <div class="cart-table-head">
                    <span>Product</span>
                    <span>Price</span>
                    <span>Total</span>
                </div>

                <?php $cart = $cart ?? []; ?>

                <?php if (! empty($cart) && is_array($cart)): ?>
                    <?php $subtotal = 0; ?>
                    <?php foreach ($cart as $item): ?>
                        <?php $subtotal += $item['total']; ?>
                        <div class="cart-item" data-item-id="<?= esc($item['id']) ?>">
                            <div class="cart-product">
                                <div class="cart-product-image">
                                    <img src="<?= base_url($item['image'] ?: 'public/img/product1.jpg') ?>" alt="<?= esc($item['name']) ?>">
                                </div>

                                <div class="cart-product-info">
                                    <h3><?= esc($item['name']) ?></h3>
                                    <p class="cart-product-meta"><?= esc($item['description'] ?? '') ?></p>

                                    <div class="cart-item-actions">
                                        <form action="<?= base_url('/cart/update') ?>" method="post" class="cart-update-form">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id" value="<?= esc($item['id']) ?>">
                                            <input type="hidden" name="quantity" class="cart-qty-hidden" value="<?= esc($item['quantity']) ?>">

                                            <div class="cart-qty-box" data-price="<?= esc($item['price']) ?>">
                                                <button type="button" class="cart-qty-btn qty-decrease">−</button>
                                                <span class="cart-qty-value"><?= esc($item['quantity']) ?></span>
                                                <button type="button" class="cart-qty-btn qty-increase">+</button>
                                            </div>

                                            <button type="submit" class="view-btn">Edit</button>
                                        </form>

                                        <form action="<?= base_url('/cart/remove') ?>" method="post" class="inline-form">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id" value="<?= esc($item['id']) ?>">
                                            <button type="submit" class="cart-btn">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-price">₱<?= number_format($item['price'], 2) ?></div>
                            <div class="cart-total">₱<?= number_format($item['total'], 2) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Your cart is empty. <a href="<?= base_url('products') ?>">Browse products</a> to get started.</p>
                <?php endif; ?>
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

                    <?php $subtotal = isset($subtotal) ? $subtotal : 0; ?>
                    <div class="summary-lines">
                        <div class="summary-line summary-main">
                            <span>Subtotal</span>
                            <span id="subtotalAmount">₱<?= number_format($subtotal, 2) ?></span>
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
                        <span id="estimatedTotal">₱<?= number_format($subtotal, 2) ?></span>
                    </div>

                    <a href="<?= base_url('checkout?mode=cart') ?>" class="checkout-btn">Checkout</a>
                </div>
            </aside>
        </div>
    </div>
</section>

<script>
(function () {
  const formatCurrency = (value) => {
    return '₱' + value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  };

  const recalcSummary = () => {
    let subtotal = 0;
    document.querySelectorAll('.cart-total').forEach((totalEl) => {
      const totalValue = parseFloat(totalEl.dataset.total || '0');
      subtotal += isNaN(totalValue) ? 0 : totalValue;
    });

    const subtotalEl = document.getElementById('subtotalAmount');
    const estimatedEl = document.getElementById('estimatedTotal');
    if (subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);
    if (estimatedEl) estimatedEl.textContent = formatCurrency(subtotal);
  };

  document.querySelectorAll('.cart-item').forEach((item) => {
    const qtyBox = item.querySelector('.cart-qty-box');
    const qtyValueEl = item.querySelector('.cart-qty-value');
    const qtyInput = item.querySelector('.cart-qty-hidden');
    const totalEl = item.querySelector('.cart-total');
    const price = parseFloat(qtyBox?.dataset?.price || '0');

    if (!qtyBox || !qtyValueEl || !qtyInput || !totalEl) return;

    const setQuantity = (value) => {
      const qty = Math.max(1, Math.floor(value));
      qtyValueEl.textContent = qty;
      qtyInput.value = qty;

      const newTotal = price * qty;
      totalEl.dataset.total = newTotal.toFixed(2);
      totalEl.textContent = formatCurrency(newTotal);
      recalcSummary();
    };

    const decreaseBtn = qtyBox.querySelector('.qty-decrease');
    const increaseBtn = qtyBox.querySelector('.qty-increase');

    if (decreaseBtn) {
      decreaseBtn.addEventListener('click', () => {
        setQuantity(parseInt(qtyValueEl.textContent, 10) - 1);
      });
    }

    if (increaseBtn) {
      increaseBtn.addEventListener('click', () => {
        setQuantity(parseInt(qtyValueEl.textContent, 10) + 1);
      });
    }

    // Initialize total data attribute for summary calculation
    totalEl.dataset.total = (price * parseInt(qtyValueEl.textContent, 10)).toFixed(2);
  });

  // Initial summary update
  recalcSummary();
})();
</script>

<?= view('include/footer') ?>