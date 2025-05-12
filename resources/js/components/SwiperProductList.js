import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

class SwiperProductList {
  slider;
  sliderQuery = ".product";
  swiper = [];

  constructor() {
    this.slider = document.querySelectorAll(this.sliderQuery);
    if (this.slider != null) {
      this.initSwiper();
    }
  }

  initSwiper() {
    this.slider.forEach((function (item, index) {
      this.swiper[index] = new Swiper(item.querySelector('.images-product .swiper'), {
        speed: 400,
        slidesPerView: 'auto',
        spaceBetween: 15,
        modules: [Navigation],
        navigation: {
          nextEl: item.querySelector('.images-product .swiper-button-next'),
          prevEl: item.querySelector('.images-product .swiper-button-prev'),
        },
      });
    }).bind(this));

  }
}

export default SwiperProductList;