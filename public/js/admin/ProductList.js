let ProductList = {
	GET_URL: './get-products-by-category',
	categories: new Map(),
	e: {
		categorySelect: document.getElementById('category_id_filter'),
		tableBody: document.getElementById('product_list_table_body')
	}
};

ProductList.handlers = {
	categoryChanged: function () {
		let categoryId = this.e.categorySelect.value;

		BL.httpGet(this.GET_URL, {cid: categoryId}, this.handlers.productListReceived.bind(this));
	},
	productListReceived: function (response) {
		let productList = [];
		/* Attempt to Parse JSON. */
		try {
			productList = JSON.parse(response).reverse();
		} catch (e) {
			alert('Sorry, the product list could not be fetched.')
			return;
		}

		this.updateTable(productList);
	}
};

ProductList.addEventListeners = function () {
	this.e.categorySelect.addEventListener('change', this.handlers.categoryChanged.bind(this));
};

ProductList.init = function () {
	/* Map category ids' to their full names. */
	/* Example: convert <option value='2'>Hot Drinks</option>
	into key: 2, value: 'Hot Drinks' */
	for (let i = 0; i < this.e.categorySelect.options.length; i++) {
		let option = this.e.categorySelect.options[i];

		if (option.value == 'all') { continue }

		this.categories.set(parseInt(option.value), option.innerHTML);
	}

	this.addEventListeners();
	this.e.categorySelect.dispatchEvent(new Event('change'));
};

ProductList.generateTableRow = function (product) {
	let row = document.createElement('tr');
	let idTd = document.createElement('td');
	let nameTd = document.createElement('td');
	let shortNameTd = document.createElement('td');
	let categoryTd = document.createElement('td');
	let optionsTd = document.createElement('td');
	let editBtn = document.createElement('a');
	let deleteBtn = document.createElement('a');

	idTd.appendChild(document.createTextNode(product.id));
	nameTd.appendChild(document.createTextNode(product.name));
	shortNameTd.appendChild(document.createTextNode(product.short_name));

	/* Get full name of the category based off the ID. */
	let categoryIdInt = parseInt(product.category_id);
	categoryTd.appendChild(document.createTextNode(this.categories.get(categoryIdInt)));

	/* Set up the edit button. */
	editBtn.setAttribute('href', './edit-product/' + product.id);
	editBtn.setAttribute('class', 'btn btn-outline-warning btn-sm');
	editBtn.appendChild(document.createTextNode('Edit'));

	/* Set up the delete button. */
	deleteBtn.setAttribute('href', './delete-product/' + product.id);
	deleteBtn.setAttribute('class', 'btn btn-outline-danger btn-sm');
	deleteBtn.appendChild(document.createTextNode('Delete'));

	optionsTd.appendChild(editBtn);
	optionsTd.appendChild(deleteBtn);

	row.appendChild(idTd);
	row.appendChild(nameTd);
	row.appendChild(shortNameTd);
	row.appendChild(categoryTd);
	row.appendChild(optionsTd);

	return row;
};

ProductList.updateTable = function (products) {
	while (this.e.tableBody.firstChild) {
		this.e.tableBody.removeChild(this.e.tableBody.firstChild);
	}

	for (let i = 0; i < products.length; i++) {
		this.e.tableBody.appendChild(this.generateTableRow(products[i]));
	}
};

ProductList.init();