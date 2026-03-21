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
                <a href="#" class="admin-nav-link logout-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main -->
        <main class="admin-main">
            <div class="admin-topbar">
                <div>
                    <p class="admin-kicker">Management</p>
                    <h1>Orders</h1>
                </div>

                <div class="admin-user">
                    <div class="admin-user-text">
                        <span class="admin-user-label">User</span>
                        <strong>Admin Account</strong>
                    </div>
                    <div class="admin-user-avatar">A</div>
                </div>
            </div>

            <!-- Toolbar -->
            <section class="admin-products-toolbar">
                <form method="get" action="<?= base_url('/admin/orders') ?>" class="admin-search-box">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search order ID or customer"
                        value="<?= esc($search ?? '') ?>"
                    />
                </form>

                <div class="admin-toolbar-actions">
                    <a href="<?= base_url('/admin/orders/export/csv') . '?search=' . urlencode($search ?? '') ?>" class="admin-primary-btn">
                        <i class="bi bi-download"></i>
                        Export CSV
                    </a>
                </div>
            </section>

            <!-- Orders Table -->
            <section class="admin-panel-card product-table-card">
                <div class="panel-header">
                    <div>
                        <h3>Order List</h3>
                        <p class="panel-subtext">Track and manage customer purchases.</p>
                    </div>

                    <span class="table-count-badge"><?= esc($orderCount ?? 0) ?> Orders</span>
                </div>

                <div class="products-table-wrapper">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (! empty($orders) && is_array($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <?php $statusClass = strtolower(str_replace(' ', '-', $order['status'] ?? '')); ?>
                                    <tr>
                                        <td><strong>#ORD-<?= esc($order['id']) ?></strong></td>
                                        <td><?= esc($order['customer']) ?></td>
                                        <td><?= esc($order['items']) ?> Item<?= (int) $order['items'] === 1 ? '' : 's' ?></td>
                                        <td>₱<?= number_format($order['total'], 2) ?></td>
                                        <td><span class="table-status <?= esc($statusClass) ?>"><?= esc($order['status']) ?></span></td>
                                        <td><?= esc(date('M d, Y', strtotime($order['date']))) ?></td>
                                        <td class="table-actions">
                                            <a href="<?= base_url('/admin/orders/view/' . $order['id']) ?>" class="table-icon-btn" title="View order">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No orders found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <p><?= esc($orderCount ?? 0) ?> orders shown</p>
                </div>
            </section>
        </main>
    </div>
</section>