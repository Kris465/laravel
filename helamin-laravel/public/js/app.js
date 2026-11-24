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

/* --- PDF preview lightbox -----------------------------------------------
   Мини-превью -> полноэкранный просмотр. На десктопе открывается при
   наведении (с небольшой задержкой), клик «закрепляет» окно. На тач-экранах
   работает только клик. Никаких библиотек: CSP разрешает script-src 'self'.
------------------------------------------------------------------------ */
(function () {
  var box = document.getElementById('pdfLightbox');
  if (!box) return;

  var frame = document.getElementById('pdfLightboxFrame');
  var panel = document.getElementById('pdfLightboxPanel');
  var nameEl = document.getElementById('pdfLightboxName');
  var downloadLink = document.getElementById('pdfLightboxDownload');
  var closeBtn = document.getElementById('pdfLightboxClose');
  var cards = document.querySelectorAll('.pdf-card');
  var hoverTimer = null;
  var pinned = false;
  var opener = null;

  if (!frame || !panel || !closeBtn || !cards.length) return;

  function open(card, byClick) {
    var url = card.getAttribute('data-pdf-url');
    var name = card.getAttribute('data-pdf-name') || 'Документ';
    if (!url) return;

    pinned = !!byClick;
    opener = byClick ? card.querySelector('.pdf-card__preview') : null;

    nameEl.textContent = name;
    downloadLink.setAttribute('href', url);
    downloadLink.setAttribute('download', name);
    frame.src = url + '#toolbar=1&navpanes=0&scrollbar=0';
    box.hidden = false;
    document.body.classList.add('pdf-lightbox-open');
    if (pinned) closeBtn.focus();
  }

  function close() {
    pinned = false;
    box.hidden = true;
    frame.src = 'about:blank';
    document.body.classList.remove('pdf-lightbox-open');
    if (opener) { opener.focus(); opener = null; }
  }

  Array.prototype.forEach.call(cards, function (card) {
    var link = card.querySelector('.pdf-card__preview');
    if (!link) return;

    link.addEventListener('click', function (e) {
      e.preventDefault(); /* без JS ссылка просто открывает PDF */
      clearTimeout(hoverTimer);
      open(card, true);
    });

    link.addEventListener('mouseenter', function () {
      if (window.matchMedia && window.matchMedia('(hover: none)').matches) return;
      clearTimeout(hoverTimer);
      hoverTimer = setTimeout(function () { open(card, false); }, 260);
    });

    link.addEventListener('mouseleave', function () { clearTimeout(hoverTimer); });
  });

  /* Увод курсора с развёрнутого документа закрывает «незакреплённый» просмотр. */
  panel.addEventListener('mouseleave', function () {
    if (!pinned && !box.hidden) close();
  });

  box.addEventListener('click', function (e) {
    if (e.target === box && !box.hidden) close();
  });

  closeBtn.addEventListener('click', close);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !box.hidden) close();
  });
})();

