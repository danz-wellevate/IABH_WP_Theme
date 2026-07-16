/**
 * News Three Column – Carousel Navigation
 *
 * Strategy: wrap the existing `.news-three-column-wrapper` inside a new
 * clip-div so overflow:hidden never touches the wrapper itself (which would
 * fight the SCSS flex layout). Column widths are measured in real pixels so
 * the maths is exact on every breakpoint.
 *
 * Breakpoints
 * -----------
 * Desktop  (> 1024 px) → 3 visible columns
 * Tablet   (601–1024 px) → 2 visible columns
 * Mobile   (≤ 600 px)  → 1 visible column
 */

(function () {
  'use strict';

  const GAP_PX = 15; // must match the gap in your SCSS

  const BREAKPOINTS = [
    { maxWidth: 600,  cols: 1 },
    { maxWidth: 1024, cols: 2 },
  ];

  function getVisibleCols() {
    const w = window.innerWidth;
    for (const bp of BREAKPOINTS) {
      if (w <= bp.maxWidth) return bp.cols;
    }
    return 3;
  }

  // ── Per-block init ───────────────────────────────────────────────────────
  function initBlock(block) {
    const wrapper = block.querySelector('.news-three-column-wrapper');
    if (!wrapper) return;

    const cols = Array.from(wrapper.querySelectorAll(':scope > .col'));
    if (cols.length === 0) return;

    // ── 1. Build clip container ──────────────────────────────────────────
    const clipDiv = document.createElement('div');
    clipDiv.className = 'news-carousel-clip';
    wrapper.parentNode.insertBefore(clipDiv, wrapper);
    clipDiv.appendChild(wrapper);

    // ── 2. Build nav ─────────────────────────────────────────────────────
    const nav = document.createElement('div');
    nav.className = 'news-carousel-nav';

    const prevBtn = document.createElement('button');
    prevBtn.className = 'news-carousel-nav__btn news-carousel-nav__btn--prev';
    prevBtn.setAttribute('aria-label', 'Previous');
    prevBtn.innerHTML = '<i class="fa-solid fa-arrow-left"></i>';

    const nextBtn = document.createElement('button');
    nextBtn.className = 'news-carousel-nav__btn news-carousel-nav__btn--next';
    nextBtn.setAttribute('aria-label', 'Next');
    nextBtn.innerHTML = '<i class="fa-solid fa-arrow-right"></i>';

    nav.appendChild(prevBtn);
    nav.appendChild(nextBtn);
    clipDiv.parentNode.insertBefore(nav, clipDiv.nextSibling);

    // ── 3. State ─────────────────────────────────────────────────────────
    let currentIndex = 0;

    // ── 4. Render ────────────────────────────────────────────────────────
    function render() {
      const visible   = getVisibleCols();
      const total     = cols.length;
      const maxIndex  = Math.max(0, total - visible);
      currentIndex    = Math.min(currentIndex, maxIndex);

      const clipWidth     = clipDiv.getBoundingClientRect().width;
      const colWidth      = (clipWidth - GAP_PX * (visible - 1)) / visible;
      const stepPx        = colWidth + GAP_PX;

      cols.forEach(col => {
        col.style.flex     = `0 0 ${colWidth}px`;
        col.style.minWidth = `${colWidth}px`;
        col.style.maxWidth = `${colWidth}px`;
      });

      const translateX = -(currentIndex * stepPx);
      wrapper.style.transform = `translateX(${translateX}px)`;

      prevBtn.disabled = currentIndex === 0;
      nextBtn.disabled = currentIndex >= maxIndex;
      prevBtn.classList.toggle('is-disabled', prevBtn.disabled);
      nextBtn.classList.toggle('is-disabled', nextBtn.disabled);
    }

    // ── 5. Prepare wrapper for sliding ───────────────────────────────────
    wrapper.style.flexDirection = 'row';
    wrapper.style.flexWrap      = 'nowrap';
    wrapper.style.transition    = 'transform 0.45s cubic-bezier(0.4, 0, 0.2, 1)';
    wrapper.style.willChange    = 'transform';

    // ── 6. Events ────────────────────────────────────────────────────────
    prevBtn.addEventListener('click', () => {
      if (currentIndex > 0) { currentIndex--; render(); }
    });

    nextBtn.addEventListener('click', () => {
      const maxIndex = Math.max(0, cols.length - getVisibleCols());
      if (currentIndex < maxIndex) { currentIndex++; render(); }
    });

    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(render, 150);
    });

    let touchStartX = 0;
    wrapper.addEventListener('touchstart', e => {
      touchStartX = e.changedTouches[0].clientX;
    }, { passive: true });
    wrapper.addEventListener('touchend', e => {
      const diff = touchStartX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 40) {
        diff > 0 ? nextBtn.click() : prevBtn.click();
      }
    }, { passive: true });

    requestAnimationFrame(render);
  }

  // ── Inject styles ────────────────────────────────────────────────────────
  function injectStyles() {
    if (document.getElementById('news-carousel-nav-styles')) return;
    const style = document.createElement('style');
    style.id = 'news-carousel-nav-styles';
    style.textContent = `
      /* Clip container */
      .news-carousel-clip {
        overflow: hidden;
        width: 100%;
      }

      /* Keep the wrapper as a plain row */
      .news-three-column-wrapper {
        overflow: visible !important;
      }

      /* Navigation row */
      .news-carousel-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 24px;
      }

      /* Arrow buttons — solid gray circle with dark icon */
      .news-carousel-nav__btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background-color: #E8E8E8;
        cursor: pointer;
        font-size: 14px;
        padding: 0;
        line-height: 1;
        transition: background-color 0.2s ease, opacity 0.2s ease, transform 0.15s ease;
      }

      .news-carousel-nav__btn i {
        color: #1a2e44; /* dark-sapphire equivalent */
      }

      .news-carousel-nav__btn:hover:not(:disabled) {
        background-color: #d0d0d0;
      }

      .news-carousel-nav__btn:active:not(:disabled) {
        transform: scale(0.92);
      }

      .news-carousel-nav__btn.is-disabled,
      .news-carousel-nav__btn:disabled {
        opacity: 0.35;
        cursor: default;
        pointer-events: none;
      }
    `;
    document.head.appendChild(style);
  }

  // ── Boot ─────────────────────────────────────────────────────────────────
  function init() {
    injectStyles();
    document.querySelectorAll('.block--custom-layout__news-three-column')
            .forEach(initBlock);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();