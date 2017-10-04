	<div class="form-group">
		<label for="category_id">Category</label>
		<select class="form-control" id="category_id" name="category_id">
			<!-- Add a new option for each Category in the database -->
			@foreach (\App\Category::all() as $category)
				<option value="{{ $category->id }}"
					@if (Request::old('category_id') == $category->id)
						selected
					@elseif ($product->category_id == $category->id)
						selected
					@endif
				>
					{{ $category->name }}
				</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="name" name="name" placeholder="i.e. Cappucino, Soft Drink, Beef Pie etc."
		value="{{ Request::old('name') ? Request::old('name') : $product->name }}"
		required minlength="3" maxlength="60" />
	</div>
	<div class="form-group">
		<label for="short_name">Short Name</label>
		<input type="text" class="form-control" id="short_name" name="short_name"  placeholder="Give a shortened name. This can be changed."
		value="{{ Request::old('short_name') ? Request::old('short_name') : $product->short_name }}"
		minlength="3" maxlength="12" required />
		<small class="form-text text-muted">This name is displayed on the buttons when taking orders.</small>
	</div>
	<div class="form-group">
		<label for="price_definition_id">Price Group</label>
		<select class="form-control" id="price_definition_id" name="price_definition_id">
			<option value="" id="fixed_price_option">Use a fixed price</option>
			<!-- Add a new option for each ProductDefinition in the database -->
			@foreach (\App\PriceDefinition::all() as $priceDefinition)
				<option value="{{ $priceDefinition->id }}"
					@if (Request::old('price_definition_id') == $priceDefinition->id ||
						$product->price_definition_id == $priceDefinition->id)

						selected
					@endif
				>
					Small - ${{ $priceDefinition->small }} Regular - ${{ $priceDefinition->regular }} Large - ${{ $priceDefinition->large }}
				</option>
			@endforeach
		</select>
		<small class="form-text text-muted">Alternatively, you can specify a fixed price below.</small>
	</div>
	<div class="form-group" id="fixed_price_form_group">
		<label for="fixed_price">Fixed Price</label>
		<div class="input-group">
			<span class="input-group-addon">$</span>
			<input type="text" class="form-control" id="fixed_price" name="fixed_price"
			value= "{{ Request::old('fixed_price') ? Request::old('fixed_price') : $product->fixed_price }}" />
		</div>
	</div>
