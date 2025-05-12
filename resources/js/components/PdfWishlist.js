import ToastInit from "./Toast";

export default class PdfWishlist {
  constructor() {
    this.addListeners();
  }

  addListeners() {
    const btn = document.getElementById('gerar_pdf_wishlist');
    if (btn) {
      this.form = document.getElementById('wishlist_form');

      btn.addEventListener('click', ((e) => {
        e.preventDefault();
        this.removeChilds(this.form);
        this.export();
      }).bind(this));
    }
  }

  export() {
    const orders = JSON.parse(localStorage.getItem('favorites')) || [];
    const favoriteSelected = document.querySelector('#dropdown-favorites select.select-favorites');
    if (!favoriteSelected) {
      ToastInit.showToast('Lista de favoritos não selecionada.', { bodyClass: 'text-bg-danger' })
    }
    //console.log(favoriteSelected.value);
    const whislist_id = document.createElement('input');
    whislist_id.setAttribute('name', 'whislist_id');
    whislist_id.setAttribute('type', 'hidden');
    whislist_id.setAttribute('value', favoriteSelected.value);
    this.form.appendChild(whislist_id);

    const wishlist = orders.wishilist.find((item) => item.id === parseInt(favoriteSelected.value));
    if (wishlist && wishlist.wishilist_products.length > 0) {
      this.createForm(wishlist.wishilist_products);
    }
    else {
      ToastInit.showToast('Nenhum produto nos favoritos.', { bodyClass: 'text-bg-danger' })
    }
  }

  createForm(orders) {
    orders.forEach((element, index) => {
      Object.keys(element).forEach(key => {
        const input = document.createElement('input');
        input.setAttribute('name', `content[${index}][${key}]`);
        input.setAttribute('type', 'hidden');
        input.setAttribute('value', element[key]);
        this.form.appendChild(input);
      })
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