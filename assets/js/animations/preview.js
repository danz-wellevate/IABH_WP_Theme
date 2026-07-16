document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".two-column__image-content").forEach(block => {
    const hoveredImage = block.querySelector(".hovered-image");
    const preview = block.querySelector(".preview");

    if (!hoveredImage || !preview) return;

    gsap.set(hoveredImage, { autoAlpha: 0 });

    let isToggled = false;

    const show = () => gsap.to(hoveredImage, { autoAlpha: 1, duration: 0.2, ease: "power2.out" });
    const hide = () => gsap.to(hoveredImage, { autoAlpha: 0, duration: 0.15, ease: "power2.in" });

    // All devices: click preview button to toggle on/off
    preview.addEventListener("click", (e) => {
      e.stopPropagation();
      isToggled = !isToggled;
      isToggled ? show() : hide();
      preview.classList.toggle("is-active", isToggled);
    });

    // Clicking outside closes it
    document.addEventListener("click", (e) => {
      if (!block.contains(e.target) && isToggled) {
        isToggled = false;
        hide();
        preview.classList.remove("is-active");
      }
    });
  });

  document.querySelectorAll(".partner__item").forEach(item => {
    const button = item.querySelector(".reveal-text");
    const description = item.querySelector(".partner__description");
    const plus = item.querySelector(".plus");
    const minus = item.querySelector(".minus");

    if (!button || !description || !plus || !minus) return;

    gsap.set(description, { height: 0, autoAlpha: 0 });
    gsap.set(minus, { autoAlpha: 0 });

    let isOpen = false;

    button.addEventListener("click", () => {
      isOpen = !isOpen;
      item.classList.toggle("is-open", isOpen);

      gsap.killTweensOf([description, plus, minus, button]);

      if (isOpen) {
        gsap.timeline()
          .fromTo(description,
            { height: 0, autoAlpha: 0 },
            { height: "auto", autoAlpha: 1, duration: 0.18, ease: "power2.out" }
          )
          .to(plus,   { autoAlpha: 0, duration: 0.1 }, 0)
          .to(minus,  { autoAlpha: 1, duration: 0.1 }, 0)
          .to(button, { backgroundColor: "#24356D", duration: 0.15 }, 0);
      } else {
        gsap.timeline()
          .to(description, { height: 0, autoAlpha: 0, duration: 0.15, ease: "power2.in" })
          .to(plus,   { autoAlpha: 1, duration: 0.1 }, 0)
          .to(minus,  { autoAlpha: 0, duration: 0.1 }, 0)
          .to(button, { backgroundColor: "#00A4C3", duration: 0.15 }, 0);
      }
    });
  });
});