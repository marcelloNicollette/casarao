import ToastInit from "./Toast";

export default class ProductFavoriteList {
  constructor() {
    this.dropdownFavorites = document.getElementById("dropdown-favorites");
    if (this.dropdownFavorites) {
      this.checkoutContent = this.dropdownFavorites.querySelector("#favorite-content");
  
      if (this.checkoutContent) {
        this.storageKey = "favorites";
        this.listenerEventKey = "favoriteAdded";
        this.currentListId = 0;
        this.favoritesList = [];
  
        this.selectFavorites = this.dropdownFavorites.querySelector('.select-favorites');
        this.selectFavorites.addEventListener("change", this.onChangeFavorites.bind(this));
  
        this.getDataFromAPI();
        this.addLocalStorageListener();
      }
    }
  }

  async getDataFromAPI() {
    try {
      this.checkoutContent.innerHTML = `<span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>`;
      const response = await fetch(import.meta.env.VITE_URL_FAVORITE_GET_LIST, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      });

      if (response.ok) {
        const responseData = await response.json();
        this.saveLocalDataAndRefresh(responseData);
      }
    } catch (error) {
      console.log(error);
    }
  }

  onChangeFavorites(e) {
    e.preventDefault();
    this.currentListId = parseInt(e.target.value);
    this.clearCheckoutContent();
    this.loadOrdersFromLocalStorage();
  }

  saveLocalDataAndRefresh(data) {
    this.favoritesList = data;
    localStorage.setItem('favorites', JSON.stringify(data));

    this.init();
    this.populateSelect();
    this.loadOrdersFromLocalStorage();

    const productAddedEvent = new Event('favoriteLoaded');
    window.dispatchEvent(productAddedEvent);
  }

  init() {
    this.clearCheckoutContent();
  }

  populateSelect() {
    this.selectFavorites.innerHTML = '';
    this.favoritesList.wishilist.forEach(favorite => {
      const option = document.createElement('option');
      option.value = favorite.id;
      option.textContent = favorite.name_wishilist;
      
      if (this.currentListId === 0) {
        this.currentListId = favorite.id;
      }
      else if (this.currentListId === favorite.id) {
        option.setAttribute('selected', 'selected');
      }

      this.selectFavorites.appendChild(option);
    });
  }

  clearCheckoutContent() {
    this.checkoutContent.innerHTML = '';
  }

  loadOrdersFromLocalStorage() {
    this.favoritesList = JSON.parse(localStorage.getItem(this.storageKey)) || null;
    if (this.favoritesList !== null) {
      const wishlistItem = this.favoritesList.wishilist.find(wishlist => wishlist.id === this.currentListId);
      const id_export = document.querySelector('.gerarPlanilha');
      
      id_export.setAttribute('href', '/api/export-xls/'+this.currentListId);
      id_export.setAttribute('data-id', this.currentListId);
      if (wishlistItem && wishlistItem.wishilist_products.length > 0) {
        wishlistItem.wishilist_products.forEach((order, index) => this.renderFavoriteItem(order, index));
        return;
      }
    }

    this.checkoutContent.innerHTML = `<p class="text-primary text-center">Nenhum produto adicionado</p>`;
  }

  renderFavoriteItem(order, index) {
   
    const itemContent = document.createElement('div');
    itemContent.classList.add('item-content', 'mb-2');
    
    if(order.status == 0){
      itemContent.setAttribute('style', 'opacity:.2;');
      itemContent.innerHTML = `
      <div class="content">
        <img src="${order.imagem}" class="img-product" alt="${order.nome_do_modelo}" />
        <div> 
          <span class="title" style="text-decoration:none; color: #000;">${order.nome_do_modelo}</span><br>
          <span style="font-size:12px;">Cor: ${order.codigo_cor} - ${order.descricao_da_cor}
        </div>
      </div>
      <div class="dados">
        <a href="#" class="btn btn-sm" style="text-decoration:none; color: #000;">produto inativo - remover</a>
      </div>
    `;
    }else{
      itemContent.innerHTML = `
      <div class="content">
        <img src="${order.imagem}" class="img-product" alt="${order.nome_do_modelo}" />
        <div> 
          <a href="/produto/${order.codigo_4}" class="title">${order.nome_do_modelo}</a><br>
          <span style="font-size:12px;">Cor: ${order.codigo_cor} - ${order.descricao_da_cor}
        </div>
      </div>
      
      <div class="dados">
        <a href="#" class="btn btn-sm">Remover</a>
      </div>
    `;
    }

    
    

    this.checkoutContent.appendChild(itemContent);

    // Adicionar listener para o botão de remover
      const btnRemover = itemContent.querySelector('.dados .btn');
      btnRemover.addEventListener('click', () => {
        this.removeItemFromLocalStorage(index);
        this.removeOrderItem(itemContent);
      });
    
  }

  addLocalStorageListener() {
    window.addEventListener(this.listenerEventKey, () => {
      this.clearCheckoutContent();
      this.loadOrdersFromLocalStorage();
      this.populateSelect()
    });
  }

  removeItemFromLocalStorage(index) {
    try {
      const list = this.favoritesList.wishilist.find(item => item.id === this.currentListId);
      if (list) {
        const itemToRemove = list.wishilist_products.splice(index, 1);
        if (itemToRemove.length > 0) {
          this.removeDataFromAPI(itemToRemove[0].codigo_4, list.id, itemToRemove[0].codigo_cor,);
        }
      }
    }
    catch (error) {
      console.log(error);
      ToastInit.showToast('Ocorreu um erro ao remover produto dos favoritos. Por favor, tente novamente!', { bodyClass: 'text-bg-danger' })
    }
  }

  async removeDataFromAPI(id_product, id_wishlist, codigo_cor) {
    try {
      const data = {
        wishilist_id: id_wishlist,
        id: id_product,
        codigo_cor: codigo_cor
      };

      const response = await fetch(import.meta.env.VITE_URL_FAVORITE_REMOVE, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
      });

      if (response.ok) {
        const responseData = await response.json();
        localStorage.setItem(this.storageKey, JSON.stringify(responseData));

        this.clearCheckoutContent();
        this.loadOrdersFromLocalStorage();
        this.populateSelect()
        ToastInit.showToast('Produto removido com sucesso!', { bodyClass: 'text-bg-success' })
      }
      else {
        ToastInit.showToast('Ocorreu um erro ao remover produto dos favoritos. Por favor, tente novamente!', { bodyClass: 'text-bg-danger' })
      }
    } catch (error) {
      console.log(error);
      ToastInit.showToast('Ocorreu um erro ao remover produto dos favoritos. Por favor, tente novamente!', { bodyClass: 'text-bg-danger' })
    }
  }

  removeOrderItem(itemContent) {
    this.checkoutContent.removeChild(itemContent);
  }
}