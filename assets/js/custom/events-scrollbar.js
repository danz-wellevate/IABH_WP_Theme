document.addEventListener('DOMContentLoaded', function () {
  const tracks = document.querySelectorAll('.events-track');
  if (!tracks.length) return;

  tracks.forEach(initEventsTrack);

  function initEventsTrack(root) {
    const row = root.querySelector('.events-repeater');
    const track = root.querySelector('.events-scrollbar');
    const thumb = root.querySelector('.events-scrollbar__thumb');

    if (!row || !track || !thumb) return;

    let rafId = null;
    let isThumbDragging = false;
    let isRowDragging = false;
    let snapReenableId = null;

    // Scroll-snap has been removed from the CSS entirely (no snapping,
    // ever) — these are now no-ops, kept so the call sites below don't
    // need to change.
    function suspendSnap() {}
    function resumeSnapWhenIdle() {}

    /* ---------------------------------
       1. Size + position the thumb
       (skipped mid-drag on the thumb itself — we set its
       position directly there for zero-lag feedback)
    --------------------------------- */
    function syncThumb() {
      if (isThumbDragging) return;

      const trackWidth = track.clientWidth - 10; // minus 5px padding each side
      const ratio = row.clientWidth / row.scrollWidth;
      const overflowing = row.scrollWidth > row.clientWidth + 1;

      track.classList.toggle('is-visible', overflowing);
      if (!overflowing) return;

      const thumbWidth = Math.max(trackWidth * ratio, 40);
      const maxThumbTravel = trackWidth - thumbWidth;
      const scrollRatio = row.scrollLeft / (row.scrollWidth - row.clientWidth || 1);

      thumb.style.width = thumbWidth + 'px';
      thumb.style.transform = 'translateX(' + (maxThumbTravel * scrollRatio) + 'px)';
    }

    function onRowScroll() {
      if (rafId) return;
      rafId = requestAnimationFrame(function () {
        syncThumb();
        rafId = null;
      });
    }

    row.addEventListener('scroll', onRowScroll, { passive: true });
    window.addEventListener('resize', syncThumb);

    /* ---------------------------------
       2. Eased jump when clicking empty track space
    --------------------------------- */
    function easeInOutQuad(t) {
      return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
    }

    function animateScrollTo(target, duration) {
      suspendSnap();
      const start = row.scrollLeft;
      const distance = target - start;
      const startTime = performance.now();

      function step(now) {
        const elapsed = Math.min((now - startTime) / duration, 1);
        row.scrollLeft = start + distance * easeInOutQuad(elapsed);
        if (elapsed < 1) {
          requestAnimationFrame(step);
        } else {
          resumeSnapWhenIdle();
        }
      }
      requestAnimationFrame(step);
    }

    track.addEventListener('click', function (e) {
      if (e.target === thumb || isThumbDragging) return; // handled by thumb drag instead
      const trackRect = track.getBoundingClientRect();
      const clickRatio = (e.clientX - trackRect.left) / trackRect.width;
      const target = clickRatio * (row.scrollWidth - row.clientWidth);
      animateScrollTo(target, 300);
    });

    /* ---------------------------------
       3. Drag the thumb itself to navigate
    --------------------------------- */
    let thumbStartX = 0;
    let thumbStartScroll = 0;

    thumb.addEventListener('mousedown', function (e) {
      isThumbDragging = true;
      suspendSnap();
      thumb.style.transition = 'none';
      thumbStartX = e.clientX;
      thumbStartScroll = row.scrollLeft;
      e.preventDefault();
      e.stopPropagation();
    });

    window.addEventListener('mousemove', function (e) {
      if (!isThumbDragging) return;

      const trackWidth = track.clientWidth - 10;
      const ratio = row.clientWidth / row.scrollWidth;
      const thumbWidth = Math.max(trackWidth * ratio, 40);
      const maxThumbTravel = trackWidth - thumbWidth;
      const maxScroll = row.scrollWidth - row.clientWidth;

      const deltaX = e.clientX - thumbStartX;
      const scrollDelta = (deltaX / maxThumbTravel) * maxScroll;

      row.scrollLeft = Math.min(Math.max(thumbStartScroll + scrollDelta, 0), maxScroll);

      // Move the thumb directly for instant, lag-free feedback
      const newScrollRatio = row.scrollLeft / (maxScroll || 1);
      thumb.style.transform = 'translateX(' + (maxThumbTravel * newScrollRatio) + 'px)';
    });

    window.addEventListener('mouseup', function () {
      if (!isThumbDragging) return;
      isThumbDragging = false;
      thumb.style.transition = '';
      resumeSnapWhenIdle();
    });

    /* ---------------------------------
       4. Drag-to-scroll on the row, with momentum on release
    --------------------------------- */
    let rowStartX = 0;
    let rowStartScroll = 0;
    let velocity = 0;
    let lastX = 0;
    let lastTime = 0;
    let momentumId = null;

    row.addEventListener('mousedown', function (e) {
      isRowDragging = true;
      row.classList.add('is-dragging'); // for cursor styling
      suspendSnap();
      cancelAnimationFrame(momentumId);

      rowStartX = e.pageX;
      rowStartScroll = row.scrollLeft;
      lastX = e.pageX;
      lastTime = performance.now();
      velocity = 0;
    });

    window.addEventListener('mousemove', function (e) {
      if (!isRowDragging) return;
      e.preventDefault();

      const now = performance.now();
      const dt = now - lastTime || 16;

      row.scrollLeft = rowStartScroll - (e.pageX - rowStartX);

      velocity = (e.pageX - lastX) / dt;
      lastX = e.pageX;
      lastTime = now;
    });

    window.addEventListener('mouseup', function () {
      if (!isRowDragging) return;
      isRowDragging = false;
      row.classList.remove('is-dragging'); // cursor back to grab; snap stays off, see applyMomentum
      applyMomentum();
    });

    function applyMomentum() {
      let v = velocity * 16; // px per frame, roughly

      // No leftover velocity — nothing to glide, snap can resume right away
      if (Math.abs(v) < 0.5) {
        resumeSnapWhenIdle();
        return;
      }

      function frame() {
        if (Math.abs(v) < 0.5) {
          resumeSnapWhenIdle();
          return;
        }
        row.scrollLeft -= v;
        v *= 0.94; // friction — tune closer to 1 for a longer glide
        momentumId = requestAnimationFrame(frame);
      }
      momentumId = requestAnimationFrame(frame);
    }

    /* ---------------------------------
       5. Init after images/layout settle
    --------------------------------- */
    window.addEventListener('load', syncThumb);
    syncThumb();
  }
});