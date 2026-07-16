document.addEventListener("DOMContentLoaded", () => {
  const trigger = document.getElementById("cf-popup-trigger");
  const popup = document.querySelector(".cf-popup");
  const overlay = document.querySelector(".cf-popup__overlay");
  const content = document.querySelector(".cf-popup__content");
  const closeBtn = document.querySelector(".cf-popup__close");

    function lockScroll() {
    const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
    document.body.style.overflow = "hidden";
    document.body.style.paddingRight = `${scrollBarWidth}px`;
    }

    function unlockScroll() {
    document.body.style.overflow = "";
    document.body.style.paddingRight = "";
    }

  if (!trigger || !popup || !overlay || !content) return;

  // Initial states
  gsap.set(content, { y: -60, opacity: 0 });
  gsap.set(overlay, { opacity: 0, backdropFilter: "blur(0px)" });

  /* ===== OPEN TIMELINE ===== */
  const openTL = gsap.timeline({
    paused: true,
    defaults: { ease: "power3.out", duration: 0.45 },
    onStart: () => {
      popup.style.visibility = "visible";
      popup.style.pointerEvents = "auto";
      popup.setAttribute("aria-hidden", "false");
      lockScroll();
    }
  });

  openTL
    .to(overlay, {
      opacity: 1,
      backdropFilter: "blur(8px)",
      duration: 0.35
    }, 0)
    .to(content, {
      y: 0,
      opacity: 1
    }, 0);

  /* ===== CLOSE TIMELINE ===== */
  const closeTL = gsap.timeline({
    paused: true,
    defaults: { ease: "power3.in", duration: 0.3 },
    onComplete: () => {
    popup.style.visibility = "hidden";
    popup.style.pointerEvents = "none";
    popup.setAttribute("aria-hidden", "true");
    unlockScroll();
    }
  });

  closeTL
    .to(content, {
      y: -40,
      opacity: 0
    }, 0)
    .to(overlay, {
      opacity: 0,
      backdropFilter: "blur(0px)",
      duration: 0.25
    }, 0);

  /* ===== EVENTS ===== */
  trigger.addEventListener("click", () => {
    closeTL.pause(0);
    openTL.play(0);
  });

  overlay.addEventListener("click", () => closeTL.play(0));
  closeBtn.addEventListener("click", () => closeTL.play(0));

  document.addEventListener("keydown", e => {
    if (e.key === "Escape" && popup.style.visibility === "visible") {
      closeTL.play(0);
    }
  });




});
