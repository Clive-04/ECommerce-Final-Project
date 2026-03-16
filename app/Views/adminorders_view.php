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
                <div class="admin-search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search order ID, customer, or status">
                </div>

                <div class="admin-toolbar-actions">
                    <button class="admin-outline-btn">
                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>

                    <button class="admin-primary-btn">
                        <i class="bi bi-download"></i>
                        Export
                    </button>
                </div>
            </section>

            <!-- Orders Table -->
            <section class="admin-panel-card product-table-card">
                <div class="panel-header">
                    <div>
                        <h3>Order List</h3>
                        <p class="panel-subtext">Track and manage customer purchases.</p>
                    </div>

                    <span class="table-count-badge">324 Orders</span>
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
                            <tr>
                                <td><strong>#ORD-1001</strong></td>
                                <td>Clive Benito</td>
                                <td>3 Items</td>
                                <td>₱4,299</td>
                                <td><span class="table-status in-stock">Delivered</span></td>
                                <td>Mar 14, 2026</td>
                                <td class="table-actions">
                                    <button class="table-icon-btn"><i class="bi bi-eye"></i></button>
                                    <button class="table-icon-btn"><i class="bi bi-pencil"></i></button>
                                    <button class="table-icon-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>#ORD-1002</strong></td>
                                <td>Emer Alcoreza</td>
                                <td>1 Item</td>
                                <td>₱1,899</td>
                                <td><span class="table-status low-stock">Pending</span></td>
                                <td>Mar 13, 2026</td>
                                <td class="table-actions">
                                    <button class="table-icon-btn"><i class="bi bi-eye"></i></button>
                                    <button class="table-icon-btn"><i class="bi bi-pencil"></i></button>
                                    <button class="table-icon-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>#ORD-1003</strong></td>
                                <td>Ozbert Sales</td>
                                <td>2 Items</td>
                                <td>₱2,750</td>
                                <td><span class="status-pill shipped">Shipped</span></td>
                                <td>Mar 12, 2026</td>
                                <td class="table-actions">
                                    <button class="table-icon-btn"><i class="bi bi-eye"></i></button>
                                    <button class="table-icon-btn"><i class="bi bi-pencil"></i></button>
                                    <button class="table-icon-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>#ORD-1004</strong></td>
                                <td>Weinard Manianglung</td>
                                <td>4 Items</td>
                                <td>₱5,180</td>
                                <td><span class="status-pill processing">Processing</span></td>
                                <td>Mar 11, 2026</td>
                                <td class="table-actions">
                                    <button class="table-icon-btn"><i class="bi bi-eye"></i></button>
                                    <button class="table-icon-btn"><i class="bi bi-pencil"></i></button>
                                    <button class="table-icon-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>#ORD-1005</strong></td>
                                <td>Juan Dela Cruz</td>
                                <td>1 Item</td>
                                <td>₱999</td>
                                <td><span class="table-status out-stock">Cancelled</span></td>
                                <td>Mar 10, 2026</td>
                                <td class="table-actions">
                                    <button class="table-icon-btn"><i class="bi bi-eye"></i></button>
                                    <button class="table-icon-btn"><i class="bi bi-pencil"></i></button>
                                    <button class="table-icon-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <p>Showing 1–5 of 324 orders</p>

                    <div class="pagination-wrap">
                        <button class="pagination-btn">Previous</button>
                        <button class="pagination-btn active">1</button>
                        <button class="pagination-btn">2</button>
                        <button class="pagination-btn">3</button>
                        <button class="pagination-btn">Next</button>
                    </div>
                </div>
            </section>
        </main>
    </div>
</section>