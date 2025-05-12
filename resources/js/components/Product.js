import SwiperProduct from "./SwiperProduct";
import ToastInit from "./Toast";

export default class Product {
    constructor() {
      this.items = [];
      this.cartElement = document.getElementById('checkout-content');
      this.cartCounter = document.querySelector('.cta-number-whilistis');
    }

    init() {
      console.log(localStorage.getItem('shoppingCart'));
      // Inicializar os eventos dos botões do carrinho
      const addToCartButtons = document.querySelectorAll('.add-to-cart');
      //console.log(addToCartButtons);
      addToCartButtons.forEach(button => {
        button.addEventListener('click', (e) => {
          console.log('Botão clicado');
          e.preventDefault();
          const productCard = button.closest('.product');
          this.addToCart(productCard);
        });
      });
      
      const productCards = document.querySelectorAll('.product');

      // Para cada card, configura os listeners de eventos
      productCards.forEach((card) => {
          // Elementos dentro do card atual
          const incrementBtn = card.querySelector('.increment-btn');
          const decrementBtn = card.querySelector('.decrement-btn');
          const quantityDisplay = card.querySelector('.quantity-display');
          const qtd = card.querySelector('input[name="quantidade"]');
          
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
      
          // Resetar quantidade quando o item é adicionado ao carrinho
          card.querySelector('.add-to-cart').addEventListener('click', () => {
              quantity = 0;
              quantityDisplay.textContent = quantity;
              qtd.value = quantity;
          });
      });
  
      // Adicionar evento para os botões de remover no carrinho
      this.cartElement.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn')) {
          e.preventDefault();
          const itemElement = e.target.closest('.item-content');
          const itemIndex = Array.from(this.cartElement.children).indexOf(itemElement);
          this.removeItem(itemIndex);
        }
      });
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
      
      this.updateCartDisplay();
      
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
      
      toastr.success(`Produto "${productName}" adicionado ao carrinho!`);
    }
  
    updateCartDisplay() {
      //console.log('Atualizando exibição do carrinho...');
      // Limpar o conteúdo atual
      this.cartElement.innerHTML = '';
      
      // Adicionar cada item do carrinho ao display
      this.items.forEach(item => {
        const subTotal = item.price * item.quantity;
        const itemHTML = `
          <div class="item-content mb-2">
            <div class="content">
              <img src="http://127.0.0.1:8000/images/logo.png" class="img-product" alt="${item.title}">
              <div class="title">${item.title}</div>
              <div class="price text-center" style="font-size:.75rem; font-weight:bold;">R$ ${Number(item.price).toLocaleString('pt-BR', { minimumFractionDigits: 2,  maximumFractionDigits: 2 })} x ${item.quantity} = R$ ${Number(subTotal).toLocaleString('pt-BR', { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}</div>  
            </div>
            <div class="dados">
              <input type="text" placeholder="QUANTIDADE" class="form-control" value="Quantidade: ${item.quantity}" disabled>
              <a href="#" class="btn btn-sm">Remover</a>
            </div>
          </div>
        `;
        
        this.cartElement.innerHTML += itemHTML;
      });
  
      // Atualizar contador de itens no carrinho se existir
      const cartCounter = document.querySelector('.cta-number-whilistis');
      //console.log('Contador de carrinho:', cartCounter);
      if (cartCounter) {
        cartCounter.textContent = this.items.length;
        //console.log('Contador de carrinho atualizado:', cartCounter.textContent);
      }
      this.saveCart();
    }
  
    removeItem(index) {
      if (index >= 0 && index < this.items.length) {
        this.items.splice(index, 1);
        this.updateCartDisplay();
      }
    }
  
    clearCart() {
      this.items = [];
      this.updateCartDisplay();
    }
  
    saveCart() {
      // Salvar carrinho no localStorage para persistência
      localStorage.setItem('shoppingCart', JSON.stringify(this.items));
    }
  
    loadCart() {
        //console.log('Carregando carrinho...');
        const savedCart = localStorage.getItem('shoppingCart');
        //console.log('Carrinho salvo:', savedCart);
        if (savedCart) {
            const parsedCart = JSON.parse(savedCart);
            // Verifica se o carrinho tem itens válidos
            if (Array.isArray(parsedCart) && parsedCart.length > 0) {
                this.items = parsedCart;
            } else {
                this.items = []; // Reseta o carrinho se estiver vazio
            }
            this.updateCartDisplay();
            
            // Atualizar os quantity-display dos produtos
            const productCards = document.querySelectorAll('.product');
            productCards.forEach(card => {
                const id = card.querySelector('input[name="id"]').value;
                const item = this.items.find(item => item.id === id);
                if (item) {
                    const quantityDisplay = card.querySelector('.quantity-display');
                    const qtdInput = card.querySelector('input[name="quantidade"]');
                    if (quantityDisplay && qtdInput) {
                        quantityDisplay.textContent = 0;
                        qtdInput.value = 0;
                    }
                }
            });
        } else {
            this.items = []; // Inicializa como array vazio se não houver dados no localStorage
        }
        
        if (this.cartCounter) {
            this.cartCounter.textContent = this.items.length;
        } else {
            console.log('Contador de carrinho não encontrado');
        }
    }
  }
  
  // Inicializar o carrinho quando o DOM estiver carregado
  window.addEventListener('load', () => {
      const cart = new Product();
      
      // Para acessar o carrinho globalmente, se necessário
      window.shoppingCart = cart;
      
      // inicializando
      cart.init();
      // Carregar carrinho salvo
      cart.loadCart();
      
      // Salvar carrinho ao fechar a página
      window.addEventListener('beforeunload', () => {
        cart.saveCart();
      });
  });