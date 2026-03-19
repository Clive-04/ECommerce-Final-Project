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

            <!-- Toolbar -->
            <section class="admin-products-toolbar">
                <div>
                </div>

                <button class="admin-primary-btn" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="bi bi-plus-lg"></i> Add Product
                </button>
            </section>

            <!-- Table -->
            <section class="admin-panel-card product-table-card">
                <div class="products-table-wrapper">

                    <table class="products-table">

                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>

                                    <td>
                                        <?php if ($product['image']): ?>
                                            <img src="<?= base_url($product['image']) ?>" width="50">
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <strong><?= esc($product['name']) ?></strong>
                                        <p>SKU: <?= esc($product['sku']) ?></p>
                                    </td>

                                    <td><?= esc($product['category']) ?></td>
                                    <td>₱<?= number_format($product['price'], 2) ?></td>
                                    <td><?= $product['stock'] ?></td>

                                    <td>
                                        <span class="table-status"><?= esc($product['status']) ?></span>
                                    </td>

                                    <td>
                                        <button 
                                            class="table-icon-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editProductModal"
                                            onclick="editProduct(
                                                '<?= $product['id'] ?>',
                                                '<?= esc($product['name']) ?>',
                                                '<?= esc($product['sku']) ?>',
                                                '<?= esc($product['brand']) ?>',
                                                '<?= esc($product['category']) ?>',
                                                '<?= $product['price'] ?>',
                                                '<?= $product['stock'] ?>',
                                                '<?= esc($product['status']) ?>',
                                                `<?= esc($product['description']) ?>`
                                            )">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <a 
                                            href="<?= base_url('/admin/products/delete/' . $product['id']) ?>"
                                            onclick="return confirm('Delete this product?')"
                                            class="table-icon-btn danger">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </section>

        </main>
    </div>

    <!-- ADD PRODUCT MODAL -->
    <div class="modal fade" id="addProductModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content admin-modal-content">

                <div class="modal-header admin-modal-header">
                    <h5>Add Product</h5>
                </div>

                <div class="modal-body admin-modal-body">
                    <form action="<?= base_url('/admin/products/store') ?>" method="post" enctype="multipart/form-data" class="admin-product-form">

                        <div class="admin-form-grid">
                            <div class="admin-form-group">
                                <label>Product Name</label>
                                <input type="text" name="name">
                            </div>

                            <div class="admin-form-group">
                                <label>Category</label>
                                <input type="text" name="category">
                            </div>
                        </div>

                        <div class="admin-form-grid">
                            <div class="admin-form-group">
                                <label>Price</label>
                                <input type="number" name="price">
                            </div>

                            <div class="admin-form-group">
                                <label>Stock</label>
                                <input type="number" name="stock">
                            </div>
                        </div>

                        <div class="admin-form-grid">
                            <div class="admin-form-group">
                                <label>Brand</label>
                                <input type="text" name="brand">
                            </div>

                            <div class="admin-form-group">
                                <label>Status</label>
                                <select name="status">
                                    <option>In Stock</option>
                                    <option>Low Stock</option>
                                    <option>Out of Stock</option>
                                </select>
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label>Description</label>
                            <textarea name="description"></textarea>
                        </div>

                        <div class="admin-form-group">
                            <label>SKU</label>
                            <input type="text" name="sku">
                        </div>

                        <div class="admin-form-group">
                            <label>Product Image</label>
                            <input type="file" name="image">
                        </div>

                        <div class="modal-footer admin-modal-footer">
                            <button type="submit" class="admin-primary-btn">Save</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- EDIT PRODUCT MODAL -->
    <div class="modal fade" id="editProductModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content admin-modal-content">

                <div class="modal-header admin-modal-header">
                    <h5>Edit Product</h5>
                </div>

                <div class="modal-body admin-modal-body">
                    <form id="editForm" method="post" enctype="multipart/form-data" class="admin-product-form">

                        <input type="hidden" id="edit_id" name="id">

                        <div class="admin-form-grid">
                            <div class="admin-form-group">
                                <label>Product Name</label>
                                <input type="text" id="edit_name" name="name">
                            </div>

                            <div class="admin-form-group">
                                <label>Category</label>
                                <input type="text" id="edit_category" name="category">
                            </div>
                        </div>

                        <div class="admin-form-grid">
                            <div class="admin-form-group">
                                <label>Price</label>
                                <input type="number" id="edit_price" name="price">
                            </div>

                            <div class="admin-form-group">
                                <label>Stock</label>
                                <input type="number" id="edit_stock" name="stock">
                            </div>
                        </div>

                        <div class="admin-form-grid">
                            <div class="admin-form-group">
                                <label>Brand</label>
                                <input type="text" id="edit_brand" name="brand">
                            </div>

                            <div class="admin-form-group">
                                <label>Status</label>
                                <select id="edit_status" name="status">
                                    <option>In Stock</option>
                                    <option>Low Stock</option>
                                    <option>Out of Stock</option>
                                </select>
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label>Description</label>
                            <textarea id="edit_description" name="description"></textarea>
                        </div>

                        <div class="admin-form-group">
                            <label>SKU</label>
                            <input type="text" id="edit_sku" name="sku">
                        </div>

                        <div class="admin-form-group">
                            <label>Product Image</label>
                            <input type="file" name="image">
                        </div>

                        <div class="modal-footer admin-modal-footer">
                            <button type="submit" class="admin-primary-btn">Update</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

</section>

<script>
    function editProduct(id, name, sku, brand, category, price, stock, status, description) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_sku').value = sku;
        document.getElementById('edit_brand').value = brand;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_status').value = status;
        document.getElementById('edit_description').value = description;

        document.getElementById('editForm').action = "<?= base_url('/admin/products/update') ?>/" + id;
    }
</script>