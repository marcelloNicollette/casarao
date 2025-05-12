import ToastInit from "./Toast";

export default class FavoritesManager {
  constructor(productElement, classForm = "form-add-checkout", btnContent = "Criar nova lista", swiper = null) {
    //console.log(productElement);
    if (productElement) {
      this.prod = productElement;
      this.productElement = productElement.querySelector("." + classForm);
      this.btnContent = btnContent;

      this.selectFavorites = this.productElement.querySelector('.select-favorites');
      this.createFavoriteBtn = this.productElement.querySelector('.create-favorite');
      this.addFavoriteBtn = this.productElement.querySelector('.add-favorite');

      this.swiper = swiper;

      this.addLoadListener();
      this.addLocalStorageListener();
    }
  }

  addLoadListener() {
    window.addEventListener('favoriteLoaded', () => {
      this.favoritesList = JSON.parse(localStorage.getItem('favorites')) || [];
      this.initialize();
    });
  }

  addLocalStorageListener() {
    window.addEventListener('favoriteAdded', () => {
      this.favoritesList = JSON.parse(localStorage.getItem('favorites')) || [];
      this.populateSelect();
    });
  }

  initialize() {
    this.populateSelect();
    this.createFavoriteBtn.addEventListener('click', () => this.createFavorite());
    this.addFavoriteBtn.addEventListener('click', () => this.addFavoriteItem());
  }

  populateSelect() {
    this.selectFavorites.innerHTML = '';
    this.favoritesList.wishilist.forEach(favorite => {
      const option = document.createElement('option');
      option.value = favorite.id;
      option.textContent = favorite.name_wishilist;
      this.selectFavorites.appendChild(option);
    });
  }

  createFavorite() {
    const inputName = this.productElement.querySelector('[name="name-new-favorite"]');
    const newName = inputName.value;
    if (newName !== undefined && newName !== null && newName !== '') {
      const newFavorite = {
        name_wishilist: newName
      };

      this.createFavoriteApi(newFavorite, inputName);
    }
    else {
      ToastInit.showToast('Por favor, preencha o nome da lista antes de continuar.', { bodyClass: 'text-bg-danger' })
    }
  }

  async createFavoriteApi(newFavorite, inputName) {
    try {
      this.loadingButton(true, this.createFavoriteBtn);
      const response = await fetch(import.meta.env.VITE_URL_FAVORITE_CREATE_LIST, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(newFavorite)
      });
      this.loadingButton(false, this.createFavoriteBtn, this.btnContent);

      if (response.ok) {
        const responseData = await response.json();
        this.saveLocalDataAndRefresh(responseData);

        ToastInit.showToast('Nova lista de favoritos criada com sucesso!', { bodyClass: 'text-bg-success' });
        inputName.value = "";
      } else {
        ToastInit.showToast('Ocorreu um erro ao criar uma nova lista de favoritos. Por favor, tente novamente!', { bodyClass: 'text-bg-danger' })
      }
    } catch (error) {
      console.log(error);
      this.loadingButton(false, this.createFavoriteBtn, this.btnContent);
      ToastInit.showToast('Ocorreu um erro ao criar uma nova lista de favoritos. Por favor, tente novamente!', { bodyClass: 'text-bg-danger' })
    }
  }

  addFavoriteItem() {
    const selectedId = this.selectFavorites.value;
    if (selectedId !== undefined && selectedId !== null && selectedId !== '') {
      const id_product = this.productElement.querySelector('[name="id"]').value;
      let id_color = 0;
      if (this.swiper === null) {
        id_color = this.productElement.querySelector('[name="id_color"]').value;
      }
      else {
        const activeSlideIndex = this.swiper.activeIndex;
        const activeSlide = this.swiper.slides[activeSlideIndex];
        id_color = activeSlide.getAttribute('data-id-color');
      }
      const id_list = selectedId;
      const data = {
        wishilist_id: id_list,
        codigo_4: id_product,
        codigo_cor: id_color
      };

      this.addFavoriteItemApi(data);
    }
    else {
      ToastInit.showToast('Por favor, selecione a lista de favoritos antes de continuar.', { bodyClass: 'text-bg-danger' })
    }
  }

  async addFavoriteItemApi(data) {
    try {
      this.loadingButton(true, this.addFavoriteBtn);
      const response = await fetch(import.meta.env.VITE_URL_FAVORITE_ADD, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data) // Dados a serem enviados no corpo da requisição
      });
      this.loadingButton(false, this.addFavoriteBtn, 'Adicionar aos favoritos');

      if (response.ok) {
        const responseData = await response.json();
        this.saveLocalDataAndRefresh(responseData);
        ToastInit.showToast('Produto adicionado aos favoritos!', { bodyClass: 'text-bg-success' });
      } else {
        ToastInit.showToast('Ocorreu um erro ao adicionar produto aos favoritos. Por favor, tente novamente!', { bodyClass: 'text-bg-danger' })
      }

    } catch (error) {
      this.loadingButton(false, this.addFavoriteBtn, 'Adicionar aos favoritos');
      ToastInit.showToast('Ocorreu um erro ao adicionar produto aos favoritos. Por favor, tente novamente!', { bodyClass: 'text-bg-danger' })
    }

    const dropdown = this.prod.querySelector('.dropdown-menu');
    //console.log(dropdown);
    dropdown.classList.remove("show");
  }

  saveLocalDataAndRefresh(data) {
    this.favoritesList = data;
    localStorage.setItem('favorites', JSON.stringify(this.favoritesList));

    //dispara evento do Favorito
    const productAddedEvent = new Event('favoriteAdded');
    window.dispatchEvent(productAddedEvent);
  }

  loadingButton(isLoading, button, text = '') {
    if (isLoading) {
      button.setAttribute('disabled', 'disabled');
      button.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    }
    else {
      button.removeAttribute('disabled');
      button.innerHTML = text;
    }
  }
}