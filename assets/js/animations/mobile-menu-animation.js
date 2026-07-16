document.addEventListener("DOMContentLoaded", () => {
    const btn = document.querySelector(".custom-btn");
    const menuWrapper = document.querySelector('.sliding-menu-wrapper');
    const container = document.querySelector('.sliding-menu-container');

    if (!btn || !menuWrapper || !container) return;

    const state = {
        isOpen: false,
        isAnimating: false,
        openTL: null,
        closeTL: null,
        menuTween: null
    };

    // Hard hide on init — no flash
    gsap.set(menuWrapper, {
        height: 0,
        opacity: 0,
        visibility: 'hidden',
        display: 'none',
        overflow: 'hidden'
    });

    const subMenus = container.querySelectorAll('.sub-menu');
    gsap.set(subMenus, {
        x: '100%',
        opacity: 0,
        visibility: 'hidden',
        position: 'absolute',
        top: 0,
        left: 0,
        width: '100%'
    });

    const mainMenu = container.querySelector('.main-menu');
    if (mainMenu) {
        gsap.set(mainMenu, {
            x: 0,
            opacity: 1,
            visibility: 'visible',
            position: 'relative'
        });
    }

    gsap.set(container.querySelectorAll('.menu-item'), { opacity: 0, y: 10 });

    /* =============================
       MEASURE PIXEL HEIGHT
    ============================== */

    function measureHeight(el) {
        const prev = {
            position: el.style.position,
            visibility: el.style.visibility,
            display: el.style.display,
            height: el.style.height,
            x: gsap.getProperty(el, 'x')
        };

        gsap.set(el, {
            position: 'absolute',
            visibility: 'hidden',
            display: 'block',
            height: 'auto',
            x: 0
        });

        const h = el.scrollHeight;

        gsap.set(el, {
            position: prev.position || 'relative',
            visibility: prev.visibility || 'hidden',
            display: prev.display || 'block',
            height: prev.height || 'auto',
            x: prev.x || 0
        });

        return h;
    }

    function getWrapperHeight() {
        gsap.set(menuWrapper, { display: 'block', visibility: 'hidden', height: 'auto' });
        const h = menuWrapper.scrollHeight;
        gsap.set(menuWrapper, { display: 'none', visibility: 'hidden', height: 0 });
        return h;
    }

    /* =============================
       BTN CLICK
    ============================== */

    btn.addEventListener("click", () => {
        if (state.isAnimating) return;
        btn.classList.toggle("active");
        btn.classList.contains("active") ? openMenu() : closeMenu();
    });

    /* =============================
       OPEN
    ============================== */

    function openMenu() {
        state.isAnimating = true;
        state.isOpen = true;

        const mainMenu = container.querySelector('.main-menu');
        if (mainMenu) gsap.set(mainMenu, { position: 'relative', x: 0 });

        const targetHeight = getWrapperHeight();

        gsap.set(menuWrapper, {
            display: 'block',
            height: 0,
            opacity: 1,
            visibility: 'visible',
            overflow: 'hidden'
        });

        if (state.openTL) state.openTL.kill();

        state.openTL = gsap.timeline({
            onComplete: () => {
                state.isAnimating = false;
                state.openTL = null;

                if (mainMenu) {
                    state.menuTween = gsap.to(mainMenu.querySelectorAll('.menu-item'), {
                        opacity: 1,
                        y: 0,
                        duration: 0.3,
                        stagger: 0.07,
                        ease: 'power2.out'
                    });
                }
            }
        });

        state.openTL.to(menuWrapper, {
            height: targetHeight,
            duration: 0.4,
            ease: 'power2.inOut'
        });
    }

    /* =============================
       CLOSE
    ============================== */

    function closeMenu(onDone) {
        state.isAnimating = true;
        state.isOpen = false;

        const mainMenu = container.querySelector('.main-menu');

        if (state.openTL) { state.openTL.kill(); state.openTL = null; }
        if (state.menuTween) { state.menuTween.kill(); state.menuTween = null; }

        const visibleSubmenu = container.querySelector('.sub-menu[style*="position: relative"]');
        if (visibleSubmenu) {
            gsap.set(visibleSubmenu, { visibility: 'hidden', opacity: 0, position: 'absolute', x: '100%' });
            if (mainMenu) gsap.set(mainMenu, { position: 'relative', x: 0, opacity: 1 });
        }

        const menuItems = mainMenu ? mainMenu.querySelectorAll('.menu-item') : [];

        if (state.closeTL) state.closeTL.kill();

        state.closeTL = gsap.timeline({
            onComplete: () => {
                gsap.set(menuWrapper, { display: 'none', height: 0, opacity: 1, overflow: 'hidden' });
                if (menuItems.length) gsap.set(menuItems, { opacity: 0, y: 10 });
                state.isAnimating = false;
                state.closeTL = null;
                if (onDone) onDone(); // callback for post-close actions (e.g. resize reset)
            }
        });

        if (menuItems.length) {
            state.closeTL.to(menuItems, {
                opacity: 0,
                y: -8,
                duration: 0.18,
                stagger: 0.03,
                ease: 'power2.in'
            });
        }

        state.closeTL.to(menuWrapper, {
            height: 0,
            opacity: 0,
            duration: 0.35,
            ease: 'power2.inOut'
        });

        state.closeTL.set(menuWrapper, { opacity: 1 });
    }

    /* =============================
       SUBMENU TRIGGERS
    ============================== */

    const menuTriggers = container.querySelectorAll('.menu-trigger');
    menuTriggers.forEach(trigger => {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();

            const submenuId = this.dataset.submenu;
            const submenu = document.getElementById(submenuId);
            const mainMenu = container.querySelector('.main-menu');

            if (!submenu || !container.contains(submenu) || !mainMenu) return;

            const submenuItems = submenu.querySelectorAll('li');
            const submenuHeight = measureHeight(submenu);
            const mainHeight = mainMenu.scrollHeight;

            gsap.set(container, { height: mainHeight });
            gsap.set(submenuItems, { opacity: 0, x: 20 });
            gsap.set(submenu, {
                position: 'absolute',
                top: 0, left: 0,
                width: '100%',
                visibility: 'visible',
                opacity: 1,
                x: '100%'
            });

            const tl = gsap.timeline({
                onComplete: () => {
                    gsap.set(mainMenu, { position: 'absolute' });
                    gsap.set(submenu, { position: 'relative' });
                    gsap.set(container, { height: 'auto' });

                    gsap.to(submenuItems, {
                        opacity: 1, x: 0,
                        duration: 0.3, stagger: 0.07, ease: 'power2.out'
                    });
                }
            });

            tl.to(container, { height: submenuHeight, duration: 0.35, ease: 'power2.inOut' }, 0);
            tl.to(mainMenu, { x: '-100%', duration: 0.35, ease: 'power2.inOut' }, 0);
            tl.to(submenu, { x: 0, duration: 0.35, ease: 'power2.inOut' }, 0);
        });
    });

    /* =============================
       BACK BUTTONS
    ============================== */

    const backButtons = container.querySelectorAll('.back-button');
    backButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const currentSubmenu = this.closest('.sub-menu');
            const mainMenu = container.querySelector('.main-menu');

            if (!currentSubmenu || !mainMenu || !container.contains(currentSubmenu)) return;

            const menuItems = mainMenu.querySelectorAll('.menu-item');
            const mainHeight = measureHeight(mainMenu);
            const currentHeight = currentSubmenu.scrollHeight;

            gsap.set(container, { height: currentHeight });
            gsap.set(menuItems, { opacity: 0, x: -20 });
            gsap.set(mainMenu, {
                position: 'absolute',
                top: 0, left: 0,
                width: '100%',
                x: '-100%'
            });

            const tl = gsap.timeline({
                onComplete: () => {
                    gsap.set(currentSubmenu, {
                        visibility: 'hidden', opacity: 0,
                        position: 'absolute', x: '100%'
                    });
                    gsap.set(mainMenu, { position: 'relative' });
                    gsap.set(container, { height: 'auto' });

                    gsap.to(menuItems, {
                        opacity: 1, x: 0,
                        duration: 0.3, stagger: 0.07, ease: 'power2.out'
                    });
                }
            });

            tl.to(container, { height: mainHeight, duration: 0.35, ease: 'power2.inOut' }, 0);
            tl.to(currentSubmenu, { x: '100%', duration: 0.35, ease: 'power2.inOut' }, 0);
            tl.fromTo(mainMenu, { x: '-100%' }, { x: 0, duration: 0.35, ease: 'power2.inOut' }, 0);
        });
    });

/* =============================
   RESIZE HANDLER
============================== */

let resizeTimer = null;

window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        if (!state.isOpen) return;
        gsap.set(menuWrapper, { height: 'auto' });
        const newHeight = menuWrapper.scrollHeight;
        gsap.set(menuWrapper, { height: newHeight });
    }, 150);
});
});