@extends('layouts.admin')

@section('title', 'Admin Panel')

@section('admin.content')

<h1>Admin Panel</h1>
<p>
    What would you like to do?
</p>
<ul style="font-size: 115%;">
    <li>
        <a href="{{ url('/add-product') }}">Add a new Product</a>
    </li>
    <li>
        <a href="{{ url('/product-list') }}">Edit\Delete a Product</a>
    </li>
    <li>
        <a href="{{ url('/order-list') }}">View All Orders</a>
    </li>
    <li>
        <a href="{{ url('/take-orders') }}">Go to Register (Take Orders)</a>
    </li>
    <li>
        <a href="{{ url('/') }}">Exit to Main Menu</a>
    </li>
</ul>
@endsection
