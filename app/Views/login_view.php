<?= view('include/header') ?>

<section class="auth-page-wrapper">
    <section class="auth-shell">
        <div class="auth-box">
            <div class="auth-visual">
                <img src="<?= base_url('public/img/phonebg.png') ?>" alt="VIZIO Visual" class="auth-side-image">

                <div class="auth-overlay">
                    <a href="<?= base_url('/') ?>" class="auth-logo">VIZIO</a>
                    <div class="auth-visual-text">
                        <h3>Smart accessories.</h3>
                        <p>Designed for everyday convenience.</p>
                    </div>
                </div>
            </div>

            <div class="auth-panel">
                <div class="auth-panel-header">
                    <h2>Login</h2>
                    <p>Sign in to continue to your account.</p>
                </div>

                <?php if(session()->getFlashdata('error')): ?>

<p style="color:red">
<?= session()->getFlashdata('error') ?>
</p>

<?php endif; ?>


                <form action="<?= site_url('login/auth') ?>" method="post" class="auth-form-modern">
                    <div class="modern-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email">
                    </div>

                    <div class="modern-group">
                        <label for="password">Password</label>
                        <div class="password-wrap">
                            <input type="password" id="password" name="password" placeholder="Enter your password">
                            <button type="button" class="password-toggle" data-target="password">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="modern-options">
                        <label class="modern-check">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>

                        <a href="#" class="modern-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="modern-btn">Login</button>

                    <p class="modern-switch">
                        Don’t have an account?
                        <a href="<?= site_url('register') ?>">Register here</a>
                    </p>
                </form>
            </div>
        </div>
    </section>
</section>

<script src="<?= base_url('public/js/login.js') ?>"></script>