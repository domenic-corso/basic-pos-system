TakeOrders.OrderItem = function (product, size) {
    this.product = product;

    if (!product.price_definition) {
        this.size = 'fixed';
    }
    else {
        if (!['small', 'regular', 'large'].includes(size)) {
            console.error('Invalid size: ' + size);
            return null;
        }

        this.size = size;
    }
};

TakeOrders.OrderItem.prototype.getTotal = function () {
    if (this.product.fixed_price) {
        return '$' + parseFloat(this.product.fixed_price).toFixed(2);
    }

    return '$' + parseFloat(this.product.price_definition[this.size]).toFixed(2);
};

/* Get name and price to be displayed in Order Item list,
example: SMALL CAPP
example: MEAT PIE */
TakeOrders.OrderItem.prototype.getNameAndPrice = function () {
    let text = '';

    if (this.size != 'fixed') {
        text += this.size.toUpperCase() + ' ';
    }

    text += this.product.short_name;

    return text;
};
