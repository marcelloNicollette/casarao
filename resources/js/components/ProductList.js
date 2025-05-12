import ToastInit from "./Toast";

export default class ProductList {
  constructor(idContent = "checkout-content", storageKey = "shoppingCart", listenerEventKey = "productAdded", isCheckout = true) {
    localStorage.getItem('shoppingCart');
    this.checkoutContent = document.getElementById(idContent);

    if (this.checkoutContent) {
      this.storageKey = storageKey;
      this.isCheckout = isCheckout;
      this.listenerEventKey = listenerEventKey;

      this.init();
      this.loadOrdersFromLocalStorage();
      this.addLocalStorageListener();

      this.btnFinalizar = document.getElementById('btn-finalizar-prepedido');
      this.btnFinalizar.addEventListener('click', this.registerOrder.bind(this));
    }
  }

  init() {
    this.clearCheckoutContent();
  }

  clearCheckoutContent() {
    this.checkoutContent.innerHTML = '';
  }

  loadOrdersFromLocalStorage() {
    const orders = JSON.parse(localStorage.getItem(this.storageKey)) || [];

    if (orders.length > 0 && this.isCheckout) {
      orders.forEach((order, index) => this.renderOrderItem(order, index));
    }
    else {
      this.checkoutContent.innerHTML = `<p class="text-primary text-center">Nenhum produto adicionado</p>`;
    }
  }

  // renderFavoriteItem() {
  //   const itemContent = document.createElement('div');
  //   itemContent.classList.add('item-content', 'mb-2');

  //   itemContent.innerHTML = `
  //     <div class="content">
  //       <img src="${order.image}" class="img-product" alt="${order.title}" />
  //       <div class="title">${order.title}</div>
  //     </div>
  //     <div class="dados">
  //       <a href="#" class="btn btn-sm">Remover</a>
  //     </div>
  //   `;

  //   this.checkoutContent.appendChild(itemContent);

  //   // Adicionar listener para o botão de remover
  //   const btnRemover = itemContent.querySelector('.dados .btn');
  //   btnRemover.addEventListener('click', () => {
  //     this.removeItemFromLocalStorage(index);
  //     this.removeOrderItem(itemContent);
  //   });
  // }

  renderOrderItem(order, index) {
    const itemContent = document.createElement('div');
    itemContent.classList.add('item-content', 'mb-2');

    itemContent.innerHTML = ``;

    this.checkoutContent.appendChild(itemContent);

    // Adicionar listener para o botão de remover
    
  }

  addLocalStorageListener() {
    window.addEventListener(this.listenerEventKey, () => {
      this.clearCheckoutContent();
      this.loadOrdersFromLocalStorage();
    });
  }

  removeItemFromLocalStorage(index) {
    const orders = JSON.parse(localStorage.getItem(this.storageKey)) || [];
    orders.splice(index, 1);
    localStorage.setItem(this.storageKey, JSON.stringify(orders));
    this.numberCheckout();
  }

  numberCheckout() {
    const orders = JSON.parse(localStorage.getItem(this.storageKey)) || [];  
    //console.log(orders.length);
    $('.cta-number-whilistis').html(orders.length);
  }

  removeOrderItem(itemContent) {
    this.checkoutContent.removeChild(itemContent);
  }

  async registerOrder(e) {
    e.preventDefault();

    const orders = JSON.parse(localStorage.getItem(this.storageKey)) || [];
    
    if (orders.length > 0) {
      
      this.registerOrderApi(orders);
      //window.location.href = '/export/xls/checkout';
    }
    else {
      ToastInit.showToast('Não existe nenhum produto na sua sacola.', { bodyClass: 'text-bg-danger' })
    }
  }

  async registerOrderApi(orders) {
      try {
          this.loadingButton(true, this.btnFinalizar);
          const response = await fetch(import.meta.env.VITE_URL_FINALIZAR_PREPEDIDO, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({pedido: orders}) // Dados a serem enviados no corpo da requisição
          });
          this.loadingButton(false, this.btnFinalizar, 'Finalizar pré-pedido');
      
          const responseData = await response.json();
         
          if (response.ok) {
              if (responseData.status === 'success') {
                  // Remove completamente os dados do localStorage
                  localStorage.removeItem('shoppingCart');
                  localStorage.removeItem('orders');
                  
                  // Força a limpeza do objeto items
                  this.items = [];
                  
                  ToastInit.showToast('Pré-pedido registrado com sucesso!', { bodyClass: 'text-bg-success' });
          
                  // Aguarda um pequeno intervalo para garantir que o localStorage seja limpo
                  await new Promise(resolve => setTimeout(resolve, 5000));
                  
                  // Atualiza o contador
                  this.numberCheckout();
                  
                  // Dispara evento do pre-pedido
                  const productAddedEvent = new Event('productAdded');
                  window.dispatchEvent(productAddedEvent);
                  
                  // Força um novo carregamento da página sem cache
                  window.location.replace(window.location.href);
              }
              else {
                  ToastInit.showToast(responseData.message, { bodyClass: 'text-bg-danger' })
              }
          } else {
              ToastInit.showToast(responseData.message, { bodyClass: 'text-bg-danger' })
          }
      } catch (error) {
          console.log(error);
          this.loadingButton(false, this.btnFinalizar, 'Finalizar pré-pedido');
          ToastInit.showToast('Ocorreu um erro ao finalizar pré-pedido. Por favor, tente novamente!', { bodyClass: 'text-bg-danger' })
      }
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