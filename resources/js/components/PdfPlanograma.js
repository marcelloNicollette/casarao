import ToastInit from "./Toast";

export default class PdfPlanograma {
  constructor() {
    this.addListeners();
  }

  addListeners() {
    const btn = document.getElementById('gerar_pdf_planograma');
    if (btn) {
      this.form = document.getElementById('planograma_form');


      btn.addEventListener('click', ((e) => {
        e.preventDefault();
        this.removeChilds(this.form);
        this.export();
      }).bind(this));
    }
  }

  export() {
    const orders = JSON.parse(localStorage.getItem('favorites')) || [];
    const favoriteSelected = document.querySelector('#planograma select.select-favorites-planograma');
    if (!favoriteSelected || favoriteSelected.value === '') {
      ToastInit.showToast('Lista de favoritos não selecionada.', { bodyClass: 'text-bg-danger' })
      return;
    }

    const wishlist = orders.wishilist.find((item) => item.id === parseInt(favoriteSelected.value));
    
    if (wishlist && wishlist.wishilist_products.length > 0) {
      const planogramaQuantidade = localStorage.getItem('planogramaQuantidade') || '4';
      const planogramaTipo = localStorage.getItem('planogramaTipo') || 'vip-4-ganchos';
      const planograma = JSON.parse(localStorage.getItem('planograma')) || [];
      const wishlist_id = wishlist.id;

      this.createForm(wishlist.wishilist_products, planogramaQuantidade, planogramaTipo, planograma, wishlist_id);
    }
    else {
      ToastInit.showToast('Nenhum produto nos favoritos.', { bodyClass: 'text-bg-danger' })
    }
  }

  createForm(orders, planogramaQuantidade, planogramaTipo, planograma, wishlist_id) {
    orders.forEach((element, index) => {
      Object.keys(element).forEach(key => {
        const input = document.createElement('input');
        input.setAttribute('name', `content[${index}][${key}]`);
        input.setAttribute('type', 'hidden');
        input.setAttribute('value', element[key]);
        this.form.appendChild(input);
      })
    });
    //console.log(wishlist_id);
    const wishlist_id_input = document.createElement('input');
    wishlist_id_input.setAttribute('name', 'wishlist_id');
    wishlist_id_input.setAttribute('type', 'hidden');
    wishlist_id_input.setAttribute('value', wishlist_id);
    this.form.appendChild(wishlist_id_input);

    const inputPlanogramaQuantidade = document.createElement('input');
    inputPlanogramaQuantidade.setAttribute('name', 'planograma[quantidade]');
    inputPlanogramaQuantidade.setAttribute('type', 'hidden');
    inputPlanogramaQuantidade.setAttribute('value', planogramaQuantidade);
    this.form.appendChild(inputPlanogramaQuantidade);

    const inputPlanogramaTipo = document.createElement('input');
    inputPlanogramaTipo.setAttribute('name', 'planograma[tipo]');
    inputPlanogramaTipo.setAttribute('type', 'hidden');
    inputPlanogramaTipo.setAttribute('value', planogramaTipo);
    this.form.appendChild(inputPlanogramaTipo);

    planograma.forEach((element, index) => {
      if (element !== null) {
        Object.keys(element).forEach(key => {
          const input = document.createElement('input');
          input.setAttribute('name', `planograma[produtos][${index}][${key}]`);
          input.setAttribute('type', 'hidden');
          input.setAttribute('value', element[key]);
          this.form.appendChild(input);
        })
      }
      else {
        const input = document.createElement('input');
        input.setAttribute('name', `planograma[produtos][${index}]`);
        input.setAttribute('type', 'hidden');
        input.setAttribute('value', '');
        this.form.appendChild(input);
      }
    });

    const inputCsrf = document.createElement('input');
    inputCsrf.setAttribute('name', '_token');
    inputCsrf.setAttribute('type', 'hidden');
    inputCsrf.setAttribute('value', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    this.form.appendChild(inputCsrf);

    this.form.submit();
  }

  removeChilds(parent) {
    while (parent.firstChild) {
      parent.removeChild(parent.firstChild);
    }
  }
}