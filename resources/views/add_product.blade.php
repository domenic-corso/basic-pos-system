@extends('layouts.admin')

@section('title', 'Add Product')

@section('styles')

<style type="text/css">
	label {
		font-weight: bold;
	}
</style>

@endsection

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
    @include('partials.product_form')
    
	<div class="btn-group">
		<input type="submit" class="btn btn-primary" name="add_another" value="Save & Add Another">
		<input type="submit" class="btn btn-success" value="Save">
	</div>

	{{ method_field('put') }}
	{{ csrf_field() }}
</form>

@endsection

@section('scripts')
	<script src="{{ url('/js/admin/ProductForm.js') }}"></script>
@endsection
