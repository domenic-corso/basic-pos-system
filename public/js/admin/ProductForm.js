let ProductForm = {
	e: {
		nameField: document.getElementById('name'),
		shortNameField: document.getElementById('short_name'),
		priceGroupSelect: document.getElementById('price_definition_id'),
		fixedPriceFormGroup: document.getElementById('fixed_price_form_group'),
		fixedPriceField: document.getElementById('fixed_price'),
		fixedPriceOption: document.getElementById('fixed_price_option')
	}
};

ProductForm.handlers = {
	nameChanged: function () {
		this.e.shortNameField.value = this.getShortName(this.e.nameField.value);
	},
	priceGroupChanged: function () {
		this.updateCorrectPriceInput();
	}
};

ProductForm.addEventListeners = function () {
	this.e.nameField.addEventListener('keyup', this.handlers.nameChanged.bind(this));
	this.e.priceGroupSelect.addEventListener('change', this.handlers.priceGroupChanged.bind(this));
};

ProductForm.init = function () {
	this.addEventListeners();
	this.updateCorrectPriceInput();
};

/* Generates a basic short name given a long name. */
ProductForm.getShortName = function (longName) {
	const MAX_LENGTH = 12;

	if (longName.length > MAX_LENGTH * 2) { return '' }
	if (longName.length <= MAX_LENGTH) { return longName.toUpperCase() }

	let shortName = '';
	for (let i = 0; i < longName.length; i += 2) {
		shortName += longName[i];
	}

	return shortName.toUpperCase();
};

/* Show 'Fixed Price' field if 'Use fixed price' option is selected
for the Price Group drop-down. */
ProductForm.updateCorrectPriceInput = function () {
	let selectedOption = this.e.priceGroupSelect.selectedOptions[0];

	if (selectedOption == this.e.fixedPriceOption) {
		this.e.fixedPriceFormGroup.style.display = "block";
		this.e.fixedPriceField.focus();
	}
	else {
		this.e.fixedPriceFormGroup.style.display = "none";
	}
};

ProductForm.init();