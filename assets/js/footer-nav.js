/**
 * Footer Nav — Submenu Toggle
 * /assets/js/footer-nav.js
 */

function initFooterNav() {

    var items = document.querySelectorAll('.footer-nav-list .menu-item-has-children');
    if (!items.length) return;

    // ── Inject SVG chevron into every parent link ─────────────────────
    items.forEach(function (item) {
        var link = item.querySelector(':scope > a');
        if (!link || link.querySelector('.footer-chevron')) return;

        var chevron = document.createElement('span');
        chevron.className = 'footer-chevron';
        chevron.innerHTML =
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" aria-hidden="true" ' +
                'style="display:block;width:12px;height:7px;flex-shrink:0;">' +
                '<path d="M0 0l5 6 5-6z" ' +
                    'style="fill:#ffffff;stroke:#ffffff;stroke-width:1.5;' +
                    'stroke-linejoin:round;stroke-linecap:round;"/>' +
            '</svg>';
        link.appendChild(chevron);
    });

    // ── Force sub-menu link styles ────────────────────────────────────
    function styleSubMenuLinks(subMenu) {
        subMenu.querySelectorAll('a').forEach(function (a) {
            a.style.setProperty('color', '#ffffff', 'important');
            a.style.setProperty('background-color', 'transparent', 'important');
            a.style.setProperty('display', 'block', 'important');
            a.style.setProperty('padding', '5px 0', 'important');
            a.style.setProperty('font-size', '14px', 'important');
            a.style.setProperty('font-weight', '400', 'important');
            a.style.setProperty('text-decoration', 'none', 'important');
            a.style.setProperty('border', 'none', 'important');
            a.style.setProperty('opacity', '1', 'important');
            a.style.setProperty('transition', 'opacity 0.2s ease', 'important');

            a.addEventListener('mouseenter', function () {
                a.style.setProperty('opacity', '1', 'important');
            });
            a.addEventListener('mouseleave', function () {
                a.style.setProperty('opacity', '0.8', 'important');
            });
        });
    }

    // ── Init: prepare sub-menus for animation ─────────────────────────
    items.forEach(function (item) {
        var subMenu = item.querySelector(':scope > .sub-menu');
        if (!subMenu) return;

        subMenu.style.setProperty('overflow', 'hidden', 'important');
        subMenu.style.setProperty('max-height', '0', 'important');
        subMenu.style.setProperty('opacity', '0', 'important');
        subMenu.style.setProperty('transition',
            'max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), ' +
            'opacity 0.25s ease',
            'important');
        subMenu.style.setProperty('display', 'block', 'important');

        styleSubMenuLinks(subMenu);
    });

    // ── Helpers ───────────────────────────────────────────────────────
    function openItem(item) {
        var subMenu = item.querySelector(':scope > .sub-menu');
        var chevron = item.querySelector('.footer-chevron');
        if (!subMenu) return;

        item.classList.add('is-open');
        subMenu.style.setProperty('max-height', subMenu.scrollHeight + 'px', 'important');
        subMenu.style.setProperty('opacity', '1', 'important');

        if (chevron) {
            chevron.style.setProperty('transform', 'rotate(180deg)', 'important');
            var path = chevron.querySelector('path');
            if (path) {
                path.style.setProperty('fill', '#4ab3e8', 'important');
                path.style.setProperty('stroke', '#4ab3e8', 'important');
            }
        }
    }

    function closeItem(item) {
        var subMenu = item.querySelector(':scope > .sub-menu');
        var chevron = item.querySelector('.footer-chevron');
        if (!subMenu) return;

        item.classList.remove('is-open');
        subMenu.style.setProperty('max-height', '0', 'important');
        subMenu.style.setProperty('opacity', '0', 'important');

        if (chevron) {
            chevron.style.setProperty('transform', 'rotate(0deg)', 'important');
            var path = chevron.querySelector('path');
            if (path) {
                path.style.setProperty('fill', '#ffffff', 'important');
                path.style.setProperty('stroke', '#ffffff', 'important');
            }
        }
    }

    // ── Click handler ─────────────────────────────────────────────────
    items.forEach(function (item) {
        var link = item.querySelector(':scope > a');
        if (!link) return;

        // Remove any old listener by cloning the node
        var newLink = link.cloneNode(true);
        link.parentNode.replaceChild(newLink, link);

        newLink.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var isOpen = item.classList.contains('is-open');

            // Close all open items
            items.forEach(function (i) {
                if (i.classList.contains('is-open')) closeItem(i);
            });

            if (!isOpen) openItem(item);
        });
    });
}

// ── Run on initial page load ───────────────────────────────────────────
document.addEventListener('DOMContentLoaded', initFooterNav);

// ── Re-run after every Barba page transition ──────────────────────────
// Barba fires 'barba:after' on the window after the new page is in the DOM.
window.addEventListener('barba:after', initFooterNav);

// Fallback: also listen for the lower-level Barba hook if the theme uses
// barba.hooks.after() internally and dispatches a custom event.
document.addEventListener('barbaAfterEnter', initFooterNav);