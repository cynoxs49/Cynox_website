const dropdowns = document.querySelectorAll(".group");

dropdowns.forEach((dropdown) => {
  const dropdownMenu = dropdown.querySelector(".dropdown-menu");

  // Initially hide the dropdown
  dropdownMenu.classList.add("opacity-0", "invisible");

  // Show the dropdown when the parent is hovered
  dropdown.addEventListener("mouseenter", () => {
    dropdownMenu.classList.remove("opacity-0", "invisible");
    dropdownMenu.classList.add("opacity-100", "visible");
  });

  // Hide the dropdown when the parent is not hovered
  dropdown.addEventListener("mouseleave", () => {
    dropdownMenu.classList.remove("opacity-100", "visible");
    dropdownMenu.classList.add("opacity-0", "invisible");
  });
});

const toggleBtn = document.getElementById("menu-toggle");
const mobileMenu = document.getElementById("mobile-menu");

toggleBtn.addEventListener("click", () => {
  mobileMenu.classList.toggle("hidden");
});

// BANNER SECTION
