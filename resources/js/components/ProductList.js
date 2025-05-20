import ToastInit from "./Toast";

export default class ProductList {
  constructor(idContent = "checkout-content", storageKey = "shoppingCart", listenerEventKey = "productAdded", isCheckout = true) {
    // Garante que o localStorage sempre tenha um valor válido
    if (!localStorage.getItem(storageKey)) {
        localStorage.setItem(storageKey, JSON.stringify([]));
    }
    console.log('ProductList init');
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

  renderOrderItem(order, index) {
    const itemContent = document.createElement('div');
    itemContent.classList.add('item-content', 'mb-2');

    const subTotal = order.hiddenFields.price * order.quantidade;
    
    itemContent.innerHTML = `
        <div class="content">
            <img src="./images/logo.png" class="img-product" alt="${order.hiddenFields.name}">
            <div class="title">${order.hiddenFields.name}</div>
            <div class="price text-center" style="font-size:.75rem; font-weight:bold;">
                R$ ${Number(order.hiddenFields.price).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} 
                x ${order.quantidade} = 
                R$ ${Number(subTotal).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
            </div>
            <div class="details">
                <p>Cor: ${order.color}</p>
                <p>Tamanho: ${order.tamanho}</p>
                <p>Tipo: ${order.caixaOption} - ${order.caixaSelecionada}</p>
            </div>
        </div>
        <div class="dados">
            <input type="text" placeholder="QUANTIDADE" class="form-control" value="Quantidade: ${order.quantidade}" disabled>
            <a href="#" class="btn btn-sm btn-remove">Remover</a>
        </div>
    `;

    this.checkoutContent.appendChild(itemContent);

    // Adicionar listener para o botão de remover
    const removeButton = itemContent.querySelector('.btn-remove');
    removeButton.addEventListener('click', (e) => {
        e.preventDefault();
        this.removeItemFromLocalStorage(index);
        this.removeOrderItem(itemContent);
        
        // Verificar se não há mais itens
        const orders = JSON.parse(localStorage.getItem(this.storageKey)) || [];
        if (orders.length === 0) {
            this.checkoutContent.innerHTML = `<p class="text-primary text-center">Nenhum produto adicionado</p>`;
        }
    });
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
    
    // Disparar evento para atualizar a interface
    const productAddedEvent = new Event(this.listenerEventKey);
    window.dispatchEvent(productAddedEvent);
}

  numberCheckout() {
    const orders = JSON.parse(localStorage.getItem(this.storageKey)) || [];  
    const cartCounter = document.querySelector('.cta-number-whilistis');
    if (cartCounter) {
        cartCounter.textContent = orders.length;
    }
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
                  // Limpa completamente o localStorage
                  localStorage.clear();
                  
                  // Define explicitamente um array vazio
                  localStorage.setItem(this.storageKey, JSON.stringify([]));
                  
                  // Força a limpeza do objeto items
                  this.items = [];
                  
                  ToastInit.showToast('Pré-pedido registrado com sucesso!', { bodyClass: 'text-bg-success' });
          
                  // Atualiza o contador
                  this.numberCheckout();
                  
                  // Dispara evento do pre-pedido
                  const productAddedEvent = new Event('productAdded');
                  window.dispatchEvent(productAddedEvent);
                  
                  // Aguarda a conclusão das operações antes de recarregar
                  await new Promise(resolve => setTimeout(resolve, 1000));
                  
                  // Força um novo carregamento da página sem cache
                  window.location.href = window.location.href.split('?')[0] + '?t=' + new Date().getTime();
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