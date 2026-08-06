/* ============================================
   Handball Hub - Frontend JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {
  // Mobile Menu Toggle
  const mobileToggle = document.querySelector('.mobile-toggle');
  const navbarNav = document.querySelector('.navbar-nav');

  if (mobileToggle && navbarNav) {
    mobileToggle.addEventListener('click', function () {
      navbarNav.classList.toggle('open');
      mobileToggle.classList.toggle('active');
    });
  }

  // Active Nav Link Highlight
  const currentPage = window.location.pathname;
  const navLinks = document.querySelectorAll('.navbar-nav a');
  navLinks.forEach(function (link) {
    const href = link.getAttribute('href');
    if (href === currentPage || (href !== '/' && currentPage.startsWith(href))) {
      link.classList.add('active');
    }
  });
});
