@extends('layouts.app')
@section('content')
<div style="
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
">
<h1 style="
        font-size: 28px;
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    ">Your Cart</h1>
    <ul style="
        list-style-type: none;
        padding: 0;
        margin: 0;
    ">
        @foreach($carts as $cart)
            <li style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px;
                border-bottom: 1px solid #ddd;
                font-size: 16px;
                color: #555;
            ">
            <div>
                <strong>Product ID:</strong> {{ $cart->product->name }}  <br>
                <strong>Product Name:</strong> {{ $cart->product->name }} <br>
                <strong>Quantity:</strong> {{ $cart->quantity }} <br>
                <strong>Price:</strong> {{ $cart->product->price }} TL 
            </div>
            <form action="{{ route('cart.remove', $cart->product_id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="
                        background-color: #dc3545;
                        border: none;
                        color: #fff;
                        padding: 6px 12px;
                        border-radius: 4px;
                        cursor: pointer;
                        font-size: 14px;
                    ">Remove</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@auth
<form action="{{ route('cart.applyCoupon') }}" method="POST" style="
    display: flex;
    flex-direction: column;
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
">
    @csrf
    <label for="coupon_code" style="
        font-size: 16px;
        margin-bottom: 8px;
        color: #333;
    ">Coupon Code:</label>
    <input type="text" name="coupon_code" id="coupon_code" style="
        font-size: 16px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 16px;
    ">
    <button type="submit" style="
        background-color: #007bff;
        border: none;
        color: #fff;
        padding: 12px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    ">Apply</button>
</form>
@endauth
<div style="
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
">
    <p style="
            font-size: 16px;
            color: #28a745;
            margin-bottom: 20px;
            border: 1px solid #28a745;
            padding: 10px;
            border-radius: 4px;
    "> {{ session('message') }}</p>
    <p style="
        font-size: 18px;
        margin: 10px 0;
        color: #333;
    ">Subtotal : <strong>{{ $subtotal }} TL</strong></p>
    <p style="
        font-size: 18px;
        margin: 10px 0;
        color: #333;
    ">Taxes (%20) : <strong>{{ $taxes }} TL</strong></p>
    <p style="
        font-size: 18px;
        margin: 10px 0;
        color: #333;
    ">Total: <strong>{{ $total }} TL</strong></p>
    @if(!$errors->has('minimumCartError') || !$errors->has('errorCouponCode'))
        @if(session('cart_coupon_code'))
            <p style="
                font-size: 18px;
                margin: 20px 0;
                color: #333;
            ">Coupon Code and Discount : 
            <strong>{{ session('cart_coupon_code') }} - 
            {{ session('cart_coupon_type') == 'percent' ? '%'.session('cart_discount') : session('cart_discount') . ' TL' }}</strong></p>
            @if(session('discounted_products'))
                <h2 style="
                    font-size: 22px;
                    margin-bottom: 10px;
                    color: #333;
                ">Discounted Products:</h2>
                <ul style="
                    list-style-type: none;
                    padding: 0;
                    margin: 0;
                ">
                    @foreach(session('discounted_products') as $product)
                        <li style="
                            border-bottom: 1px solid #ddd;
                            padding: 10px 0;
                            font-size: 16px;
                            color: #333;
                        ">
                            Product Name: {{ $product['product_name'] }} - 
                            Discount: {{ $product['discount'] }} TL -
                            Discounted Price: {{ $product['discounted_price'] }} TL
                        </li>
                    @endforeach
                </ul>
            @endif
        <p style="
                font-size: 18px;
                margin: 10px 0;
                color: #333;
            ">Subtotal After Discount : <strong>{{ session('cart_subtotal_after_discount') }} TL</strong></p>
        <p style="
                font-size: 18px;
                margin: 10px 0;
                color: #333;
        ">Taxes After Discount (%20) : <strong>{{ session('cart_taxes_after_discount') }} TL</strong></p>
        <p style="
                font-size: 18px;
                margin: 10px 0;
                color: #333;
        ">Total After Discount : <strong>{{ session('cart_total_after_discount') }} TL</strong></p>
        @endif
    @endif
</div>

@auth
<form action="{{ route('cart.placeOrder') }}" method="POST" style="
    display: flex;
    justify-content: center;
    margin: 20px 0;
">
    @csrf
    <button type="submit" style="
        background-color: #007bff;
        border: none;
        color: #fff;
        padding: 12px 24px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    ">Order Now</button>
</form>
@else
<p style="
    font-size: 16px;
    text-align: center;
    margin: 20px 0;
    color: #333;
">You must <a href="{{ route('login') }}" style="
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    ">login</a> or <a href="{{ route('register') }}" style="
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    ">register</a> to place an order.</p>
@endauth


@if($errors->any())
    <div style="
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 15px;
        border-radius: 4px;
        margin: 20px 0;
        font-size: 16px;
        text-align: center;
    ">{{ $errors->first() }}</div>
@endif


@endsection