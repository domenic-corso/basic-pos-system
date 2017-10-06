@extends('layouts.app')

@section('title', 'Home')

@section('styles')
    <style type="text/css">
        body {
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
        }

        a {
            display: block !important;
            width: 300px;
            margin: 0 auto;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('app.content')

<div class="container">
	<h1>Basic Pos System</h1>

    <a class="btn btn-primary" href="{{ url('/take-orders') }}">Take Orders</a>
	<a class="btn btn-primary"href="{{ url('/admin-panel') }}">Admin Panel</a>
</div>

@endsection
