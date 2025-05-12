class TreeView {
  constructor(selector) {
    this.treeView = document.querySelector(selector);
    if (this.treeView) {
      this.init();
    }
  }

  init() {
    this.addButtonClearFilter();

    const categories = this.treeView.querySelectorAll("li");
    categories.forEach((category) => {
      const checkbox = category.querySelector("input[type='checkbox']");
      const subcategories = category.querySelector(".subcategories");
      const expandButton = category.querySelector(".expand-button");

      checkbox.addEventListener("change", () => {
        const isChecked = checkbox.checked;

        if (subcategories) {
          const subcategoryCheckboxes = subcategories.querySelectorAll("input[type='checkbox']");
          subcategoryCheckboxes.forEach((subcategoryCheckbox) => {
            subcategoryCheckbox.checked = isChecked;
          });
        }

        this.filterProducts();
      });

      if (expandButton) {
        expandButton.addEventListener("click", () => {
          category.classList.toggle("expanded");
        });
      }
    });
  }

  addButtonClearFilter() {
    const clearButton = document.createElement("button");
    clearButton.textContent = "Limpar filtro";
    clearButton.className = "btn btn-default btn-sm text-primary";
    clearButton.addEventListener("click", () => {
      this.clearAllFilters();
    });
    this.treeView.append(clearButton);
  }

  clearAllFilters() {
    const checkboxes = this.treeView.querySelectorAll("input[type='checkbox']");
    checkboxes.forEach((checkbox) => {
      checkbox.checked = false;
    });

    this.filterProducts();
  }

  filterProducts() {
    const productElements = document.querySelectorAll(".list-products .product");
    const filters = this.getFilters();

    productElements.forEach((productElement) => {
      const productFilters = JSON.parse(productElement.dataset.categories);

      if (filters.length === 0 || filters.some((filter) => productFilters.includes(filter))) {
        productElement.style.display = "block";
      } else {
        productElement.style.display = "none";
      }
    });
  }

  getFilters() {
    const checkboxes = this.treeView.querySelectorAll("input[type='checkbox']:checked");
    const filters = Array.from(checkboxes).map((checkbox) => checkbox.value);

    console.log(filters);
    return filters;
  }
}


export default TreeView;