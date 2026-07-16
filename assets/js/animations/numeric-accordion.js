document.addEventListener('DOMContentLoaded', () => {
  const accordionItems = document.querySelectorAll(
    '.numeric-accordion .accordion-item'
  );

  accordionItems.forEach(item => {
    const header  = item.querySelector('.accordion-header');
    const content = item.querySelector('.accordion-content');
    const icon    = item.querySelector('.accordion-icon path');
    const accent  = item.dataset.accent;

    // Store accent color as CSS variable
    if (accent) {
      item.style.setProperty('--accordion-accent', accent);
    }

    // Initial GSAP state
    gsap.set(content, { height: 0, opacity: 0 });

    header.addEventListener('click', () => {
      const isOpen = item.classList.contains('is-active');

      // Close all items
      accordionItems.forEach(i => {
        i.classList.remove('is-active');

        gsap.to(i.querySelector('.accordion-content'), {
          height: 0,
          opacity: 0,
          duration: 0.35,
          ease: 'power2.out'
        });

        gsap.to(i.querySelector('.accordion-icon path'), {
          fill: '#A9AAAC',
          duration: 0.25,
          ease: 'power2.out'
        });
      });

      // Open current
      if (!isOpen) {
        item.classList.add('is-active');

        gsap.to(content, {
          height: 'auto',
          opacity: 1,
          duration: 0.4,
          ease: 'power2.out'
        });

        gsap.to(icon, {
          fill: accent,
          duration: 0.25,
          ease: 'power2.out'
        });
      }
    });
  });
});
