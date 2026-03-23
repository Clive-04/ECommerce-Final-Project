<?= view('include/header') ?>

<section class="auth-page-wrapper">
    <section class="auth-shell">
        <div class="auth-box register-box">
            <div class="auth-panel">
                <div class="auth-panel-header">
                    <h2>Register</h2>
                    <p>Create your account to get started.</p>
                </div>

                <?php if(session()->getFlashdata('success')): ?>

<p style="color:green">
<?= session()->getFlashdata('success') ?>
</p>

<?php endif; ?>


                <form action="<?= site_url('register/save') ?>" method="post" class="auth-form-modern">
                    <div class="modern-row">
                        <div class="modern-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="Enter your first name">
                        </div>

                        <div class="modern-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Enter your last name">
                        </div>
                    </div>

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

                    <div class="modern-group">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="password-wrap">
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password">
                            <button type="button" class="password-toggle" data-target="confirm_password">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="modern-btn">Create Account</button>

                    <p class="modern-switch">
                        Already have an account?
                        <a href="<?= site_url('login') ?>">Login here</a>
                    </p>
                </form>
            </div>

            <div class="auth-visual register-visual">
                <img src="<?= base_url('public/img/registerbg.avif') ?>" alt="VIZIO Visual" class="auth-side-image">

                <div class="auth-overlay">
                    <a href="<?= base_url('/') ?>" class="auth-logo">VIZIO</a>
                    <div class="auth-visual-text">
                        <h3>Join VIZIO.</h3>
                        <p>Create your account and explore smart accessories with ease.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<script src="<?= base_url('public/js/login.js') ?>"></script>
</body>
</html>