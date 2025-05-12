import ToastInit from "./Toast";

export default class PdfCheckout {
  constructor() {
    this.addListeners();
  }

  addListeners() {
    const btn = document.getElementById('gerar_pdf_sacola');
    if (btn) {
      this.form = document.getElementById('sacola_form');

      btn.addEventListener('click', ((e) => {
        e.preventDefault();
        this.removeChilds(this.form);
        this.export();
      }).bind(this));
    }
  }

  export() {
    const orders = JSON.parse(localStorage.getItem('orders')) || [];

    if (orders.length > 0) {
      this.createForm(orders);
    }
    else {
      ToastInit.showToast('Nenhum produto na sacola.', { bodyClass: 'text-bg-danger' })
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