@extends('layouts.admin')

@section('title')
    {{ $product->name }} - Edit Product
@endsection

@section('styles')

<style type="text/css">
	label {
		font-weight: bold;
	}
</style>

@endsection

@section('admin.content')

<h1>Edit Product: {{ $product->name }}</h1>
<p>
	Use this form to modify the attributes of this product. Once saved, the
    changes will be made available instantly.
</p>

<form action="{{ url('/product/' . $product->id) }}" method="post">
    @include('partials.product_form')

	<div class="btn-group">
		<input type="submit" class="btn btn-success" value="Save Changes">
	</div>

	{{ csrf_field() }}
</form>

@endsection

@section('scripts')
	<script src="{{ url('/js/admin/ProductForm.js') }}"></script>
@endsection
