document.addEventListener("DOMContentLoaded", function () {
  const heroText = document.querySelector(".hero-overlay");
  const tagline = document.querySelector(".tagline");
  const techBanner = document.querySelector(".tech-banner");
  const productCards = document.querySelectorAll(".product-card");

  if (heroText) {
    heroText.classList.add("animate-in");
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("show");
        }
      });
    },
    {
      threshold: 0.18,
    },
  );

  if (tagline) observer.observe(tagline);
  if (techBanner) observer.observe(techBanner);

  productCards.forEach((card, index) => {
    card.style.transitionDelay = `${index * 120}ms`;
    observer.observe(card);
  });

  const hero = document.querySelector(".hero");
  window.addEventListener("mousemove", function (e) {
    if (!hero) return;

    const x = (e.clientX / window.innerWidth - 0.5) * 12;
    const y = (e.clientY / window.innerHeight - 0.5) * 12;

    hero.style.backgroundPosition = `${50 + x * 0.25}% ${50 + y * 0.25}%`;
  });
});
