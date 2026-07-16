document.addEventListener("DOMContentLoaded", () => {

    const secondarySidebar = document.getElementById("secondary-sidebar");
    const menuContainer = document.querySelector(".secondary-menu-container");
    const parentMenus = document.querySelectorAll(".navbar-nav .menu-item-has-children");
    const mainMenu = document.querySelector(".navbar-main-menu");

    if (!secondarySidebar || !menuContainer || !parentMenus.length || !mainMenu) return;

    const isMobile = window.matchMedia("(max-width: 768px)").matches;

    const state = {
        isOpen: false,
        isAnimating: false,   // true while any open/close tween is running
        activeParent: null,
        pendingParent: null,  // queued open request during animation
        closeTimer: null,
        openTween: null,
        closeTween: null,
        menuTween: null
    };

    /* =============================
       SCROLLBAR — SHOW ONLY WHILE ACTIVELY SCROLLING
       Adds .is-scrolling on scroll, removes it after 600ms of inactivity.
       This prevents the scrollbar from appearing on page load/reload.
    ============================== */

    const innerNavbar = document.querySelector(".sidebar-navbar-overlay .inner-wrapper-navbar");

    if (innerNavbar) {
        let scrollTimer = null;

        innerNavbar.addEventListener("scroll", () => {
            innerNavbar.classList.add("is-scrolling");

            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(() => {
                innerNavbar.classList.remove("is-scrolling");
            }, 600);
        }, { passive: true });
    }

    /* =============================
       MENU ANIMATIONS
    ============================== */

    function animateMenuIn() {
        if (state.menuTween) state.menuTween.kill();
        const items = secondarySidebar.querySelectorAll("li");
        gsap.set(items, { opacity: 0, x: 15 });
        state.menuTween = gsap.to(items, {
            opacity: 1, x: 0, stagger: 0.06, duration: 0.25, ease: "power2.out"
        });
    }

    function animateMenuOut(onComplete) {
        if (state.menuTween) state.menuTween.kill();
        const items = secondarySidebar.querySelectorAll("li");
        if (!items.length) { onComplete?.(); return; }
        state.menuTween = gsap.to(items, {
            opacity: 0, x: 10, stagger: 0.04, duration: 0.15,
            ease: "power2.in", onComplete
        });
    }

    /* =============================
       SUBMENU LOAD + ALIGNMENT
    ============================== */

    function loadSubmenu(parent) {
        const submenu = parent.querySelector(".sub-menu");
        if (!submenu) return false;
        menuContainer.innerHTML = submenu.cloneNode(true).outerHTML;
        return true;
    }

    function alignSubmenuToNavbar() {
        const submenu = secondarySidebar.querySelector(".sub-menu");
        if (!submenu) return;
        const mainMenuRect = mainMenu.getBoundingClientRect();
        const sidebarRect = secondarySidebar.getBoundingClientRect();
        gsap.set(submenu, { marginTop: mainMenuRect.top - sidebarRect.top });
    }

    /* =============================
       CORE OPEN / CLOSE LOGIC
    ============================== */

    function openSidebar(parent) {
        clearTimeout(state.closeTimer);
        state.closeTimer = null;

        // If currently closing, cancel it and open immediately from current position
        if (state.isAnimating && !state.isOpen) {
            if (state.closeTween) { state.closeTween.kill(); state.closeTween = null; }
            if (state.menuTween) { state.menuTween.kill(); state.menuTween = null; }
            state.isAnimating = false;
            // Fall through to open logic below
        }

        const isNewParent = state.activeParent !== parent;

        if (isNewParent) {
            state.activeParent = parent;
            loadSubmenu(parent);
            alignSubmenuToNavbar();
        }

        if (state.isOpen) {
            // Already open — swap content if needed
            if (isNewParent) animateMenuIn();
            return;
        }

        // Open the sidebar
        state.isOpen = true;
        state.isAnimating = true;
        document.body.classList.add("sidebar-open");

        if (state.openTween) state.openTween.kill();
        state.openTween = gsap.to(secondarySidebar, {
            width: 500, duration: 0.2, ease: "power2.out",
            onComplete: () => {
                state.isAnimating = false;
                state.openTween = null;
                animateMenuIn();

                // If a close was requested during open animation, honour it
                if (state.pendingParent === null) {
                    closeSidebar();
                }
            }
        });
    }

    function scheduleClose() {
        clearTimeout(state.closeTimer);
        state.closeTimer = setTimeout(() => closeSidebar(), 300);
    }

    function closeSidebar() {
        clearTimeout(state.closeTimer);
        state.closeTimer = null;

        // If still opening, queue the close to run after open finishes
        if (state.isAnimating && state.isOpen) {
            state.pendingParent = null; // signal: close when done
            return;
        }

        if (!state.isOpen) return;

        state.isOpen = false;
        state.isAnimating = true;
        state.activeParent = null;
        state.pendingParent = undefined; // reset pending
        document.body.classList.remove("sidebar-open");

        if (state.openTween) { state.openTween.kill(); state.openTween = null; }

        animateMenuOut(() => {
            if (state.menuTween) { state.menuTween.kill(); state.menuTween = null; }
            state.closeTween = gsap.to(secondarySidebar, {
                width: 0, duration: 0.18, ease: "power2.in",
                onComplete: () => {
                    state.isAnimating = false;
                    state.closeTween = null;
                }
            });
        });
    }

    /* =============================
       DESKTOP: HOVER BEHAVIOR
    ============================== */

    if (!isMobile) {
        parentMenus.forEach(parent => {
            if (parent.classList.contains("no-submenu")) return;

            parent.addEventListener("mouseenter", () => {
                clearTimeout(state.closeTimer);
                state.closeTimer = null;
                state.pendingParent = parent; // always record intent
                openSidebar(parent);
            });

            parent.addEventListener("mouseleave", () => scheduleClose());

            parent.addEventListener("click", e => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        secondarySidebar.addEventListener("mouseenter", () => {
            clearTimeout(state.closeTimer);
            state.closeTimer = null;
        });

        secondarySidebar.addEventListener("mouseleave", () => scheduleClose());
    }

    /* =============================
       MOBILE: CLICK BEHAVIOR
    ============================== */

    if (isMobile) {
        parentMenus.forEach(parent => {
            if (parent.classList.contains("no-submenu")) return;

            parent.addEventListener("click", e => {
                e.preventDefault();
                e.stopPropagation();
                if (state.isOpen && state.activeParent === parent) {
                    closeSidebar();
                } else {
                    openSidebar(parent);
                }
            });
        });
    }

    /* =============================
       CLICK OUTSIDE TO CLOSE
    ============================== */

    document.addEventListener("click", e => {
        if (
            !secondarySidebar.contains(e.target) &&
            !e.target.closest(".menu-item-has-children")
        ) {
            closeSidebar();
        }
    });

    /* =============================
       RESIZE REALIGNMENT
    ============================== */

    window.addEventListener("resize", () => {
        if (state.isOpen) alignSubmenuToNavbar();
    });

});