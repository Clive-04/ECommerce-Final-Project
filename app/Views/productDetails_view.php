<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="product-details-page">
    <div class="container">
        <div class="product-details-card">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5">
                    <div class="product-image-panel">
                        <img src="<?= base_url('public/img/headphone1.jpg') ?>" alt="Headphone 1"
                            class="product-main-image">
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="product-content">
                        <div class="product-title-wrap">
                            <h1>Headphone 1</h1>
                            <p class="product-subtitle">Premium wireless audio for everyday listening</p>
                        </div>

                        <div class="product-rating-row">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">4.8 rating</span>
                        </div>

                        <div class="product-price-wrap">
                            <span class="product-price">₱1,299</span>
                            <span class="product-price-note">Inclusive of placeholder pricing</span>
                        </div>

                        <div class="product-summary-box">
                            <h3>Short Description</h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tempor erat elit,
                                commodo tempus turpis feugiat in. Proin sagittis magna at diam volutpat scelerisque
                                sed at justo.
                            </p>
                        </div>

                        <div class="product-meta-grid">
                            <div class="meta-card">
                                <span class="meta-label">Category</span>
                                <span class="meta-value">Headphones</span>
                            </div>

                            <div class="meta-card">
                                <span class="meta-label">Availability</span>
                                <span class="meta-value in-stock">In Stock</span>
                            </div>
                        </div>

                        <div class="quantity-row">
                            <span class="qty-label">Quantity</span>
                            <div class="qty-box">
                                <button type="button" class="qty-btn">−</button>
                                <span class="qty-value">1</span>
                                <button type="button" class="qty-btn">+</button>
                            </div>
                        </div>

                        <div class="product-actions">
                            <button class="detail-cart-btn" type="button">Add to Cart</button>
                            <button class="detail-buy-btn" type="button">Buy Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-info-area">
            <div class="info-block">
                <div class="info-heading-box">
                    <h2>Product Specifications</h2>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tempor erat elit, commodo tempus
                    turpis feugiat in. Proin sagittis magna at diam volutpat scelerisque sed at justo. Nunc lacinia
                    orci non neque interdum, non placerat purus posuere.
                </p>
            </div>

            <div class="info-block">
                <div class="info-heading-box">
                    <h2>Product Description</h2>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tempor erat elit, commodo tempus
                    turpis feugiat in. Proin sagittis magna at diam volutpat scelerisque sed at justo. Pellentesque
                    habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                </p>
            </div>
        </div>
    </div>
</section>

<?= view('include/footer') ?>