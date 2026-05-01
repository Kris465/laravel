/* HELAMIN — Minimal JS */
(function () {
  var burger = document.getElementById('burgerBtn');
  var nav = document.getElementById('mainNav');
  var mainNav = document.querySelector('.main-nav');

  /* --- Burger toggle --- */
  if (burger && nav) {
    function closeNav() {
      nav.classList.remove('open');
      burger.classList.remove('active');
      burger.setAttribute('aria-expanded', 'false');
    }

    function toggleNav() {
      var isOpen = nav.classList.contains('open');
      nav.classList.toggle('open');
      burger.classList.toggle('active');
      burger.setAttribute('aria-expanded', String(!isOpen));
    }

    burger.addEventListener('click', toggleNav);

    // Закрытие по Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('open')) {
        closeNav();
        burger.focus();
      }
    });

    // Закрытие при клике вне навигации
    document.addEventListener('click', function (e) {
      if (nav.classList.contains('open') && !nav.contains(e.target) && !burger.contains(e.target)) {
        closeNav();
      }
    });
  }

  /* --- Auto-hide nav on scroll down (mobile only) --- */
  if (!mainNav) return;

  var lastScroll = 0;
  var ticking = false;
  var navHeight = 0;

  function onScroll() {
    var currentScroll = window.pageYOffset || document.documentElement.scrollTop;
    navHeight = mainNav.offsetHeight;

    // Only hide when scrolled past the nav itself
    if (currentScroll > navHeight) {
      if (currentScroll > lastScroll) {
        // Scrolling down — hide nav
        mainNav.classList.add('main-nav--hidden');
      } else {
        // Scrolling up — show nav
        mainNav.classList.remove('main-nav--hidden');
      }
    } else {
      // At the top — always visible
      mainNav.classList.remove('main-nav--hidden');
    }

    lastScroll = currentScroll <= 0 ? 0 : currentScroll;
    ticking = false;
  }

  window.addEventListener('scroll', function () {
    if (!ticking) {
      requestAnimationFrame(onScroll);
      ticking = true;
    }
  }, { passive: true });

  // Also close mobile nav if user scrolls
  window.addEventListener('scroll', function () {
    if (nav && nav.classList.contains('open')) {
      var isOpen = nav.classList.contains('open');
      if (isOpen) {
        nav.classList.remove('open');
        if (burger) {
          burger.classList.remove('active');
          burger.setAttribute('aria-expanded', 'false');
        }
      }
    }
  }, { passive: true });
})();
