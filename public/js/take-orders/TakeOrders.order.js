TakeOrders.order = {
    e: {
        orderItemList: document.getElementById('take-orders-order-item-list'),
        promotionDescription: document.getElementById('take-orders-promotion-description'),
        discountText: document.getElementById('take-orders-discount-text'),
        totalPriceText: document.getElementById('take-orders-total-text')
    },

    activeOrderItem: null,
    orderItems: []
};

TakeOrders.order.helpers = {
    generateOrderItemDiv: function (orderItem) {
        let div = document.createElement('div');
        let divName = document.createElement('div');
        let divPrice = document.createElement('div');

        div.setAttribute('class', 'take-orders-order-item');
        divName.setAttribute('class', 'take-orders-order-item-name');
        divPrice.setAttribute('class', 'take-orders-order-item-price');

        divName.appendChild(document.createTextNode(orderItem.getNameAndPrice()));
        divPrice.appendChild(document.createTextNode(orderItem.getTotal()));

        div.addEventListener('click', () => { TakeOrders.order.setActiveOrderItem(orderItem) });

        div.appendChild(divName);
        div.appendChild(divPrice);

        return div;
    },

    setText: function (element, text) {
        while (element.firstChild) {
            element.removeChild(element.firstChild);
        }

        element.appendChild(document.createTextNode(text));
    },

    getSimpleOrderItem: function (orderItem) {
        return {
            product_id: orderItem.product.id,
            size: orderItem.size
        };
    }
};

TakeOrders.order.init = function () {
    this.clear();
};

TakeOrders.order.clearOrderItemsDom = function () {
    while (this.e.orderItemList.firstChild) {
        this.e.orderItemList.removeChild(this.e.orderItemList.firstChild);
    }
};

TakeOrders.order.setPromotionText = function (text) {
    this.helpers.setText(this.e.promotionDescription, text);
};

TakeOrders.order.setDiscountText = function (text) {
    this.helpers.setText(this.e.discountText, '-$' + text.toFixed(2));
};

TakeOrders.order.setTotalText = function (text) {
    this.helpers.setText(this.e.totalPriceText, '$' + text.toFixed(2));
};

TakeOrders.order.updateDom = function () {
    this.clearOrderItemsDom();

    if (this.orderItems) {
        for (orderItem of this.orderItems) {
            let orderItemDiv = this.helpers.generateOrderItemDiv(orderItem);

            if (this.activeOrderItem == orderItem) {
                orderItemDiv.className += ' selected-order-item';
            }

            this.e.orderItemList.appendChild(orderItemDiv);
        }
    }
};

TakeOrders.order.handleOrderCheckResponse = function (response) {
    let responseObj;

    try {
        responseObj = JSON.parse(response);
    } catch (e) {
        console.error('Could not parse price info response!');
    }

    this.setDiscountText(parseFloat(responseObj.discounted));
    this.setPromotionText(responseObj.discount_description);
    this.setTotalText(parseFloat(responseObj.total));
};

TakeOrders.order.update = function () {
    this.updateDom();

    if (this.orderItems.length) {
        BL.httpGet(TakeOrders.CHECK_ORDER_URL,
            {order_json: this.getJsonOrder()},
            this.handleOrderCheckResponse.bind(this));
    }
    else {
        this.setPromotionText('');
        this.setDiscountText(0);
        this.setTotalText(0);
    }
};

TakeOrders.order.sendOrder = function () {
    if (this.orderItems.length) {
        BL.httpGet(TakeOrders.INSERT_ORDER_URL,
            {order_json: this.getJsonOrder()},
            () => { this.clear() });
    }
};

TakeOrders.order.clear = function () {
    this.setPromotionText('');
    this.setDiscountText(0);
    this.setTotalText(0);

    this.orderItems = [];
    this.activeOrderItem = [];

    this.update();
};

TakeOrders.order.void = function () {
    if (!this.activeOrderItem) { return; }

    let index = this.orderItems.indexOf(this.activeOrderItem);

    this.orderItems.splice(index, 1);

    if (index < this.orderItems.length) {
        this.activeOrderItem = this.orderItems[index];
    }
    else {
        this.activeOrderItem = this.orderItems[this.orderItems.length - 1];
    }

    this.update();
};

TakeOrders.order.eftpos = function () {
    this.sendOrder();
};

TakeOrders.order.cash = function () {
    console.log("Selected CASH");
};

TakeOrders.order.addOrderItem = function (orderItem) {
    TakeOrders.setActiveSize(TakeOrders.STARTING_SIZE);

    this.orderItems.push(orderItem);
    this.setActiveOrderItem(orderItem);
    this.update();
};

TakeOrders.order.setActiveOrderItem = function (orderItem) {
    if (this.orderItems.includes(orderItem)) {
        this.activeOrderItem = orderItem;
    }

    this.updateDom();
};

TakeOrders.order.getJsonOrder = function () {
    if (!this.orderItems.length) { return '' }

    let jsonObj = {
        order_items: []
    };

    for (orderItem of this.orderItems) {
        jsonObj.order_items.push(this.helpers.getSimpleOrderItem(orderItem));
    } return JSON.stringify(jsonObj);
};
