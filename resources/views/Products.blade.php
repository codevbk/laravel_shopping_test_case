@extends('layouts.app')
@section('content')
<div style="
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
">
    @foreach($products as $product)
    <div style="
            overflow: hidden;
            padding: 16px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        ">
        <livewire:product-block :productId="$product->id" />
    </div>
    @endforeach
</div>
@endsection