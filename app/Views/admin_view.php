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

        <!-- Main -->
        <main class="admin-main">

            <div class="admin-topbar">
                <div>
                    <p class="admin-kicker">Overview</p>
                    <h1>Dashboard</h1>
                </div>

                <div class="admin-user">
                    <div class="admin-user-text">
                        <span class="admin-user-label">User</span>
                        <strong><?= session()->get('user_name') ?? 'Admin' ?></strong>
                    </div>
                    <div class="admin-user-avatar">
                        <?= strtoupper(substr(session()->get('user_name') ?? 'A',0,1)) ?>
                    </div>
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
                        <h3>₱<?= number_format($revenue ?? 0) ?></h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orders">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <p class="stat-label">Total Orders</p>
                        <h3><?= $orders_count ?></h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon products">
                        <i class="bi bi-box"></i>
                    </div>
                    <div>
                        <p class="stat-label">Total Products</p>
                        <h3><?= $products_count ?></h3>
                    </div>
                </div>

            </section>

            <!-- Mid -->
            <section class="admin-grid-two">

                <!-- Recent Orders -->
                <div class="admin-panel-card tall-card">
                    <div class="panel-header">
                        <h3>Recent Orders</h3>
                        <a href="<?= base_url('/admin/orders') ?>">View all</a>
                    </div>

                    <div class="order-list">

                        <?php foreach($recent_orders as $order): ?>

                        <div class="order-item">
                            <div>
                                <strong>#<?= esc($order['order_number']) ?></strong>
                                <p><?= esc($order['customer_name']) ?></p>
                            </div>

                            <span class="status-pill">
                                <?= esc($order['status']) ?>
                            </span>
                        </div>

                        <?php endforeach; ?>

                    </div>
                </div>

                <!-- Top Products -->
                <div class="admin-panel-card tall-card">
                    <div class="panel-header">
                        <h3>Top Products</h3>
                        <a href="<?= base_url('/admin/products') ?>">Manage</a>
                    </div>

                    <div class="product-rank-list">

                        <?php $rank=1; foreach($products as $product): ?>

                        <div class="rank-item">
                            <span class="rank-number">
                                <?= str_pad($rank,2,'0',STR_PAD_LEFT) ?>
                            </span>

                            <div>
                                <strong><?= esc($product['name']) ?></strong>
                                <p>Stock: <?= $product['stock'] ?></p>
                            </div>
                        </div>

                        <?php $rank++; endforeach; ?>

                    </div>
                </div>

            </section>

        </main>
    </div>
</section>
