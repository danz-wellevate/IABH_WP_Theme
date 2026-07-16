document.addEventListener('DOMContentLoaded', function () {
  const menuRoot = document.querySelector('.sliding-menu-container');
  if (!menuRoot) return;

  const normalize = (url) => url.replace(/\/$/, '');

  const currentUrl = normalize(
    window.location.origin + window.location.pathname
  );

  menuRoot.querySelectorAll('a[href]').forEach(link => {
    const href = link.getAttribute('href');

    // Ignore menu triggers and placeholders
    if (!href || href === '#' || href.startsWith('#')) return;

    const fullUrl = href.startsWith('http')
      ? href
      : window.location.origin + href;

    if (normalize(fullUrl) === currentUrl) {
      /* ---------------------------------
         1. Mark active submenu item
      --------------------------------- */
      const li = link.closest('li');
      if (li) {
        li.classList.add('is-active');
      }

      /* ---------------------------------
         2. If inside submenu, mark parent
      --------------------------------- */
      const subMenu = link.closest('.sub-menu');

      if (subMenu && subMenu.id) {
        subMenu.classList.add('is-submenu-active');

        const parentTrigger = menuRoot.querySelector(
          `.menu-trigger[data-submenu="${subMenu.id}"]`
        );

        if (parentTrigger) {
          const parentLi = parentTrigger.closest('.menu-item');
          if (parentLi) {
            parentLi.classList.add('is-parent-active');
          }
        }
      } else {
        /* ---------------------------------
           3. Direct first-level active
        --------------------------------- */
        const parentLi = link.closest('.menu-item');
        if (parentLi) {
          parentLi.classList.add('is-active');
        }
      }
    }
  });
});
