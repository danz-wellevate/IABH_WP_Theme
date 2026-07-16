// In your swiper initialization file (e.g., swiper-init.js)
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

document.addEventListener('DOMContentLoaded', function() {
  const swiper = new Swiper('.swiper-benefits', {
    modules: [Navigation, Pagination], // Add modules here
    slidesPerView: 1,     // show part of next slide
    centeredSlides: true,   // center the active slide
    spaceBetween: 20,       // gap between slides
    loop: true,
    
    slidesOffsetBefore: 0,  // no left offset
    slidesOffsetAfter: 0,

    observer: true,
    observeParents: true,

    breakpoints: {
      768: {
        slidesPerView: 1.2,
        spaceBetween: 20,
        centeredSlides: false,
      },
    },

    pagination: {
      el: '.swiper-pagination',
    },
    
    navigation: {
      nextEl: '.swiper-nav-next',
      prevEl: '.swiper-nav-prev',
    },
  });
});