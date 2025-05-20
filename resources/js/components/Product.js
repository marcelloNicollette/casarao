import SwiperProduct from "./SwiperProduct";
import ToastInit from "./Toast";

export default class Product {
    constructor() {
        this.items = [];
        this.cartElement = document.getElementById('checkout-content');
        this.cartCounter = document.querySelector('.cta-number-whilistis');
        this.storageKey = 'shoppingCart';
        this.listenerEventKey = 'productAdded';
        this.isCheckout = true;
        console.log("Product init");
        // Inicialização do localStorage
        if (!localStorage.getItem(this.storageKey)) {
            localStorage.setItem(this.storageKey, JSON.stringify([]));
        }
        
        this.loadCart();
        this.init();
        this.addLocalStorageListener();
        this.numberCheckout();
        
        // Inicializar botão de finalizar
        this.btnFinalizar = document.getElementById('btn-finalizar-prepedido');
        if (this.btnFinalizar) {
            this.btnFinalizar.addEventListener('click', this.registerOrder.bind(this));
        }
    }

    init() {
        // Remover o console.log desnecessário que está causando confusão
        const productCards = document.querySelectorAll('.product');
    
        // Para cada card, configura os listeners de eventos
        productCards.forEach((card) => {
            // Elementos dentro do card atual
            const incrementBtn = card.querySelector('.increment-btn');
            const decrementBtn = card.querySelector('.decrement-btn');
            const quantityDisplay = card.querySelector('.quantity-display');
            const qtd = card.querySelector('input[name="quantidade"]');
            const addToCartBtn = card.querySelector('.add-to-cart');
            
            // Criar uma variável de quantidade específica para este card
            let quantity = 0;
            quantityDisplay.textContent = quantity;
            qtd.value = quantity;
            
            // Incrementar quantidade
            incrementBtn.addEventListener('click', () => {
                quantity++;
                quantityDisplay.textContent = quantity;
                qtd.value = quantity;
            });
        
            // Decrementar quantidade
            decrementBtn.addEventListener('click', () => {
                if (quantity >= 1) {
                    quantity--;
                    quantityDisplay.textContent = quantity;
                    qtd.value = quantity;
                }
            });
        
            // Adicionar ao carrinho e resetar quantidade
            addToCartBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.addToCart(card);
                quantity = 0;
                quantityDisplay.textContent = quantity;
                qtd.value = quantity;
            });
        });
    
        // Adicionar evento para os botões de remover no carrinho
        if (this.cartElement) {
            this.cartElement.addEventListener('click', (e) => {
                if (e.target.classList.contains('btn')) {
                    e.preventDefault();
                    const itemElement = e.target.closest('.item-content');
                    const itemIndex = Array.from(this.cartElement.children).indexOf(itemElement);
                    this.removeItem(itemIndex);
                }
            });
        }
    }
  
    addToCart(productCard) {
        const id = productCard.dataset.id;
        //const title = productCard.dataset.slug;
        const price = productCard.querySelector('input[name="price"]').value;
        const quantityElement = productCard.querySelector('input[name="quantidade"]');
        const quantity = parseInt(quantityElement.value);
        if (quantity <= 0) {
            alert('Por favor, selecione uma quantidade válida.');
            return false;
        }
  
        // Obter dados adicionais do produto
        const productName = productCard.querySelector('.product-name').textContent.trim();
  
        // Verificar se o item já existe no carrinho
        const existingItemIndex = this.items.findIndex(item => item.id === id);
  
        if (existingItemIndex !== -1) {
            // Se o item já existe, somar a quantidade
            this.items[existingItemIndex].quantity += quantity;
        } else {
            // Se o item não existe, criar novo item
            const item = {
                id: id,
                title: productName,
                quantity: quantity,
                price: price,
            };
            this.items.push(item);
        }
        
        // Reset quantity e display
        quantityElement.value = '0';
        const quantityDisplay = productCard.querySelector('.quantity-display');
        if (quantityDisplay) {
            quantityDisplay.textContent = '0';
        }
        
        // Resetar a variável quantity no escopo do card
        const card = productCard;
        const incrementBtn = card.querySelector('.increment-btn');
        if (incrementBtn) {
            //console.log('Botão de incrementar:', incrementBtn.scope);
                const scope = incrementBtn.scope || {};
                scope.quantity = 0;
        }
        this.updateCartDisplay();
        toastr.success(`Produto "${productName}" adicionado ao carrinho!`);
    }
  
    updateCartDisplay() {
      if (!this.cartElement) return;
        
        this.cartElement.innerHTML = '';
        
        if (this.items.length === 0) {
            this.cartElement.innerHTML = `<p class="text-primary text-center">Nenhum produto adicionado</p>`;
            return;
        }

        this.items.forEach((item, index) => {
            const subTotal = item.price * item.quantity;
            const itemContent = document.createElement('div');
            itemContent.classList.add('item-content', 'mb-2');
            
            itemContent.innerHTML = `
                <div class="content">
                    <img src="/images/logo.png" class="img-product" alt="${item.title}">
                    <div class="title">${item.title}</div>
                    <div class="price text-center" style="font-size:.75rem; font-weight:bold;">
                        R$ ${Number(item.price).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} 
                        x ${item.quantity} = 
                        R$ ${Number(subTotal).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                    </div>
                </div>
                <div class="dados">
                    <input type="text" placeholder="QUANTIDADE" class="form-control" value="Quantidade: ${item.quantity}" disabled>
                    <a href="#" class="btn btn-sm btn-remove">Remover</a>
                </div>
            `;

            this.cartElement.appendChild(itemContent);

            const removeButton = itemContent.querySelector('.btn-remove');
            removeButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.removeItem(index);
            });
        });
        const cartCounter = document.querySelector('.cta-number-whilistis');
        console.log('Contador de itens no carrinho:', cartCounter); // Adicionado para depuração
        console.log('Quantidade de itens no carrinho:', this.items.length); // Adicionado para depuraçã
        if (this.items.length > 0) {
          $('.cta-number-whilistis').html(this.items.length);
        }
        
        this.saveCart();
        
    }
  
    async removeItem(index) {
        if (index >= 0 && index < this.items.length) {
            this.items.splice(index, 1);
            await this.saveCart();
            this.updateCartDisplay();
        }
    }
  
    async clearCart() {
        this.items = [];
        await this.saveCart();
        this.updateCartDisplay();
    }
  
    saveCart() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.items));
        //this.updateCartDisplay();
    }

    loadCart() {
        const savedCart = localStorage.getItem(this.storageKey);
        
        if (savedCart) {
            try {
                const parsedCart = JSON.parse(savedCart);
                this.items = Array.isArray(parsedCart) ? parsedCart : [];
                this.updateCartDisplay();
                this.updateProductCardsQuantity();
                this.numberCheckout();
            } catch (e) {
                this.items = [];
            }
            
        }       
        
    }

    updateProductCardsQuantity() {
        const productCards = document.querySelectorAll('.product');
        productCards.forEach(card => {
            const id = card.querySelector('input[name="id"]').value;
            const item = this.items.find(item => item.id === id);
            if (item) {
                const quantityDisplay = card.querySelector('.quantity-display');
                const qtdInput = card.querySelector('input[name="quantidade"]');
                if (quantityDisplay && qtdInput) {
                    quantityDisplay.textContent = item.quantity;
                    qtdInput.value = item.quantity;
                }
            }
        });
    }


    addLocalStorageListener() {
        window.addEventListener(this.listenerEventKey, () => {
            this.loadCart();
        });
    }

    updateCartCounter() {
        if (this.cartCounter) {
            this.cartCounter.textContent = this.items.length;
        }
    }

    async registerOrder(e) {
        e.preventDefault();
        
        if (this.items.length === 0) {
            ToastInit.showToast('Não existe nenhum produto na sua sacola.', { bodyClass: 'text-bg-danger' });
            return;
        }
        
        await this.registerOrderApi(this.items);
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
                body: JSON.stringify({pedido: orders})
            });
            
            const responseData = await response.json();
            
            if (response.ok && responseData.status === 'success') {
                localStorage.clear();
                localStorage.setItem(this.storageKey, JSON.stringify([]));
                this.items = [];
                
                ToastInit.showToast('Pré-pedido registrado com sucesso!', { bodyClass: 'text-bg-success' });
                this.updateCartCounter();
                
                const productAddedEvent = new Event(this.listenerEventKey);
                window.dispatchEvent(productAddedEvent);
                
                await new Promise(resolve => setTimeout(resolve, 1000));
                window.location.href = window.location.href.split('?')[0] + '?t=' + new Date().getTime();
            } else {
                ToastInit.showToast(responseData.message || 'Erro ao processar pedido', { bodyClass: 'text-bg-danger' });
            }
        } catch (error) {
            console.error(error);
            ToastInit.showToast('Ocorreu um erro ao finalizar pré-pedido. Por favor, tente novamente!', { bodyClass: 'text-bg-danger' });
        } finally {
            this.loadingButton(false, this.btnFinalizar, 'Finalizar pré-pedido');
        }
    }

    loadingButton(isLoading, button, text = '') {
        if (!button) return;
        
        if (isLoading) {
            button.setAttribute('disabled', 'disabled');
            button.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
        } else {
            button.removeAttribute('disabled');
            button.innerHTML = text;
        }
    }

    numberCheckout() {
    
      const orders = JSON.parse(localStorage.getItem(this.storageKey)) || [];
      //console.log(orders.length);
    
      $('.cta-number-whilistis').html(orders.length);
    }
}