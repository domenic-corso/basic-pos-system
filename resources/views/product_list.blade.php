@extends('layouts.admin')

@section('title', 'Modify Product - Listing ')

@section('styles')

<style type="text/css">
	table a {
		cursor: pointer;
		margin-right: 5px;
	}
</style>

@endsection

@section('admin.content')

<h1>Modify Product</h1>
<p>To <strong>edit</strong> or <strong>delete</strong> a product, start by choosing a product using the search tools below.</p>

<h5 style="margin-bottom: 20px">Filter by Category</h5>
<select class="form-control" id="category_id_filter">
	<option value="all">All Categories</option>
	@foreach (\App\Category::all() as $category)
		<option value="{{ $category->id }}">{{ $category->name }}</option>
	@endforeach
</select>

<h4 style="margin: 30px 0">Product List</h4>
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Short Name</th>
			<th>Category</th>
			<th>Price</th>
			<th>Options</th>
		</tr>
	</thead>
	<tbody id="product_list_table_body">

	</tbody>
</table>

@endsection

@section('scripts')

<script src="{{ url('/js/admin/ProductList.js') }}"></script>

@endsection
