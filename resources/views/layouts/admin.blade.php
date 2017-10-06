@extends('layouts.app')

@section('app.content')

<nav class="navbar navbar-toggleable-md navbar-light bg-faded mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/admin-panel') }}">Basic POS System - Shopfront Test</a>
        <div class="navbar-collapse">
            <ul class="nav navbar-nav">
                <a class="nav-item nav-link" href="{{ url('/add-product') }}">Add Product</a>
                <a class="nav-item nav-link" href="{{ url('/product-list') }}">Modify Product</a>
                <a class="nav-item nav-link" href="{{ url('/order-list') }}">View All Orders</a>
                <a class="nav-item nav-link" href="{{ url('/take-orders') }}">Go to Register (Take Orders)</a>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

@include('partials.messages')
@yield('admin.content')

</div>

@endsection
