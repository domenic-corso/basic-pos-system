@extends('layouts.admin')

@section('title', 'Orders')

@section('styles')

<style type="text/css">
    td.order-item-list {
        font-size: 80%;
    }
</style>

@endsection

@section('admin.content')

<h1>Order List</h1>
<p>Below is a list of all orders inputted in the system, ordered by date.</p>

<h4 style="margin: 30px 0">Order List</h4>
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Time</th>
			<th>Discounted</th>
			<th>Sub Total</th>
			<th>Total</th>
			<th>Discount Description</th>
            <th>Items</th>
		</tr>
	</thead>
    <tbody>
        @foreach (\App\Order::all()->sortByDesc('created_at') as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                <td>{{ $order->created_at->format('H:m:s') }}</td>
                <td>${{ number_format($order->discounted, 2) }}</td>
                <td>${{ number_format($order->sub_total, 2) }}</td>
                <td>${{ number_format($order->total, 2) }}</td>
                <td><i>{{ $order->discount_description }}</i></td>
                <td class="order-item-list">
                    @foreach ($order->order_items as $orderItem)
                        @if ($orderItem->size != 'fixed')
                            {{ strtoupper($orderItem->size) }}
                        @endif
                        {{ $orderItem->product_name }}&nbsp;-&nbsp;
                        ${{ number_format($orderItem->total, 2) }}<br />
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
