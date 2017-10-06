let TakeOrders = {
    order: null,

    GET_PRODUCTS_URL: 'get-products-by-category',
    GET_CATEGORIES_URL: 'get-categories',
    CHECK_ORDER_URL: 'get-order-price-information',
    INSERT_ORDER_URL: 'save-order',

    PRODUCT_BTNS_WIDTH: 5,
    PRODUCT_BTNS_HEIGHT: 4,

    STARTING_SIZE: 'regular',

    categories: [],
    products: [],

    activeSize: 'regular',

    e: {
        categoryButtonsContainer: document.getElementById('take-orders-category-buttons-cont'),

        btnSmall: document.getElementById('btn-small'),
        btnRegular: document.getElementById('btn-regular'),
        btnLarge: document.getElementById('btn-large'),

        btnExit: document.getElementById('btn-exit'),
        btnViewOrders: document.getElementById('btn-view-orders'),
        btnClear: document.getElementById('btn-clear'),
        btnVoid: document.getElementById('btn-void'),
        btnEftpos: document.getElementById('btn-eftpos'),
        btnCash: document.getElementById('btn-cash')
    }
};

TakeOrders.getData = function () {
    BL.httpGet(this.GET_PRODUCTS_URL, {cid: 'all'}, function (response) {
        try {
            this.products = JSON.parse(response);
        } catch (e) {
            console.error('Could not read product response!');
            return;
        }

        BL.httpGet(this.GET_CATEGORIES_URL, {}, function (response) {
            try {
                this.categories = JSON.parse(response);
            } catch (e) {
                console.error('Could not read categories response!');
            }

            this.addCategoryButtons();
            this.productBtnManager.init();
        }.bind(this));
    }.bind(this));
};

/* Returns an array of products that are part of the desired category. */
TakeOrders.getProductsByCategoryId = function (id) {
    let filteredProducts = [];

    for (let product of this.products) {
        if (product.category.id == id) {
            filteredProducts.push(product);
        }
    }

    return filteredProducts;
};

/* Add Category buttons to the DOM. */
TakeOrders.addCategoryButtons = function () {
    /* For each category, make a new button, set its background color
    and add click event. */
    for (let category of this.categories) {
        let button = document.createElement('button');

        button.appendChild(document.createTextNode(category.name));
        button.style.backgroundColor = category.color;
        button.addEventListener('click', () => {
            let productsInCategory = this.getProductsByCategoryId(category.id);
            this.productBtnManager.setProducts(productsInCategory);
        });

        this.e.categoryButtonsContainer.appendChild(button);
    }
};

TakeOrders.setActiveSize = function (size) {
    const SELECTED_CLASS = 'size-btn-selected';

    this.activeSize = size;

    this.e.btnSmall.setAttribute('class', '');
    this.e.btnRegular.setAttribute('class', '');
    this.e.btnLarge.setAttribute('class', '');

    switch (size) {
        case 'small':
            return this.e.btnSmall.setAttribute('class', SELECTED_CLASS);
        case 'regular':
            return this.e.btnRegular.setAttribute('class', SELECTED_CLASS);
        case 'large':
            return this.e.btnLarge.setAttribute('class', SELECTED_CLASS);
    }
};

TakeOrders.addListeners = function () {
    this.e.btnSmall.addEventListener('click', () => { this.setActiveSize('small') });
    this.e.btnRegular.addEventListener('click', () => { this.setActiveSize('regular') });
    this.e.btnLarge.addEventListener('click', () => { this.setActiveSize('large') });

    this.e.btnExit.addEventListener('click', () => {
        window.location.href = '/';
    });
    this.e.btnViewOrders.addEventListener('click', () => {
        window.open('/list-orders');
    });
    this.e.btnClear.addEventListener('click', () => { this.order.clear() });
    this.e.btnVoid.addEventListener('click', () => { this.order.void() });
    this.e.btnEftpos.addEventListener('click', () => { this.order.eftpos() });
    this.e.btnCash.addEventListener('click', () => { this.order.cash() });
};

TakeOrders.init = function () {
    this.order.init();

    this.addListeners();
    this.getData();

    this.setActiveSize(this.STARTING_SIZE);
};

window.onload = () => {
    TakeOrders.init();
};
