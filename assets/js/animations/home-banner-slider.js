document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector(".home-slider");

  if (!container || typeof Swiper === "undefined") return;

  const swiper = new Swiper(container, {
	slidesPerView: 3,
	loop: true,
	centeredSlides: true,
	spaceBetween: 30,

	speed: 5000,
  autoplay: {
      delay: 0,
      enabled: true,
    },

    breakpoints: {
      768: {
        slidesPerView: 3,
        spaceBetween: 50,
      },
      360: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
    },

    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      pauseOnMouseEnter: false,
    },

    on: {
      autoplayStop: function () {
        this.autoplay.start();
      },
      transitionEnd: function () {
        this.autoplay.start();
      },
    },
  });

  // Watchdog: restart if autoplay ever drops (loop-fix timing gap or any other cause)
  setInterval(function () {
    if (!swiper.autoplay.running) {
      swiper.autoplay.start();
    }
  }, 500);

  // Restart after tab is hidden and re-focused (browser throttles delay:0 timers)
  document.addEventListener("visibilitychange", function () {
    if (!document.hidden && !swiper.autoplay.running) {
      swiper.autoplay.start();
    }
  });
});