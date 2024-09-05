@extends('layouts.app')
@section('content')
<div style="
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    text-align: center;
">
    <h1 style="
        font-size: 24px;
        color: #28a745;
        margin-bottom: 20px;
    ">Order Placed Successfully!</h1>
    <p style="
        font-size: 18px;
        color: #333;
        margin-bottom: 20px;
    ">Your order (ID: <strong>{{ $order_id }}</strong>) has been successfully created.</p>
    <p style="
        font-size: 18px;
        color: #333;
        margin-bottom: 20px;
    ">Order Status: <strong>{{ $order_status }}</strong></p>
    <a href="{{ route('home') }}" style="
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    ">Return to Home</a>
</div>
@endsection