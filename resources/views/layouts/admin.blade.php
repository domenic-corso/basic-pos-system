@extends('layouts.app')

@section('app.content')

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Basic POS System - Admin Panel</a>
        </div>
        <ul class="nav navbar-nav">
            <li>
                <a href="{{ url('/new-product') }}">New Product</a>
            </li>
            <li>
                <a href="{{ url('/product-list') }}">Modify Product</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">@yield('admin.content')</div>

@endsection