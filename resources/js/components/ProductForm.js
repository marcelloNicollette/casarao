import ToastInit from "./Toast";

class ProductForm {
  constructor(productElement, idForm = "form-add-checkout", isCheckout = true) {
    this.isCheckout = isCheckout;

    if (productElement) {
      this.productElement = productElement.querySelector("#" + idForm);

      this.init();
    }
  }

  init() {
    const colorOptions = this.productElement.querySelectorAll('.list-colors .color');
    colorOptions.forEach((colorOption) => {
      colorOption.addEventListener('click', () => {
        this.selectColor(colorOption);
      });
    });

    const selectCaixa = this.productElement.querySelector('.select-caixa');
    selectCaixa.addEventListener('change', () => {
      this.selectCaixaOption(selectCaixa.value);
    });

    const tamanhoItems = this.productElement.querySelectorAll('.tamanho .item');
    tamanhoItems.forEach((tamanhoItem) => {
      tamanhoItem.addEventListener('click', () => {
        this.selectItem(tamanhoItem, '.tamanho');
      });
    });

    const caixaFechadaItems = this.productElement.querySelectorAll('.caixa-fechada .item');
    caixaFechadaItems.forEach((caixaFechadaItem) => {
      caixaFechadaItem.addEventListener('click', () => {
        this.selectItem(caixaFechadaItem, '.caixa-fechada');
      });
    });

    const caixaGradeItems = this.productElement.querySelectorAll('.caixa-grade .item');
    caixaGradeItems.forEach((caixaGradeItem) => {
      caixaGradeItem.addEventListener('click', () => {
        this.selectItem(caixaGradeItem, '.caixa-grade');
      });
    });

    const btnFinalizar = this.productElement.querySelector('.btn-finalizar');
    btnFinalizar.addEventListener('click', () => {
      if (this.isCheckout) {
        this.finalizarPedido();
      } else {
        this.adicionarFavoritos();
      }
    });
  }

  selectColor(selectedColorOption) {
    const colorOptions = this.productElement.querySelectorAll('.list-colors .color');
    colorOptions.forEach((colorOption) => {
      colorOption.classList.toggle('active', colorOption === selectedColorOption);
    });

    this.showElement('.select-caixa');
  }

  selectCaixaOption(value) {
    this.hideElement('.caixa-fechada');
    this.hideElement('.caixa-grade');

    this.showElement(value === 'Caixa Fechada' ? '.caixa-fechada' : '.caixa-grade');
    this.showElement('.tamanho');
  }

  selectItem(selectedItem, containerSelector) {
    const items = this.productElement.querySelectorAll(`${containerSelector} .item`);
    items.forEach((item) => {
      item.classList.toggle('active', item === selectedItem);
    });
  }

  showElement(elementSelector) {
    const elements = this.productElement.querySelectorAll(elementSelector);
    elements.forEach((element) => {
      element.style.display = 'block';
    });
  }

  adicionarFavoritos() {
    const color = this.productElement.querySelector('.list-colors .color.active')?.dataset.color || '';
    const colorHex = this.productElement.querySelector('.list-colors .color.active')?.dataset.hex || '';
    const caixaOption = this.productElement.querySelector('.select-caixa')?.value || '';
    const tamanho = this.productElement.querySelector('.tamanho .item.active')?.textContent || '';
    const caixaFechada = this.productElement.querySelector('.caixa-fechada .item.active')?.textContent || '';
    const caixaGrade = this.productElement.querySelector('.caixa-grade .item.active')?.textContent || '';
    const quantidade = '1';

    if (color && caixaOption && tamanho && (caixaOption === 'Caixa Fechada' ? caixaFechada : caixaGrade) && quantidade) {
      const formData = {
        color,
        colorHex,
        caixaOption,
        tamanho,
        caixaSelecionada: caixaOption === 'Caixa Fechada' ? caixaFechada : caixaGrade,
        quantidade,
        hiddenFields: {}
      };

      // Obtém os valores dos campos hidden
      const hiddenFields = this.productElement.querySelectorAll('input[type="hidden"]');
      hiddenFields.forEach((hiddenField) => {
        formData.hiddenFields[hiddenField.name] = hiddenField.value;
      });

      // Salva os dados no localStorage
      const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
      favorites.push(formData);
      localStorage.setItem('favorites', JSON.stringify(favorites));

      // Exibe uma mensagem de sucesso
      ToastInit.showToast('Produto adicionado aos favoritos!', { bodyClass: 'text-bg-success' });

      //dispara evento do Favorito
      const productAddedEvent = new Event('favoriteAdded');
      window.dispatchEvent(productAddedEvent);

      // Limpa todos os campos selecionados
      this.clearAllSelections();
    } else {
      // Exibe uma mensagem de erro caso algum campo não tenha sido preenchido
      ToastInit.showToast('Por favor, preencha todos os campos corretamente.', { bodyClass: 'text-bg-danger' })
    }
  }

  finalizarPedido() {
    const color = this.productElement.querySelector('.list-colors .color.active')?.dataset.color || '';
    const colorHex = this.productElement.querySelector('.list-colors .color.active')?.dataset.hex || '';
    const caixaOption = this.productElement.querySelector('.select-caixa')?.value || '';
    const tamanho = this.productElement.querySelector('.tamanho .item.active')?.textContent || '';
    const caixaFechada = this.productElement.querySelector('.caixa-fechada .item.active')?.textContent || '';
    const caixaGrade = this.productElement.querySelector('.caixa-grade .item.active')?.textContent || '';
    const quantidade = this.productElement.querySelector('.quantidade')?.value || '';

    if (color && caixaOption && tamanho && (caixaOption === 'Caixa Fechada' ? caixaFechada : caixaGrade) && quantidade) {
      const formData = {
        color,
        colorHex,
        caixaOption,
        tamanho,
        caixaSelecionada: caixaOption === 'Caixa Fechada' ? caixaFechada : caixaGrade,
        quantidade,
        hiddenFields: {}
      };

      // Obtém os valores dos campos hidden
      const hiddenFields = this.productElement.querySelectorAll('input[type="hidden"]');
      hiddenFields.forEach((hiddenField) => {
        formData.hiddenFields[hiddenField.name] = hiddenField.value;
      });

      // Salva os dados no localStorage
      const orders = JSON.parse(localStorage.getItem('orders')) || [];
      orders.push(formData);
      localStorage.setItem('orders', JSON.stringify(orders));

      // Exibe uma mensagem de sucesso
      ToastInit.showToast('Produto adicionado a sua sacola!', { bodyClass: 'text-bg-success' });

      //dispara evento do checkout
      const productAddedEvent = new Event('productAdded');
      window.dispatchEvent(productAddedEvent);

      // Limpa todos os campos selecionados
      this.clearAllSelections();
    } else {
      // Exibe uma mensagem de erro caso algum campo não tenha sido preenchido
      ToastInit.showToast('Por favor, preencha todos os campos corretamente.', { bodyClass: 'text-bg-danger' })
    }
  }

  clearAllSelections() {
    const activeElements = this.productElement.querySelectorAll('.active');
    activeElements.forEach((element) => {
      element.classList.remove('active');
    });

    const selectCaixa = this.productElement.querySelector('.select-caixa');
    selectCaixa.selectedIndex = 0;

    this.hideElement('.select-caixa');
    this.hideElement('.caixa-fechada');
    this.hideElement('.caixa-grade');
    this.hideElement('.tamanho');
  }

  hideElement(elementSelector) {
    const elements = this.productElement.querySelectorAll(elementSelector);
    elements.forEach((element) => {
      element.style.display = 'none';

      const actived = element.querySelectorAll(".active");
      actived.forEach((active) => {
        active.classList.remove('active');
      });
    });
  }
}

export default ProductForm;