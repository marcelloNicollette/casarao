import Swiper from 'swiper';
import { Navigation, Thumbs } from 'swiper/modules';

class SwiperProduct {
  slider;
  sliderQuery = ".swiper-one-product";

  constructor() {
    this.slider = document.querySelector(this.sliderQuery);
    if (this.slider != null) {
      this.initSwiper();
    }
  }

  initSwiper() {
    this.swiperThumb = new Swiper(".swiper-one-product-thumb", {
      spaceBetween: 15,
      modules: [Thumbs],
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
      breakpoints: {
        0: {
          slidesPerView: 3
        },
        1200: {
          slidesPerView: 4
        },
      }
    });

    this.swiperMain = new Swiper(this.sliderQuery, {
      speed: 400,
      slidesPerView: 'auto',
      spaceBetween: 15,
      modules: [Navigation, Thumbs],
      navigation: {
        nextEl: document.querySelector('.images-product .swiper-button-next'),
        prevEl: document.querySelector('.images-product .swiper-button-prev'),
      },
      thumbs: {
        swiper: this.swiperThumb,
      },
    });
  }
}

export default SwiperProduct;