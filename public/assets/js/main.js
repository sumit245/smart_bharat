(function () {
  'use strict';

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ---- Sticky header shrink ----
  const header = document.querySelector('.site-header');
  const updateScrollProgress = () => {
    const max = Math.max(1, document.documentElement.scrollHeight - window.innerHeight);
    document.documentElement.style.setProperty('--scroll-progress', Math.min(1, window.scrollY / max).toFixed(4));
  };
  if (header) {
    let ticking = false;
    const onScroll = () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          header.classList.toggle('is-scrolled', window.scrollY > 24);
          updateScrollProgress();
          ticking = false;
        });
        ticking = true;
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  } else {
    updateScrollProgress();
    window.addEventListener('scroll', updateScrollProgress, { passive: true });
  }

  // ---- Mobile drawer ----
  const toggle = document.querySelector('.nav-toggle');
  const drawer = document.querySelector('.nav-drawer');
  if (toggle && drawer) {
    const close = () => {
      toggle.setAttribute('aria-expanded', 'false');
      drawer.classList.remove('is-open');
      document.body.style.overflow = '';
    };
    const open = () => {
      toggle.setAttribute('aria-expanded', 'true');
      drawer.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    };
    toggle.addEventListener('click', () => {
      toggle.getAttribute('aria-expanded') === 'true' ? close() : open();
    });
    const drawerClose = drawer.querySelector('.nav-drawer__close');
    if (drawerClose) drawerClose.addEventListener('click', close);
    drawer.querySelectorAll('a').forEach(a => a.addEventListener('click', close));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
    window.addEventListener('resize', () => {
      if (window.matchMedia('(min-width: 1320px)').matches) close();
    });
  }

  // ---- Reveal on scroll ----
  const revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && !reduceMotion) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(en => {
        if (en.isIntersecting) {
          en.target.classList.add('is-visible');
          io.unobserve(en.target);
        }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    revealEls.forEach(el => io.observe(el));
  } else {
    revealEls.forEach(el => el.classList.add('is-visible'));
  }

  // ---- FAQ accordions: keep one item open per FAQ list ----
  document.querySelectorAll('.faq-list').forEach(list => {
    const items = Array.from(list.querySelectorAll(':scope > .faq-item'));
    items.forEach(item => {
      const summary = item.querySelector('summary');
      if (summary) {
        summary.addEventListener('click', () => {
          if (item.open) return;
          items.forEach(other => {
            if (other !== item) other.open = false;
          });
        });
      }
      item.addEventListener('toggle', () => {
        if (!item.open) return;
        items.forEach(other => {
          if (other !== item) other.open = false;
        });
      });
    });
  });

  // ---- Section-to-section motion ----
  const motionSections = document.querySelectorAll('main > section');
  motionSections.forEach((section, index) => {
    section.classList.add('motion-section');
    section.style.setProperty('--section-index', index);
  });
  if (motionSections.length) {
    if ('IntersectionObserver' in window && !reduceMotion) {
      const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-section-visible');
            sectionObserver.unobserve(entry.target);
          }
        });
      }, { rootMargin: '0px 0px -5% 0px', threshold: 0.05 });
      motionSections.forEach(section => sectionObserver.observe(section));
    } else {
      motionSections.forEach(section => section.classList.add('is-section-visible'));
    }
  }

  // ---- Hero presence follows pointer ----
  const hero = document.querySelector('.hero');
  if (hero && !reduceMotion) {
    const updateHeroMotion = (event) => {
      const rect = hero.getBoundingClientRect();
      const x = ((event.clientX - rect.left) / rect.width - 0.5).toFixed(3);
      const y = ((event.clientY - rect.top) / rect.height - 0.5).toFixed(3);
      hero.style.setProperty('--hero-x', x);
      hero.style.setProperty('--hero-y', y);
    };
    hero.addEventListener('pointermove', updateHeroMotion, { passive: true });
    hero.addEventListener('pointerleave', () => {
      hero.style.setProperty('--hero-x', '0');
      hero.style.setProperty('--hero-y', '0');
    });
  }

  // ---- Counters ----
  const counters = document.querySelectorAll('[data-count]');
  if (counters.length) {
    const fmt = new Intl.NumberFormat('en-IN');
    const ease = t => 1 - Math.pow(1 - t, 3);
    const run = (el) => {
      const target = Number(el.dataset.count);
      const suffix = el.dataset.suffix || '';
      const dur = reduceMotion ? 0 : 1600;
      const start = performance.now();
      const tick = (now) => {
        const p = Math.min(1, (now - start) / Math.max(1, dur));
        const v = Math.round(target * ease(p));
        el.textContent = fmt.format(v) + suffix;
        if (p < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    };
    if ('IntersectionObserver' in window) {
      const io2 = new IntersectionObserver((entries) => {
        entries.forEach(en => {
          if (en.isIntersecting) {
            run(en.target);
            io2.unobserve(en.target);
          }
        });
      }, { threshold: 0.3 });
      counters.forEach(c => io2.observe(c));
    } else {
      counters.forEach(run);
    }
  }

  // ---- Directory filter ----
  const dirSearch = document.getElementById('dir-search');
  const dirLang = document.getElementById('dir-lang');
  const dirType = document.getElementById('dir-type');
  const dirItems = document.querySelectorAll('.dir-card');
  if (dirItems.length && (dirSearch || dirLang || dirType)) {
    const apply = () => {
      const q = (dirSearch?.value || '').toLowerCase().trim();
      const lang = dirLang?.value || '';
      const type = dirType?.value || '';
      dirItems.forEach(it => {
        const name = it.dataset.name?.toLowerCase() || '';
        const il = it.dataset.lang || '';
        const ity = it.dataset.type || '';
        const hit = (!q || name.includes(q)) && (!lang || il === lang) && (!type || ity === type);
        it.style.display = hit ? '' : 'none';
      });
    };
    [dirSearch, dirLang, dirType].forEach(el => el && el.addEventListener('input', apply));
  }

  // ---- Account page tabs and adaptive fields ----
  const accountTabs = document.querySelectorAll('[data-account-tab]');
  const accountPanels = document.querySelectorAll('[data-account-panel]');
  if (accountTabs.length && accountPanels.length) {
    const setAccountTab = (name) => {
      accountTabs.forEach(tab => {
        const active = tab.dataset.accountTab === name;
        tab.classList.toggle('is-active', active);
        tab.setAttribute('aria-selected', active ? 'true' : 'false');
      });
      accountPanels.forEach(panel => {
        panel.classList.toggle('is-active', panel.dataset.accountPanel === name);
      });
    };
    accountTabs.forEach(tab => tab.addEventListener('click', () => setAccountTab(tab.dataset.accountTab)));
  }

  const modeSelect = document.querySelector('[data-account-mode]');
  const modePanels = document.querySelectorAll('[data-account-mode-panel]');
  if (modeSelect && modePanels.length) {
    const updateModePanels = () => {
      const mode = modeSelect.value;
      modePanels.forEach(panel => {
        const modes = (panel.dataset.accountModePanel || '').split(/\s+/);
        const hidden = !modes.includes(mode);
        panel.hidden = hidden;
        panel.querySelectorAll('input, select, textarea').forEach(field => {
          field.disabled = hidden;
        });
      });
    };
    modeSelect.addEventListener('change', updateModePanels);
    updateModePanels();
  }

  const passwordInput = document.querySelector('[data-password-meter]');
  const passwordHint = document.querySelector('[data-password-hint]');
  if (passwordInput && passwordHint) {
    const updatePasswordHint = () => {
      const value = passwordInput.value;
      const strongEnough = value.length >= 10 && /[a-z]/.test(value) && /[A-Z]/.test(value) && /\d/.test(value);
      passwordHint.classList.toggle('is-ok', strongEnough);
      passwordHint.textContent = strongEnough
        ? 'Password strength looks acceptable.'
        : 'Password must include lowercase, uppercase, a number, and minimum 10 characters.';
    };
    passwordInput.addEventListener('input', updatePasswordHint);
    updatePasswordHint();
  }

  // ---- 5th Anniversary Popup ----
  const annivPopup = document.getElementById('anniv-popup');
  if (annivPopup && !sessionStorage.getItem('anniv5_seen')) {
    setTimeout(() => {
      annivPopup.hidden = false;
      requestAnimationFrame(() => annivPopup.classList.add('is-open'));
    }, 600);
    const closeAnniv = () => {
      annivPopup.classList.remove('is-open');
      sessionStorage.setItem('anniv5_seen', '1');
      setTimeout(() => { annivPopup.hidden = true; }, 500);
    };
    document.getElementById('anniv-close')?.addEventListener('click', closeAnniv);
    document.getElementById('anniv-skip')?.addEventListener('click', closeAnniv);
    annivPopup.querySelector('.anniv-backdrop')?.addEventListener('click', closeAnniv);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeAnniv(); });
  }
})();
