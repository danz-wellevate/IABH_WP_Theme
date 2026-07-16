document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector(".downloads-swiper");

  if (!container || typeof Swiper === "undefined") return;

  let swiperDownload;

  function updateNavButtons() {
    const prevBtn = container.querySelector(".downloads-swiper-prev");
    const nextBtn = container.querySelector(".downloads-swiper-next");

    if (!swiperDownload) return;

    if (prevBtn) {
      prevBtn.style.opacity = swiperDownload.isBeginning ? "0.3" : "1";
      prevBtn.style.pointerEvents = swiperDownload.isBeginning ? "none" : "auto";
    }

    if (nextBtn) {
      nextBtn.style.opacity = swiperDownload.isEnd ? "0.3" : "1";
      nextBtn.style.pointerEvents = swiperDownload.isEnd ? "none" : "auto";
    }
  }

  swiperDownload = new Swiper(container, {
    slidesPerView: 1,
    spaceBetween: 15,
    watchOverflow: true,

    navigation: {
      nextEl: ".downloads-swiper-next",
      prevEl: ".downloads-swiper-prev",
    },

    breakpoints: {
        480: {
    slidesPerView: 2.2,
  },

    },

    on: {
      init: updateNavButtons,
      slideChange: updateNavButtons,
      breakpoint: updateNavButtons,
    },
  });
});