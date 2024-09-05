<div style="
    max-width: 400px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    background-color: #fff;
    margin: 20px auto;
    padding: 16px;
">
    @if($product)
        <h1 style="font-size: 24px; margin-bottom: 8px;">{{ $product->name }}</h1>
        <h2 style="font-size: 20px; color: #333; margin-bottom: 16px;">{{ $product->price }}</h2>
        <div style="display: flex; align-items: center; margin-bottom: 16px;">
            <button wire:click="decrementQuantity"style="
                background-color: #007bff;
                border: none;
                color: #fff;
                padding: 8px 12px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                margin-right: 8px;
            ">-</button>
            <span style="font-size: 18px; margin-right: 8px;">{{ $quantity }}</span>
            <button wire:click="incrementQuantity"style="
                background-color: #007bff;
                border: none;
                color: #fff;
                padding: 8px 12px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            ">+</button>
        </div>
        <button wire:click="addToCart" style="
            background-color: #28a745;
            border: none;
            color: #fff;
            padding: 12px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        ">Add to Cart</button>
        @if (session()->has('message'))
            <div style="
                margin-top: 16px;
                padding: 12px;
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
                border-radius: 4px;
            ">{{ session('message') }}</div>
        @endif
    @else
        <p style="text-align: center; font-size: 18px; color: #888;"Product not found.</p>
    @endif
</div>
