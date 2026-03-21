<?= view('include/header') ?>

<section class="admin-page">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-sidebar-top">
                <h2 class="admin-brand">Admin Panel</h2>

                <nav class="admin-nav">
                    <a href="#" class="admin-nav-link active">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="<?= base_url('/admin/products') ?>" class="admin-nav-link">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                    </a>

                    <a href="<?= base_url('/admin/orders') ?>" class="admin-nav-link">
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

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-topbar">
                <div>
                    <p class="admin-kicker">Overview</p>
                    <h1>Dashboard</h1>
                </div>

                <?php $adminName = $adminName ?? 'Admin'; ?>
                <div class="admin-user">
                    <div class="admin-user-text">
                        <span class="admin-user-label">User</span>
                        <strong><?= esc($adminName) ?></strong>
                    </div>
                    <div class="admin-user-avatar"><?= esc(strtoupper(substr($adminName, 0, 1))) ?></div>
                </div>
            </div>

            <!-- Stats -->
            <section class="admin-stats">
                <div class="stat-card">
                    <div class="stat-icon revenue">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <p class="stat-label">Total Revenue</p>
                        <h3>₱<?= number_format($totalRevenue ?? 0, 2) ?></h3>
                        <span class="stat-sub">Since launch</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orders">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <p class="stat-label">Total Orders</p>
                        <h3><?= esc($totalOrders ?? 0) ?></h3>
                        <span class="stat-sub"><?= esc($pendingOrders ?? 0) ?> pending orders</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon products">
                        <i class="bi bi-box"></i>
                    </div>
                    <div>
                        <p class="stat-label">Total Products</p>
                        <h3><?= esc($totalProducts ?? 0) ?></h3>
                        <span class="stat-sub"><?= esc($lowStockCount ?? 0) ?> low stock items</span>
                    </div>
                </div>
            </section>

            <!-- Mid Content -->
            <section class="admin-grid-two">
                <div class="admin-panel-card tall-card">
                    <div class="panel-header">
                        <h3>Recent Orders</h3>
                        <a href="<?= base_url('/admin/orders') ?>">View all</a>
                    </div>

                    <div class="order-list">
                        <?php if (! empty($recentOrders) && is_array($recentOrders)): ?>
                            <?php foreach ($recentOrders as $order): ?>
                                <?php $statusClass = strtolower(str_replace(' ', '-', $order['status'] ?? '')); ?>
                                <div class="order-item">
                                    <div>
                                        <strong>#ORD-<?= esc($order['order_number']) ?></strong>
                                        <p><?= esc($order['product'] ?: '—') ?></p>
                                    </div>
                                    <span class="status-pill <?= esc($statusClass) ?>"><?= esc($order['status']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="order-item">
                                <div>
                                    <p>No recent orders found.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="admin-panel-card tall-card">
                    <div class="panel-header">
                        <h3>Top Products</h3>
                        <a href="<?= base_url('/admin/products') ?>">Manage</a>
                    </div>

                    <div class="product-rank-list">
                        <?php if (! empty($topProducts) && is_array($topProducts)): ?>
                            <?php foreach ($topProducts as $index => $product): ?>
                                <div class="rank-item">
                                    <span class="rank-number"><?= esc(str_pad($index + 1, 2, '0', STR_PAD_LEFT)) ?></span>
                                    <div>
                                        <strong><?= esc($product['name']) ?></strong>
                                        <p><?= esc($product['soldQty']) ?> units sold</p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="rank-item">
                                <span class="rank-number">01</span>
                                <div>
                                    <strong>No products sold yet</strong>
                                    <p>—</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- Bottom Content -->
            <section class="admin-grid-bottom">
                <div class="admin-panel-card sales-card">
                    <div class="panel-header">
                        <h3>Sales Overview</h3>
                        <a href="#">Details</a>
                    </div>

                    <div class="sales-placeholder">
                        <div class="sales-bars">
                            <?php if (! empty($salesOverview)): ?>
                                <?php foreach ($salesOverview as $day): ?>
                                    <div
                                        class="bar"
                                        style="height: <?= esc($day['height']) ?>%;"
                                        title="<?= esc($day['label']) ?> (<?= esc($day['date']) ?>) - ₱<?= number_format($day['amount'], 2) ?>"
                                    ></div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="bar" style="height: 12%;"></div>
                            <?php endif; ?>
                        </div>

                        <div class="sales-labels">
                            <?php if (! empty($salesOverview)): ?>
                                <?php foreach ($salesOverview as $day): ?>
                                    <span><?= esc($day['label']) ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                </div>
            </section>
        </main>
    </div>
</section>