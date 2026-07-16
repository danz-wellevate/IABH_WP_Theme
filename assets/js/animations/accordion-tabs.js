document.addEventListener("DOMContentLoaded", () => {
  const accordionItems = document.querySelectorAll(".accordion-tabs__item");

  const getPadding = () => window.innerWidth <= 768 ? "20px" : "30px";

  accordionItems.forEach(item => {
    const title = item.querySelector(".accordion-tabs__title");
    const wrapper = item.querySelector(".accordion-tabs__content-wrapper");
    const chevron = item.querySelector(".accordion-tabs__chevron");

    if (!title || !wrapper || !chevron) return;

    wrapper.style.maxHeight = "0";
    wrapper.style.overflow = "hidden";
    wrapper.style.paddingTop = "0";
    wrapper.style.paddingBottom = "0";
    wrapper.style.transition = "max-height 0.35s ease, padding-top 0.35s ease, padding-bottom 0.35s ease";
    chevron.style.transition = "transform 0.3s ease";

    title.addEventListener("click", () => {
      const isOpen = item.classList.contains("is-open");
      const padding = getPadding();

      accordionItems.forEach(other => {
        if (other === item) return;
        const otherWrapper = other.querySelector(".accordion-tabs__content-wrapper");
        const otherChevron = other.querySelector(".accordion-tabs__chevron");
        if (!otherWrapper || !otherChevron) return;
        other.classList.remove("is-open");
        otherWrapper.style.maxHeight = "0";
        otherWrapper.style.paddingTop = "0";
        otherWrapper.style.paddingBottom = "0";
        otherChevron.style.transform = "rotate(0deg)";
      });

      if (isOpen) {
        wrapper.style.maxHeight = "0";
        wrapper.style.paddingTop = "0";
        wrapper.style.paddingBottom = "0";
        chevron.style.transform = "rotate(0deg)";
        item.classList.remove("is-open");
      } else {
        wrapper.style.transition = "none";
        wrapper.style.paddingTop = padding;
        wrapper.style.paddingBottom = padding;
        const fullHeight = wrapper.scrollHeight;
        wrapper.style.paddingTop = "0";
        wrapper.style.paddingBottom = "0";
        wrapper.style.maxHeight = "0";

        requestAnimationFrame(() => {
          wrapper.style.transition = "max-height 0.35s ease, padding-top 0.35s ease, padding-bottom 0.35s ease";
          wrapper.style.paddingTop = padding;
          wrapper.style.paddingBottom = padding;
          wrapper.style.maxHeight = fullHeight + "px";
        });

        chevron.style.transform = "rotate(180deg)";
        item.classList.add("is-open");
      }
    });
  });

  window.addEventListener("resize", () => {
    accordionItems.forEach(item => {
      if (!item.classList.contains("is-open")) return;
      const wrapper = item.querySelector(".accordion-tabs__content-wrapper");
      if (!wrapper) return;
      const padding = getPadding();
      wrapper.style.paddingTop = padding;
      wrapper.style.paddingBottom = padding;
      wrapper.style.maxHeight = wrapper.scrollHeight + "px";
    });
  });
});