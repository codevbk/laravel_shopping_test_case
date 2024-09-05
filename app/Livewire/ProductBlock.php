<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

class ProductBlock extends Component
{
    public $product;
    public $quantity = 1;

    public function mount($productId)
    {
        $this->product = Product::find($productId);
    }

    public function addToCart()
    {
        $sessionId = Session::getId();
        $cart = Session::get('cart', []);

        if (isset($cart[$this->product->id])) {
            $cart[$this->product->id]['quantity'] += $this->quantity;
        } else {
            $cart[$this->product->id] = [
                'product' => $this->product,
                'quantity' => $this->quantity
            ];
        }

        Cart::updateOrCreate(
            [
                'session_id' => $sessionId,
                'product_id' => $this->product->id
            ],
            [
                //'quantity' => \DB::raw('quantity + 1')
                'quantity' => \DB::raw($this->quantity)
            ]
        );

        Session::put('cart', $cart);

        $this->quantity = 1;

        session()->flash('message', 'Product has been added to cart.');
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        return view('livewire.product-block');
    }
}
