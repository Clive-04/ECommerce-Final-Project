document.addEventListener("DOMContentLoaded", function () {
  const priceFilter = document.getElementById("priceFilter");
  const toggleBtn = document.getElementById("priceFilterToggle");
  const options = document.querySelectorAll("#priceFilter .price-option");

  if (!priceFilter || !toggleBtn) return;

  toggleBtn.addEventListener("click", function (event) {
    event.preventDefault();
    event.stopPropagation();
    priceFilter.classList.toggle("open");
  });

  options.forEach(function (option) {
    option.addEventListener("click", function () {
      options.forEach(function (item) {
        item.classList.remove("active");
      });

      this.classList.add("active");
      priceFilter.classList.remove("open");
    });
  });

  document.addEventListener("click", function (event) {
    if (!priceFilter.contains(event.target)) {
      priceFilter.classList.remove("open");
    }
  });
});
