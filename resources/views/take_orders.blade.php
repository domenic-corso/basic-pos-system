@extends('layouts.app')

@section('title', 'Take Orders')

@section('styles')
    <link href="{{ url('css/take-orders.css') }}" rel="stylesheet" />
@endsection

@section('app.content')

<div id="take-orders-container">
    <div id="take-orders-top">
        <div id="take-orders-title">
            Basic POS System - ShopFront Demo
        </div>
        <div id="take-orders-time-date">
            DD/MM/YYYY HH:MM
        </div>
    </div>
    <div id="take-orders-middle">
        <div id="take-orders-left-panel">
            <div id="take-orders-order-item-list"></div>
            <div id="take-orders-promotion-description">
                Buy 1 at 10% off
            </div>
            <div id="take-orders-discount-cont">
                <strong>DISCOUNTS: </strong>
                <span id="take-orders-discount-text">-$1.25</span>
            </div>
            <div id="take-orders-total-price-cont">
                <strong>TOTAL: </strong>
                <span id="take-orders-total-text">$4.50</span>
            </div>
        </div>
        <div id="take-orders-buttons-cont">
            <div id="take-orders-cash-input-overlay">
                <div id="take-orders-cash-input">
                    $45.00
                </div>
                <div id="take-orders-cash-input-digits-cont">
                    <button type="button" id="ci-7">7</button>
                    <button type="button" id="ci-8">8</button>
                    <button type="button" id="ci-9">9</button>
                    <button type="button" id="ci-4">4</button>
                    <button type="button" id="ci-5">5</button>
                    <button type="button" id="ci-6">6</button>
                    <button type="button" id="ci-1">1</button>
                    <button type="button" id="ci-2">2</button>
                    <button type="button" id="ci-3">3</button>
                    <button type="button" id="ci-cancel">C</button>
                    <button type="button" id="ci-0">0</button>
                    <button type="button" id="ci-ok">OK</button>
                </div>
            </div>
            <div id="take-orders-size-buttons-cont">
                <button id="btn-small" type="button">SMALL</button>
                <button id="btn-regular" type="button">REGULAR</button>
                <button id="btn-large" type="button">LARGE</button>
            </div>
            <div id="take-orders-category-buttons-cont"></div>
            <div id="take-orders-product-buttons-cont"></div>
        </div>
    </div>
    <div id="take-orders-bottom">
        <button id="btn-exit" type="button">EXIT</button>
        <button id="btn-view-orders" type="button">VIEW ORDERS</button>
        <button id="btn-clear" type="button">CLEAR</button>
        <button id="btn-void" type="button">VOID</button>
        <button id="btn-eftpos" type="button">EFTPOS</button>
        <button id="btn-cash" type="button">CASH</button>
    </div>
</div>

@section('scripts')
    <script src="{{ url('js/take-orders/TakeOrders.js') }}"></script>
    <script src="{{ url('js/take-orders/TakeOrders.OrderItem.js') }}"></script>
    <script src="{{ url('js/take-orders/TakeOrders.order.js') }}"></script>
    <script src="{{ url('js/take-orders/TakeOrders.productBtnManager.js') }}"></script>
@endsection

@endsection
