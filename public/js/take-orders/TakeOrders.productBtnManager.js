TakeOrders.productBtnManager = {
    productList: [],
    buttonPages: [],
    currentPageIndex: 0,

    e: {
        productButtonsContainer: document.getElementById('take-orders-product-buttons-cont')
    }
};

TakeOrders.productBtnManager.helpers = {
    generateProductButton: function (product) {
        let button = document.createElement('button');

        button.appendChild(document.createTextNode(product.short_name));
        button.style.backgroundColor = product.category.color;
        button.style.width = (100 / TakeOrders.PRODUCT_BTNS_WIDTH) + '%';
        button.style.height = (100 / TakeOrders.PRODUCT_BTNS_HEIGHT) + '%';
        button.addEventListener('click', () => {
            let activeSize = TakeOrders.activeSize;
            let orderItem = new TakeOrders.OrderItem(product, activeSize);

            TakeOrders.order.addOrderItem(orderItem);
        });

        return button;
    },

    generateNextButton: function () {
        let button = document.createElement('button');

        button.appendChild(document.createTextNode('NEXT'));
        button.style.width = (100 / TakeOrders.PRODUCT_BTNS_WIDTH) + '%';
        button.style.height = (100 / TakeOrders.PRODUCT_BTNS_HEIGHT) + '%';
        button.addEventListener('click', () => {
            TakeOrders.productBtnManager.nextPage();
        });

        return button;
    }
};

TakeOrders.productBtnManager.init = function () {
    this.setProducts(TakeOrders.getProductsByCategoryId(TakeOrders.categories[0].id));
};

TakeOrders.productBtnManager.reset = function () {
    this.productList = [];
    this.buttonPages = [];
    this.currentPageIndex = -1;
};

TakeOrders.productBtnManager.update = function () {
    this.clearButtonsFromDom();

    if (this.buttonPages.length) {
        for (button of this.buttonPages[this.currentPageIndex]) {
            this.e.productButtonsContainer.appendChild(button);
        }
    }
};

TakeOrders.productBtnManager.clearButtonsFromDom = function () {
    while (this.e.productButtonsContainer.firstChild) {
        this.e.productButtonsContainer.removeChild(this.e.productButtonsContainer.firstChild);
    }
};

TakeOrders.productBtnManager.createButtonPages = function () {
    const MAX_BUTTONS_PER_PAGE = TakeOrders.PRODUCT_BTNS_WIDTH * TakeOrders.PRODUCT_BTNS_HEIGHT;

    let productsLeft = this.productList.length;
    let productsDone = 0;
    let max;
    while (productsLeft) {
        let buttonList = [];

        if (productsLeft <= MAX_BUTTONS_PER_PAGE) {
            max = productsLeft;

            for (productsDone; productsDone < this.productList.length; productsDone++) {
                buttonList.push(this.helpers.generateProductButton(this.productList[productsDone]));
                productsLeft--;
            }
        }
        else {
            max = productsDone + (MAX_BUTTONS_PER_PAGE - 1);

            for (productsDone; productsDone < max; productsDone++) {
                buttonList.push(this.helpers.generateProductButton(this.productList[productsDone]));
                productsLeft--;
            }

            buttonList.push(this.helpers.generateNextButton());
        }

        this.buttonPages.push(buttonList);
    }
};

TakeOrders.productBtnManager.setProducts = function (productList) {
    this.reset();

    this.productList = productList;
    this.createButtonPages();
    this.nextPage();
};

TakeOrders.productBtnManager.nextPage = function () {
    if (this.currentPageIndex >= this.buttonPages.length - 1) {
        this.currentPageIndex = 0;
    }
    else {
        this.currentPageIndex++;
    }

    this.update();
};
