<?= view('include/header') ?>

<section class="admin-page">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-sidebar-top">
                <h2 class="admin-brand">Admin Panel</h2>

                <nav class="admin-nav">
                    <a href="<?= base_url('/admin') ?>" class="admin-nav-link">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="<?= base_url('/admin/products') ?>" class="admin-nav-link">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                    </a>

                    <a href="<?= base_url('/admin/orders') ?>" class="admin-nav-link active">
                        <i class="bi bi-bag"></i>
                        <span>Orders</span>
                    </a>
                </nav>
            </div>

            <div class="admin-sidebar-bottom">
                <a href="<?= base_url('/logout') ?>" class="admin-nav-link logout-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main -->
        <main class="admin-main">
            <div class="admin-topbar">
                <div>
                    <p class="admin-kicker">Order Detail</p>
                    <h1>Order #ORD-<?= esc($order['id'] ?? '') ?></h1>
                </div>

                <div class="admin-user">
                    <div class="admin-user-text">
                        <span class="admin-user-label">User</span>
                        <strong><?= esc($adminName ?? 'Admin') ?></strong>
                    </div>
                    <div class="admin-user-avatar"><?= esc(strtoupper(substr($adminName ?? 'A', 0, 1))) ?></div>
                </div>
            </div>

            <section class="admin-panel-card product-table-card">
                <div class="panel-header">
                    <div>
                        <h3>Order Details</h3>
                        <p class="panel-subtext">Review order items, status, and customer information.</p>
                    </div>

                    <div class="panel-actions">
                        <a href="<?= base_url('/admin/orders') ?>" class="admin-outline-btn">Back to orders</a>
                    </div>
                </div>

                <?php $statusClass = strtolower(str_replace(' ', '-', $order['status'] ?? '')); ?>

                <div class="order-detail-grid">
                    <h4>Order Summary</h4>

                    <div class="order-summary-grid">
                        <div class="summary-column">
                            <div class="summary-item">
                                <span class="summary-label">Order: </span>
                                <span class="summary-value">#ORD-<?= esc($order['id'] ?? '') ?></span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-label">Date: </span>
                                <span class="summary-value"><?= esc(date('M d, Y H:i', strtotime($order['order_date'] ?? ''))); ?></span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-label">Customer:</span>
                                <span class="summary-value"><?= esc($customerName ?? '') ?></span>
                            </div>
                        </div>

                        <div class="summary-column">
                            <div class="summary-item">
                                <span class="summary-label">Items</span>
                                <span class="summary-value"><?= esc($itemCount ?? 0) ?> item<?= (int) ($itemCount ?? 0) === 1 ? '' : 's' ?></span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-label">Email</span>
                                <span class="summary-value"><?= esc($customerEmail ?? '') ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-items">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (! empty($items) && is_array($items)): ?>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><?= esc($item['product_name'] ?? 'Unknown') ?></td>
                                        <td><?= esc($item['quantity'] ?? 0) ?></td>
                                        <td>₱<?= number_format($item['price'] ?? 0, 2) ?></td>
                                        <td>₱<?= number_format((($item['price'] ?? 0) * ($item['quantity'] ?? 0)), 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No items found for this order.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right; padding: 14px 16px; color: #d7def0; font-weight: 700;">Grand Total</td>
                                <td style="padding: 14px 16px; color: #ffffff; font-weight: 700;">₱<?= number_format($order['total'] ?? 0, 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </main>
    </div>
</section>
