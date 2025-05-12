export default class DragDropPlanograma {
  selectValue = 0;

  constructor() {
    this.contentPlanograma = document.getElementById('content-planograma');
    this.favoritosPlanograma = document.querySelector('#favoritos-planograma');

    if (this.contentPlanograma && this.favoritosPlanograma) {
      this.itemFavorites = this.favoritosPlanograma.querySelectorAll('.item-favorite');
      this.itemPlanogramas = this.contentPlanograma.querySelectorAll('.item-planograma');
      this.init();
      this.reloadListener();
    }
  }

  reloadListener() {
    window.addEventListener("reloadDrag", () => {
      this.itemFavorites = this.favoritosPlanograma.querySelectorAll('.item-favorite');
      this.selectValue = document.querySelector('.select-favorites-planograma').value;
      this.init();
    });
    window.addEventListener("reloadDrop", () => {
      this.initDropListener();
    });
  }

  init() {
    // Adiciona os eventos de arrastar e soltar para os itens favoritos e planograma
    this.itemFavorites.forEach(item => {
      item.setAttribute('draggable', 'true');
      item.addEventListener('dragstart', event => this.handleDragStart(event));
      item.addEventListener('dragend', event => this.handleDragOverItem(event));
    });

    this.itemPlanogramas.forEach(item => {
      item.addEventListener('dragover', event => this.handleDragOver(event));
      item.addEventListener('drop', event => this.handleDrop(event));
    });
  }

  initDropListener() {
    this.itemPlanogramas = this.contentPlanograma.querySelectorAll('.item-planograma');
    this.itemPlanogramas.forEach(item => {
      item.addEventListener('dragover', event => this.handleDragOver(event));
      item.addEventListener('drop', event => this.handleDrop(event));
    });
  }

  handleDragStart(event) {
    // Define o data-index do item sendo arrastado
    event.dataTransfer.setData('text/plain', event.target.dataset.index);
    this.contentPlanograma.classList.add('is-dragging');
  }

  handleDragOverItem(event) {
    this.contentPlanograma.classList.remove('is-dragging');
  }

  handleDragOver(event) {
    event.preventDefault();
  }

  handleDrop(event) {
    event.preventDefault();

    // Obtém o índice do item sendo arrastado
    const index = event.dataTransfer.getData('text/plain');

    // Obtém os dados do localStorage
    const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    const planograma = JSON.parse(localStorage.getItem('planograma')) || [];

    // Verifica se já existe um item no item-planograma
    const itemPlanograma = event.currentTarget;
    if (itemPlanograma.hasChildNodes()) {
      while (itemPlanograma.firstChild) {
        itemPlanograma.removeChild(itemPlanograma.lastChild);
      }
    }

    // Atualiza o array do planograma com o novo item
    const favoriteSelected = favorites.wishilist.find(f => f.id === parseInt(this.selectValue));
    if (favoriteSelected) {
      if (favoriteSelected.wishilist_products.length > parseInt(index)) {
        planograma[parseInt(itemPlanograma.dataset.index)] = favoriteSelected.wishilist_products[parseInt(index)];

        // Adiciona o item arrastado ao item-planograma
        const newItem = DragDropPlanograma.createItem(favoriteSelected.wishilist_products[parseInt(index)], index);
        itemPlanograma.appendChild(newItem);

        const buttonRemove = document.createElement('button');
        buttonRemove.className = 'btn bg-primary text-white d-flex align-items-center justify-content-center rounded-circle position-absolute end-0 top-0'
        buttonRemove.innerHTML = 'X';
        buttonRemove.addEventListener('click', DragDropPlanograma.removeProduct.bind(this));
        itemPlanograma.appendChild(buttonRemove);
      }

      // Atualiza o localStorage
      localStorage.setItem('planograma', JSON.stringify(planograma));
    }
  }

  static removeProduct (event) {
    event.preventDefault();
    const index = parseInt(event.target.parentElement.getAttribute("data-index"));
    const planograma = JSON.parse(localStorage.getItem('planograma')) || [];
    
    try {
      event.target.parentElement.innerHTML = '';
      
      // Atualiza o localStorage
      planograma[index] = null;
      localStorage.setItem('planograma', JSON.stringify(planograma));
    }
    catch (e) {
      console.log(e);
    }
  }

  static createItem(item, index) {
    // Cria um novo elemento img para o item-planograma
    const newItem = document.createElement('img');
    newItem.dataset.index = index;
    newItem.src = item.imagem;
    return newItem;
  }
}