/**
 * Handball Competition Management System
 * Premium Animation & Interaction Engine
 * Built on top of SB Admin 2
 */

document.addEventListener('DOMContentLoaded', function () {
  initSidebarToggle();
  initTableSearch();
  initTableFilters();
  initLiveScoreCounters();
  initStaggeredEntrance();
  initCountUpNumbers();
  initNavActiveHighlight();
  initScrollReveal();
  initParallaxCards();
  initQuickPulseUpdates();
  initLiveMatchTimers();
});

// ═══════════════════════════════════════
// 1. STAGGERED CARD ENTRANCE ANIMATION
// ═══════════════════════════════════════

function initStaggeredEntrance() {
  const cards = document.querySelectorAll('.card');
  cards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    setTimeout(() => {
      card.style.transition = 'opacity 0.5s cubic-bezier(0.22, 1, 0.36, 1), transform 0.5s cubic-bezier(0.22, 1, 0.36, 1)';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, 60 + index * 70);
  });
}

// ═══════════════════════════════════════
// 2. COUNT-UP NUMBER ANIMATION
// ═══════════════════════════════════════

function initCountUpNumbers() {
  const counters = document.querySelectorAll('.h5.font-weight-bold, .live-score-text, .live-score-big, .live-timer-big');
  counters.forEach(el => {
    const rawText = el.textContent.trim();
    const target = parseInt(rawText, 10);

    // Only animate whole numbers
    if (isNaN(target) || target <= 0 || target > 9999) return;
    // Skip if text has non-numeric chars other than leading/trailing whitespace
    if (rawText.replace(/[\s,]/g, '') !== target.toString()) return;

    const duration = Math.min(1200, target * 20 + 200);
    const start = performance.now();
    el.textContent = '0';

    function update(now) {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      // Ease-out cubic
      const eased = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.floor(eased * target);
      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        el.textContent = target;
        // Flash effect on completion
        el.style.transition = 'transform 0.2s ease, color 0.2s ease';
        el.style.transform = 'scale(1.12)';
        setTimeout(() => {
          el.style.transform = 'scale(1)';
        }, 200);
      }
    }
    requestAnimationFrame(update);
  });
}

// ═══════════════════════════════════════
// 3. ACTIVE SIDEBAR NAV HIGHLIGHT
// ═══════════════════════════════════════

function initNavActiveHighlight() {
  // Server-side Laravel Blade handles route highlighting accurately via request()->routeIs()
}

// ═══════════════════════════════════════
// 4. SCROLL REVEAL FOR DEEPER SECTIONS
// ═══════════════════════════════════════

function initScrollReveal() {
  const revealEls = document.querySelectorAll('.card, .table, .chart-area, .chart-bar, .chart-pie');
  if (!('IntersectionObserver' in window)) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.transition = 'opacity 0.6s ease, transform 0.6s cubic-bezier(0.22, 1, 0.36, 1)';
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  revealEls.forEach(el => {
    if (el.getBoundingClientRect().top > window.innerHeight) {
      el.style.opacity = '0';
      el.style.transform = 'translateY(15px)';
      observer.observe(el);
    }
  });
}

// ═══════════════════════════════════════
// 5. PARALLAX TILT ON KPI CARDS
// ═══════════════════════════════════════

function initParallaxCards() {
  const kpiCards = document.querySelectorAll('.card[class*="border-left-"]');
  kpiCards.forEach(card => {
    card.addEventListener('mousemove', e => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const rotateX = (y - centerY) / centerY * -4;
      const rotateY = (x - centerX) / centerX * 4;
      card.style.transform = `perspective(600px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-3px)`;
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(600px) rotateX(0deg) rotateY(0deg) translateY(0)';
      card.style.transition = 'transform 0.4s ease';
    });
  });
}

// ═══════════════════════════════════════
// 6. QUICK PULSE UPDATES (live feel)
// ═══════════════════════════════════════

function initQuickPulseUpdates() {
  // Pulse the live badge every 3 seconds
  const liveBadges = document.querySelectorAll('.badge-danger.animate-pulse, .badge.animate-pulse');
  if (liveBadges.length) {
    setInterval(() => {
      liveBadges.forEach(badge => {
        badge.style.transition = 'transform 0.2s ease';
        badge.style.transform = 'scale(1.15)';
        setTimeout(() => { badge.style.transform = 'scale(1)'; }, 200);
      });
    }, 3000);
  }

  // Pulse live score text periodically
  const liveScores = document.querySelectorAll('.live-score-text');
  if (liveScores.length) {
    setInterval(() => {
      liveScores.forEach(s => {
        s.style.transition = 'color 0.3s ease';
        s.style.color = '#e74a3b';
        setTimeout(() => { s.style.color = ''; }, 500);
      });
    }, 5000);
  }
}

// ═══════════════════════════════════════
// 7. LIVE MATCH TIMER UPDATES
// ═══════════════════════════════════════

function initLiveMatchTimers() {
  const timerElements = document.querySelectorAll('[data-match-timer]');

  if (!timerElements.length) {
    return;
  }

  const updateTimers = function () {
    timerElements.forEach(function (el) {
      const startTimeStr = el.getAttribute('data-match-timer');

      if (!startTimeStr) {
        return;
      }

      const startTime = new Date(startTimeStr);
      const now = new Date();
      const diffSeconds = Math.max(0, Math.floor((now - startTime) / 1000));

      const mins = String(Math.floor(diffSeconds / 60)).padStart(2, '0');
      const secs = String(diffSeconds % 60).padStart(2, '0');

      el.textContent = mins + ':' + secs;
    });
  };

  updateTimers();
  setInterval(updateTimers, 1000);
}

// ═══════════════════════════════════════
// 8. TOAST NOTIFICATION HELPER
// ═══════════════════════════════════════

function showHandballToast(title, message, type = 'success') {
  let container = document.getElementById('handballToastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'handballToastContainer';
    document.body.appendChild(container);
  }

  const bgStyle = type === 'success'
    ? 'background: #10b981;'
    : type === 'warning'
      ? 'background: #f59e0b;'
      : type === 'danger'
        ? 'background: #ef4444;'
        : 'background: #ea580c;';

  const icon = type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : type === 'danger' ? 'fa-times-circle' : 'fa-info-circle';

  const toastId = 'toast-' + Date.now();
  const toastHtml = `
    <div id="${toastId}" class="handball-toast text-white" style="${bgStyle}">
      <div class="handball-toast-header">
        <div class="d-flex align-items-center">
          <i class="fas ${icon} mr-2"></i>
          <span>${title}</span>
        </div>
        <button type="button" class="close text-white border-0 bg-transparent p-0" onclick="document.getElementById('${toastId}')?.remove()" style="font-size: 1.1rem; line-height: 1; opacity: 0.8;" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="handball-toast-body">
        ${message}
      </div>
      <div id="${toastId}-bar" class="handball-toast-progress"></div>
    </div>
  `;

  container.insertAdjacentHTML('beforeend', toastHtml);

  // Progress bar animation
  requestAnimationFrame(() => {
    const bar = document.getElementById(`${toastId}-bar`);
    if (bar) bar.style.width = '0%';
  });

  setTimeout(() => {
    const el = document.getElementById(toastId);
    if (el) {
      el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
      setTimeout(() => el.remove(), 300);
    }
  }, 3500);
}

// ═══════════════════════════════════════
// 8. TABLE SEARCH FILTER
// ═══════════════════════════════════════

function initTableSearch() {
  const searchInputs = document.querySelectorAll('[data-handball-search]');
  searchInputs.forEach(input => {
    const targetTableId = input.getAttribute('data-handball-search');
    const table = document.getElementById(targetTableId);
    if (!table) return;

    input.addEventListener('keyup', function () {
      const query = input.value.toLowerCase().trim();
      const rows = table.querySelectorAll('tbody tr');
      let matchCount = 0;

      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(query)) {
          row.style.display = '';
          row.style.animation = 'slide-in-up 0.25s ease both';
          matchCount++;
        } else {
          row.style.display = 'none';
        }
      });

      // Show count badge if results filtered
      let countBadge = input.parentElement.querySelector('.search-count');
      if (query && matchCount < rows.length) {
        if (!countBadge) {
          countBadge = document.createElement('small');
          countBadge.className = 'search-count text-muted ml-2';
          countBadge.style.cssText = 'position:absolute;right:40px;top:50%;transform:translateY(-50%);font-size:0.7rem;';
          input.parentElement.style.position = 'relative';
          input.parentElement.appendChild(countBadge);
        }
        countBadge.textContent = matchCount + ' result' + (matchCount !== 1 ? 's' : '');
      } else if (countBadge) {
        countBadge.remove();
      }
    });
  });
}

// ═══════════════════════════════════════
// 9. TABLE COLUMN FILTER
// ═══════════════════════════════════════

function initTableFilters() {
  const filterSelects = document.querySelectorAll('[data-handball-filter]');
  filterSelects.forEach(select => {
    const targetTableId = select.getAttribute('data-handball-table');
    const colIndex = parseInt(select.getAttribute('data-handball-filter'), 10);
    const table = document.getElementById(targetTableId);
    if (!table) return;

    select.addEventListener('change', function () {
      const filterVal = select.value.toLowerCase().trim();
      const rows = table.querySelectorAll('tbody tr');

      rows.forEach((row, i) => {
        const cells = row.querySelectorAll('td');
        if (cells.length > colIndex) {
          const cellText = cells[colIndex].textContent.toLowerCase().trim();
          if (!filterVal || filterVal === 'all' || cellText.includes(filterVal)) {
            row.style.display = '';
            row.style.animation = `slide-in-up 0.3s cubic-bezier(0.22,1,0.36,1) ${i * 30}ms both`;
          } else {
            row.style.display = 'none';
          }
        }
      });
    });
  });
}

// ═══════════════════════════════════════
// 10. LIVE SCORE INCREMENTER + ANIMATION
// ═══════════════════════════════════════

function initLiveScoreCounters() {
  document.addEventListener('click', function (e) {
    if (e.target.matches('[data-score-btn]') || e.target.closest('[data-score-btn]')) {
      const btn = e.target.matches('[data-score-btn]') ? e.target : e.target.closest('[data-score-btn]');
      const targetId = btn.getAttribute('data-score-btn');
      const action = btn.getAttribute('data-action');
      const scoreEl = document.getElementById(targetId);

      if (scoreEl) {
        let currentScore = parseInt(scoreEl.textContent, 10) || 0;
        if (action === 'plus') {
          currentScore++;
        } else if (action === 'minus' && currentScore > 0) {
          currentScore--;
        }
        scoreEl.textContent = currentScore;

        // Score flash animation
        scoreEl.style.transition = 'transform 0.15s ease, color 0.15s ease';
        scoreEl.style.transform = 'scale(1.3)';
        scoreEl.style.color = action === 'plus' ? '#1cc88a' : '#e74a3b';
        setTimeout(() => {
          scoreEl.style.transform = 'scale(1)';
          scoreEl.style.color = '';
        }, 300);

        // Button press ripple
        btn.style.transform = 'scale(0.85)';
        setTimeout(() => { btn.style.transform = 'scale(1)'; }, 150);

        showHandballToast(
          action === 'plus' ? '⚽ Goal!' : '↩️ Adjusted',
          `Score updated to ${currentScore}`,
          action === 'plus' ? 'success' : 'warning'
        );
      }
    }
  });
}

// ═══════════════════════════════════════
// 11. SIDEBAR SMOOTH TOGGLE
// ═══════════════════════════════════════

function initSidebarToggle() {
  const body = document.body;
  const sidebar = document.querySelector('.sidebar');
  const toggleBtn = document.getElementById('sidebarToggleTop');
  const wrapper = document.getElementById('wrapper');

  if (!sidebar) return;

  // Add data-tooltip attributes to nav links for hover labels when collapsed
  sidebar.querySelectorAll('.nav-item .nav-link').forEach(link => {
    const spanEl = link.querySelector('span');
    if (spanEl) {
      link.setAttribute('data-tooltip', spanEl.textContent.trim());
    }
  });

  // Check saved state - default to collapsed (toggled)
  const savedState = localStorage.getItem('sidebarState');
  if (savedState === 'expanded') {
    // User explicitly expanded before
    body.classList.remove('sidebar-toggled');
    sidebar.classList.remove('toggled');
    if (wrapper) wrapper.classList.remove('toggled');
  } else {
    // Default: collapsed (icons only)
    body.classList.add('sidebar-toggled');
    sidebar.classList.add('toggled');
    if (wrapper) wrapper.classList.add('toggled');
  }

  // Remove preload class after first paint to re-enable transitions for manual clicks
  requestAnimationFrame(function () {
    setTimeout(function () {
      body.classList.remove('preload-sidebar');
      document.documentElement.classList.remove('sidebar-init-collapsed', 'sidebar-init-expanded');
    }, 60);
  });

  // Toggle button click handler
  if (toggleBtn) {
    // Prevent SB Admin 2 default handler from interfering
    toggleBtn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();

      const isCurrentlyCollapsed = sidebar.classList.contains('toggled');

      if (isCurrentlyCollapsed) {
        // EXPAND sidebar
        body.classList.remove('sidebar-toggled');
        sidebar.classList.remove('toggled');
        if (wrapper) wrapper.classList.remove('toggled');
        localStorage.setItem('sidebarState', 'expanded');
        // Rotate hamburger icon
        toggleBtn.querySelector('i').style.transform = 'rotate(0deg)';
      } else {
        // COLLAPSE sidebar
        body.classList.add('sidebar-toggled');
        sidebar.classList.add('toggled');
        if (wrapper) wrapper.classList.add('toggled');
        localStorage.setItem('sidebarState', 'collapsed');
        // Rotate hamburger icon
        toggleBtn.querySelector('i').style.transform = 'rotate(90deg)';
      }
    }, true); // Use capture to run before SB Admin 2
  }

  // Set initial icon rotation
  if (toggleBtn && sidebar.classList.contains('toggled')) {
    toggleBtn.querySelector('i').style.transform = 'rotate(90deg)';
  }
}
