import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

class SwiperSubheader {
  slider;
  sliderId = "slide-categorias";
  swiper;

  constructor() {
    this.slider = document.getElementById(this.sliderId);
    if (this.slider != null) {
      this.initSwiper();
    }
  }

  initSwiper() {
    this.swiper = new Swiper("#" + this.sliderId, {
      speed: 400,
      spaceBetween: 5,
      modules: [Navigation],
      slidesPerView: 4,
      navigation: {
        nextEl: '.slide-categorias .swiper-button-next',
        prevEl: '.slide-categorias .swiper-button-prev',
      },
      breakpoints: {
        0: {
          slidesPerView: 2
        },
        992: {
          slidesPerView: 3
        },
        1200: {
          slidesPerView: 4
        },
      }
    });
  }
}

export default SwiperSubheader;