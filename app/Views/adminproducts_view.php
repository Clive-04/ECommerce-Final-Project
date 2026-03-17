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

                    <a href="<?= base_url('/admin/products') ?>" class="admin-nav-link active">
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

        <!-- Main -->
        <main class="admin-main">
            <div class="admin-topbar">
                <div>
                    <p class="admin-kicker">Management</p>
                    <h1>Products</h1>
                </div>

                <div class="admin-user">
                    <div class="admin-user-text">
                        <span class="admin-user-label">User</span>
                        <strong>Admin Account</strong>
                    </div>
                    <div class="admin-user-avatar">A</div>
                </div>
            </div>

            <!-- Action Row -->
            <section class="admin-products-toolbar">
                <div class="admin-search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search products, category, or stock status">
                </div>

                <div class="admin-toolbar-actions">
                    <button class="admin-outline-btn">
                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>

                    <button class="admin-primary-btn" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="bi bi-plus-lg"></i>
                        Add Product
                    </button>
                </div>
            </section>

            <!-- Table Card -->
            <section class="admin-panel-card product-table-card">
                <div class="panel-header">
                    <div>
                        <h3>Product Inventory</h3>
                        <p class="panel-subtext">Manage your listed accessories and stock levels.</p>
                    </div>

                    <span class="table-count-badge">48 Products</span>
                </div>

                <div class="products-table-wrapper">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

<?php foreach($products as $product): ?>

<tr>

<td>
<div class="product-cell">
<div class="product-thumb"></div>

<div>
<strong><?= esc($product['name']) ?></strong>
<p>SKU: <?= esc($product['sku']) ?></p>
</div>

</div>
</td>

<td><?= esc($product['category']) ?></td>

<td>₱<?= number_format($product['price'],2) ?></td>

<td><?= $product['stock'] ?></td>

<td>

<?php
$status = $product['status'];

$class = 'in-stock';

if($status == 'Low Stock') $class = 'low-stock';
if($status == 'Out of Stock') $class = 'out-stock';
?>

<span class="table-status <?= $class ?>">
<?= esc($status) ?>
</span>

</td>

<td class="table-actions">
<button class="table-icon-btn"><i class="bi bi-pencil"></i></button>
<button class="table-icon-btn danger"><i class="bi bi-trash"></i></button>
</td>

</tr>

<?php endforeach; ?>

</tbody>

                    </table>
                </div>

                <div class="table-footer">
                    <p>Showing 1–4 of 48 products</p>

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

    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content admin-modal-content">
                <div class="modal-header admin-modal-header">
                    <div>
                        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                        <p class="admin-modal-subtext">Enter the product details below.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body admin-modal-body">
                    <form action="#" method="post" class="admin-product-form">
                        <div class="admin-form-grid">
                            <div class="admin-form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" id="product_name" name="product_name" placeholder="Enter product name">
                            </div>

                            <div class="admin-form-group">
                                <label for="category">Category</label>
                                <select id="category" name="category">
                                    <option value="">Select category</option>
                                    <option>Headphones</option>
                                    <option>Power Banks</option>
                                    <option>Phone Cases</option>
                                    <option>Earbuds</option>
                                </select>
                            </div>
                        </div>

                        <div class="admin-form-grid">
                            <div class="admin-form-group">
                                <label for="price">Price</label>
                                <input type="number" id="price" name="price" placeholder="Enter price">
                            </div>

                            <div class="admin-form-group">
                                <label for="stock">Stock</label>
                                <input type="number" id="stock" name="stock" placeholder="Enter stock quantity">
                            </div>
                        </div>

                        <div class="admin-form-grid">
                            <div class="admin-form-group">
                                <label for="brand">Brand</label>
                                <input type="text" id="brand" name="brand" placeholder="Enter brand name">
                            </div>

                            <div class="admin-form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status">
                                    <option value="">Select status</option>
                                    <option>In Stock</option>
                                    <option>Low Stock</option>
                                    <option>Out of Stock</option>
                                </select>
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4" placeholder="Enter product description"></textarea>
                        </div>

                        <div class="admin-form-grid">
                            <div class="admin-form-group">
                                <label for="product_image">Product Image</label>
                                <input type="file" id="product_image" name="product_image">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer admin-modal-footer">
                    <button type="button" class="admin-outline-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="admin-primary-btn">Save Product</button>
                </div>
            </div>
        </div>
    </div>
</section>