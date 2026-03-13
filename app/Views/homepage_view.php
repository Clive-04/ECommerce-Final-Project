<?= view('include/header') ?>

<?= view('include/navbar') ?>


<!-- HERO SECTION -->

<section class="hero">

    <div class="hero-overlay text-center">

        <h2>Welcome to</h2>
        <h1>VIZIO</h1>

    </div>

</section>



<!-- TAGLINE -->

<section class="tagline">

    <h3>Smart accessories. Better everyday use.</h3>

    <p>
        Shop quality items made to support your daily tech needs.
        Discover reliable accessories designed to enhance performance,
        convenience, and everyday use of your devices.
    </p>

</section>



<!-- TECHNOLOGY BANNER -->

<section class="tech-banner">

    <h3>Where Function Meets Everyday Technology</h3>

</section>



<!-- FEATURED PRODUCTS -->

<section class="products container">

    <h4 class="mb-4">Featured Products</h4>

    <div class="row g-4">


        <!-- PRODUCT 1 -->

        <div class="col-md-3">

            <div class="card product-card">

                <img src="<?= base_url('public/img/product1.jpg') ?>" class="card-img-top product-image">

            </div>

        </div>


        <!-- PRODUCT 2 -->

        <div class="col-md-3">

            <div class="card product-card">

                <img src="<?= base_url('public/img/product2.jpeg') ?>" class="card-img-top product-image">

            </div>

        </div>


        <!-- PRODUCT 3 -->

        <div class="col-md-3">

            <div class="card product-card">

                <img src="<?= base_url('public/img/product3.jpg') ?>" class="card-img-top product-image">

            </div>

        </div>


        <!-- PRODUCT 4 -->

        <div class="col-md-3">

            <div class="card product-card">

                <img src="<?= base_url('public/img/product4.jpg') ?>" class="card-img-top product-image">

            </div>

        </div>


    </div>

</section>


<?= view('include/footer') ?>