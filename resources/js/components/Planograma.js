import DragDropPlanograma from "./DragDropPlanograma";
import ToastInit from "./Toast";

export default class Planograma {
  constructor() {
    this.contentPlanograma = document.getElementById('content-planograma');

    if (this.contentPlanograma) {
      this.buttons = document.querySelectorAll('.list-buttons .btn');
      this.init();
    }
  }

  init() {
    let currentTipo = localStorage.getItem('planogramaTipo');
    let currentQuantidade = localStorage.getItem('planogramaQuantidade');
    if (currentTipo == null) {
      currentTipo = "vip-4-ganchos";
      currentQuantidade = 4;
      localStorage.setItem('planogramaTipo', currentTipo);
      localStorage.setItem('planogramaQuantidade', currentQuantidade);
    }
    this.updateContentPlanograma(currentTipo, currentQuantidade);

    this.buttons.forEach(button => {
      button.addEventListener('click', () => {
        const tipo = button.dataset.tipo;
        const items = parseInt(button.dataset.items);

        if (tipo && items) {
          this.clickUpdateContentPlanograma(button, tipo, items);
        }
      });
    });

    document.getElementById('clearPlanograma').addEventListener('click', () => {
      localStorage.setItem('planogramaTipo', null);
      localStorage.setItem('planogramaQuantidade', null);
      localStorage.setItem('planograma', null);
      ToastInit.showToast('Planograma limpo com sucesso!', { bodyClass: 'text-bg-success' });
      this.contentPlanograma.innerHTML = '';
      this.buttons.forEach(button => {
        button.classList.remove('active');
      });
    });

  }

  clickUpdateContentPlanograma(clickedButton, tipo, items) {
    this.buttons.forEach(button => {
      button.classList.remove('active');
    });
    clickedButton.classList.add('active');

    this.updateContentPlanograma(tipo, items);

    //salva no localStorage
    localStorage.setItem('planogramaTipo', tipo);
    localStorage.setItem('planogramaQuantidade', items);
  }

  updateContentPlanograma(tipo, items) {
    const dataPlanograma = JSON.parse(localStorage.getItem('planograma')) || [];
    
    this.contentPlanograma.innerHTML = '';
    for (let i = 0; i < items; i++) {
      const divItemPlanograma = document.createElement('div');
      divItemPlanograma.dataset.index = i;
      divItemPlanograma.classList.add('item-planograma');

      if (dataPlanograma[i] !== null && dataPlanograma[i] !== undefined) {
        const contentItem = DragDropPlanograma.createItem(dataPlanograma[i], i);
        divItemPlanograma.appendChild(contentItem);

        const buttonRemove = document.createElement('button');
        buttonRemove.className = 'btn bg-primary text-white d-flex align-items-center justify-content-center rounded-circle position-absolute end-0 top-0'
        buttonRemove.innerHTML = 'X';
        buttonRemove.addEventListener('click', DragDropPlanograma.removeProduct.bind(this));
        divItemPlanograma.appendChild(buttonRemove);
      }

      this.contentPlanograma.appendChild(divItemPlanograma);
    }

    this.contentPlanograma.className = `body-planograma d-grid gap-2 ${tipo}`;

    const productAddedEvent = new Event('reloadDrop');
    window.dispatchEvent(productAddedEvent);
  }
}