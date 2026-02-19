document.addEventListener('DOMContentLoaded', function () {
  const hamburgerBtn = document.querySelector('.mobile-header .hamburger-btn');
  const mobileNav = document.querySelector('.mobile-header nav');

  hamburgerBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    if (mobileNav.clientHeight === 0) {
      mobileNav.style.height = mobileNav.scrollHeight + 'px';
    } else {
      mobileNav.style.height = '0';
    }
  });

  mobileNav.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      mobileNav.style.height = '0';
    });
  });

  document.addEventListener('click', function (e) {
    const mobileHeader = document.querySelector('.mobile-header');
    if (!mobileHeader.contains(e.target)) {
      mobileNav.style.height = '0';
    }
  });
});
