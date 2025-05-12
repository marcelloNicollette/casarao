import { Toast } from 'bootstrap';

export default class ToastInit {
  static showToast(message, options = {}) {
    const defaultOptions = {
      autohide: true,
      delay: 3000, // Tempo em milissegundos para o toast desaparecer (caso autohide seja verdadeiro)
      header: '', // Cabeçalho do toast
      bodyClass: '', // Classes adicionais para o corpo do toast
    };

    const toastOptions = { ...defaultOptions, ...options };
    const toastContainer = document.querySelector('.toast-container');

    if (!toastContainer) {
      console.error('Toast container not found. Make sure you have a container with class "toast-container" in your HTML.');
      return;
    }

    const toastElement = this.createToastElement(message, toastOptions);
    toastContainer.appendChild(toastElement);

    const bootstrapToast = new Toast(toastElement);
    bootstrapToast.show();
  }

  static createToastElement(message, options) {
    const toastElement = document.createElement('div');
    toastElement.classList.add('toast', 'show');

    if (options.bodyClass) {
      toastElement.classList.add(options.bodyClass);
    }

    if (options.autohide) {
      toastElement.setAttribute('data-bs-delay', options.delay);
    }

    const flex = document.createElement('div');
    flex.classList.add('d-flex');

    const toastBody = this.createToastBody(message);
    flex.appendChild(toastBody);

    const toastClose = this.createToastClose(options.header);
    flex.appendChild(toastClose);

    toastElement.appendChild(flex);

    return toastElement;
  }

  static createToastClose() {
    const closeButton = document.createElement('button');
    closeButton.className = 'btn-close btn-close-white me-2 m-auto';
    closeButton.setAttribute('type', 'button');
    closeButton.setAttribute('data-bs-dismiss', 'toast');

    return closeButton;
  }

  static createToastBody(message) {
    const toastBody = document.createElement('div');
    toastBody.classList.add('toast-body');
    toastBody.textContent = message;

    return toastBody;
  }
}