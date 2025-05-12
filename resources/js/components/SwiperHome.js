import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

class SwiperHome {
  slider;
  sliderId = "slide-home";
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
      slidesPerView: 4,
      spaceBetween: 15,
      modules: [Navigation, Pagination],
      pagination: {
        el: '#home-slide .swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '#home-slide .swiper-button-next',
        prevEl: '#home-slide .swiper-button-prev',
      },
      slidesPerView: 1
    });
  }
}

export default SwiperHome;