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
                <a href="#" class="admin-nav-link logout-link">
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

                <div class="admin-user">
                    <div class="admin-user-text">
                        <span class="admin-user-label">User</span>
                        <strong>Admin Account</strong>
                    </div>
                    <div class="admin-user-avatar">A</div>
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
                        <h3>₱125,430</h3>
                        <span class="stat-sub">+12.4% this month</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orders">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <p class="stat-label">Total Orders</p>
                        <h3>324</h3>
                        <span class="stat-sub">18 pending orders</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon products">
                        <i class="bi bi-box"></i>
                    </div>
                    <div>
                        <p class="stat-label">Total Products</p>
                        <h3>48</h3>
                        <span class="stat-sub">6 low stock items</span>
                    </div>
                </div>
            </section>

            <!-- Mid Content -->
            <section class="admin-grid-two">
                <div class="admin-panel-card tall-card">
                    <div class="panel-header">
                        <h3>Recent Orders</h3>
                        <a href="#">View all</a>
                    </div>

                    <div class="order-list">
                        <div class="order-item">
                            <div>
                                <strong>#ORD-1001</strong>
                                <p>Wireless Earbuds Pro</p>
                            </div>
                            <span class="status-pill shipped">Shipped</span>
                        </div>

                        <div class="order-item">
                            <div>
                                <strong>#ORD-1002</strong>
                                <p>Portable Charger 20,000mAh</p>
                            </div>
                            <span class="status-pill pending">Pending</span>
                        </div>

                        <div class="order-item">
                            <div>
                                <strong>#ORD-1003</strong>
                                <p>Gaming Mouse RGB</p>
                            </div>
                            <span class="status-pill delivered">Delivered</span>
                        </div>

                        <div class="order-item">
                            <div>
                                <strong>#ORD-1004</strong>
                                <p>Bluetooth Speaker Mini</p>
                            </div>
                            <span class="status-pill processing">Processing</span>
                        </div>
                    </div>
                </div>

                <div class="admin-panel-card tall-card">
                    <div class="panel-header">
                        <h3>Top Products</h3>
                        <a href="#">Manage</a>
                    </div>

                    <div class="product-rank-list">
                        <div class="rank-item">
                            <span class="rank-number">01</span>
                            <div>
                                <strong>Wireless Earbuds Pro</strong>
                                <p>124 units sold</p>
                            </div>
                        </div>

                        <div class="rank-item">
                            <span class="rank-number">02</span>
                            <div>
                                <strong>Power Bank Max</strong>
                                <p>98 units sold</p>
                            </div>
                        </div>

                        <div class="rank-item">
                            <span class="rank-number">03</span>
                            <div>
                                <strong>USB-C Fast Charger</strong>
                                <p>87 units sold</p>
                            </div>
                        </div>

                        <div class="rank-item">
                            <span class="rank-number">04</span>
                            <div>
                                <strong>Mechanical Keyboard Lite</strong>
                                <p>75 units sold</p>
                            </div>
                        </div>
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
                            <div class="bar" style="height: 48%;"></div>
                            <div class="bar" style="height: 68%;"></div>
                            <div class="bar" style="height: 55%;"></div>
                            <div class="bar" style="height: 82%;"></div>
                            <div class="bar" style="height: 74%;"></div>
                            <div class="bar" style="height: 92%;"></div>
                            <div class="bar" style="height: 64%;"></div>
                        </div>
                        <div class="sales-labels">
                            <span>Mon</span>
                            <span>Tue</span>
                            <span>Wed</span>
                            <span>Thu</span>
                            <span>Fri</span>
                            <span>Sat</span>
                            <span>Sun</span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</section>