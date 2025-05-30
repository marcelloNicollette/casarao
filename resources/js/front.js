import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import "bootstrap/js/dist/modal";
import { Dropdown, Collapse, Tooltip } from "bootstrap";

import SwiperHome from "./components/SwiperHome";
import SwiperSubheader from "./components/SwiperSubheader";
import SwiperProductList from "./components/SwiperProductList";
import TreeView from "./components/TreeView";
import SwiperProduct from "./components/SwiperProduct";
import Product from "./components/Product";


document.addEventListener("DOMContentLoaded", () => {
  const dropdownElementList = document.querySelectorAll('.dropdown-toggle')
  const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new Dropdown(dropdownToggleEl))

  const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  tooltips.forEach((tooltip) => new Tooltip(tooltip));

  new SwiperHome();
  new SwiperSubheader();
  new TreeView(".tree-view");
  const swiper = new SwiperProductList();
  new SwiperProduct();
  new Product();
    

  const productElements = document.querySelectorAll('.product');
  productElements.forEach((productElement, index) => {
    //new ProductForm(productElement);
    //new FavoritesManager(productElement, "form-add-favorite", "Criar nova lista", swiper.swiper[index]);
    //new ProductForm(productElement, "form-add-favorite", false);
  });

  //const productInner = document.getElementById("show-product");
  //new FavoritesManager(productInner, "form-add-favorite", "Criar");
  
});
