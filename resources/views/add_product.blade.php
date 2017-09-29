@extends('layouts.admin')

@section('title', 'Add Product')

@section('admin.content')

<h1>Add a New Product</h1>
<p>
	To begin, select the appropriate category you believe your product falls
	under. 
</p>
<p>
	For example, if you were adding 'Cappucino', you would select the
	'Hot Drinks' category.
</p>

<form action="{{ url('/product') }}" method="post">
	<div class="form-group">
		<label for="category_id">Category:</label>
		<select class="form-control" id="category_id" name="category_id">
			<!-- Add a new option for each Category in the database -->
			@foreach (\App\Category::all() as $category)
				<option value="{{ $category->id }}">
					{{ $category->name }}
				</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="name">Name:</label>
		<input type="text" class="form-control" id="name" name="name" placeholder="i.e. Cappucino, Soft Drink, Beef Pie etc." />
	</div>
	<div class="form-group">
		<label for="short_name">Short Name:</label>
		<input type="text" class="form-control" id="short_name" name="short_name" />
		<small class="form-text text-muted">This name is displayed on the buttons when taking orders.</small>
	</div>
	<div class="form-group">
		<label for="price_definition_id">Price Group</label>
		<select class="form-control" id="price_definition_id" name="price_definition_id">
			<!-- Add a new option for each ProductDefinition in the database -->
			@foreach (\App\PriceDefinition::all() as $priceDefinition)
				<option value="{{ $priceDefinition->id }}">
					Small - ${{ $priceDefinition->small }} Regular - ${{ $priceDefinition->regular }} Large - ${{ $priceDefinition->large }}
				</option>
			@endforeach
		</select>
		<small class="form-text text-muted">Alternatively, you can specify a fixed price below.</small>
	</div>
	<div class="form-group">
		<label for="fixed_price">Fixed Price</label>
		<div class="input-group">
			<span class="input-group-addon">$</span>
			<input type="text" class="form-control" id="fixed_price" name="fixed_price" />
		</div>
		<small class="form-text text-muted">This is useful for products with a single price such as food or retail products.</small>
	</div>
	<div class="btn-group">
		<button type="submit" class="btn btn-primary">Save &amp; Add Another</button>
		<button type="submit" class="btn btn-success">Save</button>
	</div>
</form>

@endsection