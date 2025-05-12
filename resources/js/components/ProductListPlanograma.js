export default class ProductListPlanograma {
  constructor() {
    this.checkoutContent = document.getElementById("favoritos-planograma");

    if (this.checkoutContent) {
      this.storageKey = "favorites";
      this.currentListId = 0;
      this.favoritesList = [];

      this.selectFavorites = document.querySelector('.select-favorites-planograma');
      this.selectFavorites.addEventListener("change", this.onChangeFavorites.bind(this));

      window.addEventListener("favoriteLoaded", () => {
        this.init();
        this.loadOrdersFromLocalStorage();
        this.populateSelect();
      });
    }
  }

  init() {
    this.clearCheckoutContent();
  }

  clearCheckoutContent() {
    this.checkoutContent.innerHTML = '';
  }

  loadOrdersFromLocalStorage() {
    this.favoritesList = JSON.parse(localStorage.getItem(this.storageKey)) || [];

    const wishlistItem = this.favoritesList.wishilist.find(wishlist => wishlist.id === this.currentListId);
    if (wishlistItem && wishlistItem.wishilist_products.length > 0) {
      wishlistItem.wishilist_products.forEach((order, index) => this.renderOrderItem(order, index));
    }
    else {
      this.checkoutContent.innerHTML = `<p class="text-primary text-center">Nenhum produto adicionado</p>`;
    }

    const productAddedEvent = new Event('reloadDrag');
    window.dispatchEvent(productAddedEvent);
  }

  onChangeFavorites(e) {
    e.preventDefault();
    //console.log('1');
    this.currentListId = parseInt(e.target.value);
    const id_export = document.querySelector('.gerarPlanilhaPlanograma');
      
      id_export.setAttribute('href', '/api/export-xls/'+this.currentListId);
      id_export.setAttribute('data-id', this.currentListId);

    this.clearCheckoutContent();
    this.loadOrdersFromLocalStorage();
  }

  populateSelect() {
    // this.selectFavorites.innerHTML = '';
    this.favoritesList.wishilist.forEach(favorite => {
      const option = document.createElement('option');
      option.value = favorite.id;
      option.textContent = favorite.name_wishilist;
      this.selectFavorites.appendChild(option);
    });
  }

  renderOrderItem(order, index) {
    console.log(order.status);
    const itemContent = document.createElement('div');
    itemContent.dataset.index = index;
    if(order.status == 0){
      itemContent.className = ' bg_red shadow-sm p-2 rounded-3 position-relative';
    }else{
      itemContent.className = 'item-favorite drag bg-white shadow-sm p-2 rounded-3 position-relative';
    }   

    itemContent.innerHTML = `
      <div class="icon-favorite position-absolute"></div>
      <div class="ratio ratio-4x4 img-favorite" style="background-image: url(${order.imagem});"></div>
      <div class="name-product text-primary text-center mt-2">
        ${order.nome_do_modelo}
      </div>`;

    this.checkoutContent.appendChild(itemContent);
  }
}