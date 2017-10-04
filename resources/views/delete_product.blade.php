@extends('layouts.admin')

@section('title')
    {{ $product->name }} - Delete Product
@endsection

@section('admin.content')

<h1>Delete Product: {{ $product->name }}</h1>

@include('partials.product_details')

<p style="margin-top: 20px;">
    Are you sure you want to product <strong>{{ $product->name }}</strong> from the system?
</p>
<p class="text-danger">
    <strong>This cannot be undone.</strong>
</p>

<form action="{{ url('/product/' . $product->id) }}" method="post">
    <div class="btn-group">
    	<a href="{{ url('/product-list') }}" class="btn btn-success">Back to Product List</a>
    	<button type="submit" class="btn btn-danger">Confirm Delete</button>
    </div>

    {{ method_field('delete') }}
    {{ csrf_field() }}
</form>

@endsection
