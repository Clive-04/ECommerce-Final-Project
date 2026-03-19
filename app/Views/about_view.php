<?= view('include/header') ?>
<?= view('include/navbar') ?>

<section class="about-page">
    <div class="container">

        <div class="about-hero">
            <span class="about-eyebrow">About VIZIO</span>
            <h1>Built for Everyday Tech, Designed with Purpose</h1>
            <p>
                VIZIO is a modern accessories shop focused on combining practical technology,
                clean design, and a smoother user experience for everyday customers.
            </p>
        </div>

        <div class="about-intro-grid">
            <div class="about-intro-card about-intro-main">
                <h2>Who We Are</h2>
                <p>
                    We are a team committed to creating a clean and modern ecommerce experience
                    for tech accessories. Our goal is to make online shopping feel organized,
                    reliable, and visually refined while keeping the experience simple for users.
                </p>
            </div>

            <div class="about-intro-card">
                <h3>Our Mission</h3>
                <p>
                    To provide a user-friendly and professional digital storefront for quality
                    accessories that support daily productivity, convenience, and style.
                </p>
            </div>

            <div class="about-intro-card">
                <h3>Our Vision</h3>
                <p>
                    To build a modern shopping experience where functionality and visual polish
                    work together seamlessly.
                </p>
            </div>
        </div>

        <div class="team-section">
            <div class="team-section-header">
                <span class="section-chip">Our Team</span>
                <h2>Meet the People Behind the Project</h2>
                <p>
                    A collaborative group working on the design, structure, and development of the VIZIO ecommerce
                    experience.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <article class="team-card">
                        <div class="team-image-wrap">
                            <img src="<?= base_url('img/member1.jpg') ?>" alt="Clive Benito" class="team-image">
                        </div>
                        <div class="team-card-body">
                            <span class="team-role">Frontend Developer</span>
                            <h3>Clive Benito</h3>
                            <p>
                                Focuses on building responsive layouts, polished interfaces, and clean user-facing
                                interactions.
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-lg-3 col-md-6">
                    <article class="team-card">
                        <div class="team-image-wrap">
                            <img src="<?= base_url('img/member2.jpg') ?>" alt="Ozbert Sales" class="team-image">
                        </div>
                        <div class="team-card-body">
                            <span class="team-role">Backend Developer</span>
                            <h3>Ozbert Sales</h3>
                            <p>
                                Works on application logic, data processing, and future dynamic system integration.
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-lg-3 col-md-6">
                    <article class="team-card">
                        <div class="team-image-wrap">
                            <img src="<?= base_url('img/member3.jpg') ?>" alt="Weinard Manianglung" class="team-image">
                        </div>
                        <div class="team-card-body">
                            <span class="team-role">UI/UX Designer</span>
                            <h3>Weinard Manianglung</h3>
                            <p>
                                Shapes the visual style, user flow, and overall design consistency of the project.
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-lg-3 col-md-6">
                    <article class="team-card">
                        <div class="team-image-wrap">
                            <img src="<?= base_url('img/member4.jpg') ?>" alt="Elmer Alcoreza" class="team-image">
                        </div>
                        <div class="team-card-body">
                            <span class="team-role">Project Manager</span>
                            <h3>Elmer Alcoreza</h3>
                            <p>
                                Oversees project direction, coordination, and ensures the final output stays aligned.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </div>

    </div>
</section>

<?= view('include/footer') ?>