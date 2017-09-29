@extends('layouts.app')

@section('title', 'Home')

@section('app.content')

<div class="container">
	<h1>Basic Pos System</h1>

	<ul>
		<li>
			<a href="{{ url('/take-orders') }}">Take Orders</a>
		</li>
		<li>
			<a href="{{ url('/admin-panel') }}">Admin Panel</a>
		</li>
	</ul>
</div>

@endsection