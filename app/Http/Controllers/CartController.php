<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $subtotal = 0.00;
    protected $taxes = 0.00;
    protected $taxRate = 20.00;
    protected $discount = 0.00;
    protected $subtotalAfterDiscount = 0.00;
    protected $total = 0.00;
    protected $minimumCartTotal = 100.00;
    protected $minimumCartError = false;

    public function index(){
        $sessionId = Session::getId();
        $carts = Cart::where('session_id', $sessionId)->get();
        //dd($carts);

        $this->updateCartTotals();

        return view('cart', ['carts' => $carts, 'subtotal' => $this->subtotal, 'taxes' => $this->taxes, 'discount' => $this->discount, 'subtotalAfterDiscount' => $this->subtotalAfterDiscount, 'total' => $this->total]);

    }

    public function removeItem($id)
    {
        $sessionId = Session::getId();
        $cartItem = Cart::where('session_id', $sessionId)->where('product_id', $id)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        $this->removeCoupon();

        $this->updateCartTotals();

        return redirect()->route('cart.index')->with('success', 'Product '.$id.' Removed');
    }

    public function removeCoupon(){
        session()->remove('cart_subtotal');
        session()->remove('cart_taxes');
        session()->remove('cart_total');
        session()->remove('cart_coupon_code');
        session()->remove('cart_coupon_type');
        session()->remove('cart_discount');
        session()->remove('cart_subtotal_after_discount');
        session()->remove('cart_taxes_after_discount');
        session()->remove('cart_total_after_discount');
        session()->remove('discounted_products');
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        if($couponCode){
            $coupon = Coupon::where('code', $couponCode)->first();

            if (!$coupon) {
                return back()->withErrors(['message' => 'Invalid coupon code', 'errorCouponCode' => true]);
            }
    
            //$cart = session()->get('cart'); 
            $sessionId = Session::getId();
            $carts = Cart::where('session_id', $sessionId)->get();
            $this->removeCoupon();
            session()->put('cart_coupon_code', $couponCode);
            $this->updateCartTotals();
    
            //return view('cart', ['discount' => $this->discount, 'total' => $this->total]);
            return back()->with(['message', 'Coupon Applied']);
            //return back()->with(['success' => 'Coupon Applied', 'cart_subtotal_after_discount' => $subtotalAfterDiscount, 'cart_discount' => $coupon->discount, 'cart_coupon_code' => $couponCode]);
        }else{
            return back()->withErrors(['message' => 'Coupon code is required.']);
        }
        
    }

    
    private function updateCartTotals()
    {
        $sessionId = Session::getId();
        $carts = Cart::where('session_id', $sessionId)->get();
        
        foreach ($carts as $cart) {
            $this->subtotal += $cart->product->price * $cart->quantity;
        }

        $this->taxes = $this->subtotal * 0.20; 
        $this->total += $this->subtotal + $this->taxes;

        session()->put('cart_subtotal', $this->subtotal);
        session()->put('cart_taxes', $this->taxes);
        session()->put('cart_total', $this->total);

        $couponCode = session()->get('cart_coupon_code', 0);
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->status === 'active' && $coupon->expired_at > now()) {

                if($coupon->type === 'total'){
                    $this->discount = $coupon->discount;
                    $subtotalAfterDiscount = $coupon->applyDiscount($this->subtotal);
                    $taxes = $subtotalAfterDiscount * 0.20; 
                    $total = $subtotalAfterDiscount + $taxes;
                   
                    session()->put('cart_coupon_type', $coupon->discount_type);
                    session()->put('cart_discount', $coupon->discount);
                    session()->put('cart_subtotal_after_discount', $subtotalAfterDiscount);
                    session()->put('cart_taxes_after_discount', $taxes);
                    session()->put('cart_total_after_discount', $total);
                    session()->save();

                    if ($this->total < $this->minimumCartTotal) {
                        $this->minimumCartError = true;
                        return back()->withErrors(['message' => 'Total less than the minimum basket amount', 'minimumCartError' => true]);
                    }
                }

                if($coupon->type === 'eligible'){
                    $eligibleProductIds = $coupon->products->pluck('id')->toArray();
                    //dd($eligibleProductIds);
                    $subtotal = 0;
                    $discountSubtotalAmount = 0;
                    $discountedProducts = [];
                    foreach ($carts as $cart) {
                        if (in_array($cart->product_id, $eligibleProductIds)) {
                            if ($coupon->discount_type == 'fixed') {
                                $discountAmount = $coupon->discount;
                            }
                            if ($coupon->discount_type == 'percent') {
                                $discountAmount = ($cart->product->price * $cart->quantity) * ($coupon->discount / 100);
                            }
                            $discounted_price = max(0, ($cart->product->price * $cart->quantity) - $discountAmount);
                            $discountSubtotalAmount += max(0, ($cart->product->price * $cart->quantity) - $discountAmount);
                            //dd($cart->product->price,$discountAmount,$cart->product->price - $discountAmount);
                            $discountedProducts[] = [
                                'product_id' => $cart->product_id,
                                'product_name' => $cart->product->name,
                                'product_price' => $cart->product->price,
                                'quantity' => $cart->quantity,
                                'discount' => $discountAmount,
                                'discounted_price' => $discounted_price
                            ];
                            //dd($discountedProducts);
                        }else{
                            $subtotal += $cart->product->price * $cart->quantity;
                        }
                        
                        
                    }

                    $subtotalAfterDiscount = $subtotal + $discountSubtotalAmount;
                    //dd($subtotalAfterDiscount);
                    $taxes = $subtotalAfterDiscount * 0.20;
                    $total = $subtotalAfterDiscount + $taxes;
                    session()->put('cart_coupon_type', $coupon->discount_type);
                    session()->put('cart_discount', $coupon->discount);
                    session()->put('cart_subtotal_after_discount', $subtotalAfterDiscount);
                    session()->put('cart_taxes_after_discount', $taxes);
                    session()->put('cart_total_after_discount', $total);
                    session()->put('discounted_products', $discountedProducts);
                    session()->save();
                }
                
                if($coupon->type === 'equal'){
                    $subtotal = 0;
                    $discountSubtotalAmount = 0;
                    $discountedProducts = [];
                    foreach ($carts as $cart) {
                        if ($coupon->discount_type == 'fixed') {
                            $discountAmount = $coupon->discount;
                        }
                        if ($coupon->discount_type == 'percent') {
                            $discountAmount = $cart->product->price * ($coupon->discount / 100);
                        }
                        $discounted_price = max(0, ($cart->product->price * $cart->quantity) - $discountAmount);
                        $discountSubtotalAmount += max(0, ($cart->product->price * $cart->quantity) - $discountAmount);
                        $discountedProducts[] = [
                            'product_id' => $cart->product_id,
                            'product_name' => $cart->product->name,
                            'product_price' => $cart->product->price,
                            'quantity' => $cart->quantity,
                            'discount' => $discountAmount,
                            'discounted_price' => $discounted_price
                        ];
                    }
                    $subtotalAfterDiscount = $subtotal + $discountSubtotalAmount;
                    //dd($subtotalAfterDiscount);
                    $taxes = $subtotalAfterDiscount * 0.20;
                    $total = $subtotalAfterDiscount + $taxes;
                    session()->put('cart_coupon_type', $coupon->discount_type);
                    session()->put('cart_discount', $coupon->discount);
                    session()->put('cart_subtotal_after_discount', $subtotalAfterDiscount);
                    session()->put('cart_taxes_after_discount', $taxes);
                    session()->put('cart_total_after_discount', $total);
                    session()->put('discounted_products', $discountedProducts);
                    session()->save();
                }

                if($coupon->type === 'tax'){
                    
                    //$taxRate
                    //$coupon->discount = 30;
                    $taxesRate = $coupon->discount - $this->taxRate;
                    $taxesRate = abs($taxesRate);
                    //dd(($taxesRate / 100));
                    $subtotalAfterDiscount = $this->subtotal;
                    
                    $taxes = $subtotalAfterDiscount * ($taxesRate / 100); 
                    //dd($taxes);
                    $total = $subtotalAfterDiscount - $taxes;
                    session()->put('cart_coupon_type', $coupon->discount_type);
                    session()->put('cart_discount', $coupon->discount);
                    session()->put('cart_subtotal_after_discount', $subtotalAfterDiscount);
                    session()->put('cart_taxes_after_discount', $taxes);
                    session()->put('cart_total_after_discount', $total);
                    session()->save();
                }

                if($coupon->type === 'required'){
                    
                }
            }else{
                return back()->withErrors(['message' => 'Invalid coupon code', 'errorCouponCode' => true]);
            }
        }

       
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to place an order.');
        }

        $user = Auth::user();

        $sessionId = Session::getId();
        $sessionExists = DB::table('sessions')->where('id', $sessionId)->where('user_id', $user->id)->exists();

        //dd($sessionExists);
        if ($sessionExists) {
            $carts = Cart::where('session_id', $sessionId)->get();

            $cartSubtotal = session()->get('cart_subtotal', 0);
            $cartTaxes = session()->get('cart_taxes', 0);
            $cartTotal = session()->get('cart_total', 0);

            if ($cartTotal < $this->minimumCartTotal) {
                $this->minimumCartError = true;
                return back()->withErrors(['message' => 'Total less than the minimum basket amount', 'minimumCartError' => true]);
            }

            $cartCouponCode = session()->get('cart_coupon_code', 0);

            $couponId = null;
            $cartDiscount = 0;
            $cartSubtotalAfterDiscount = 0;
            $cartTaxesAfterDiscount = 0;
            $cartTotalAfterDiscount = 0;

            //dd($cartCouponCode);
            if($cartCouponCode){
                $couponData = DB::table('coupons')->where('code', $cartCouponCode)->first();
                if ($couponData && $couponData->status === 'active' && $couponData->expired_at > now()) {
                    $couponUser = DB::table('coupon_user')
                            ->where('coupon_id', $couponData->id)
                            ->where('user_id', $user->id)
                            ->first();
                    if ($couponUser && $couponUser->quantity > 0) {
                        $couponId = $couponData->id;
                        $cartDiscount = session()->get('cart_discount', 0);
                        //dd($cartDiscount);
                        $cartSubtotalAfterDiscount = session()->get('cart_subtotal_after_discount', 0);
                        $cartTaxesAfterDiscount = session()->get('cart_taxes_after_discount', 0);
                        $cartTotalAfterDiscount = session()->get('cart_total_after_discount', 0);
                        DB::table('coupon_user')
                            ->where('coupon_id', $couponData->id)
                            ->where('user_id', $user->id)
                            ->decrement('quantity');
                        
                    }else {
                        return back()->withErrors([
                            'message' => 'This coupon is not applicable for your account or has already been used.',
                            'couponError' => true
                        ]);
                    }
                    
                }
            }
            //dd($cartDiscount);
            
            //$cartItems = Cart::where('user_id', $user->id)->get();
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $cartSubtotal,
                'taxes' => $cartTaxes,
                'total' => $cartTotal,
                'coupon_id' => $couponId,
                'discount' => $cartDiscount,
                'subtotal_after_discount' => $cartSubtotalAfterDiscount,
                'taxes_after_discount' => $cartTaxesAfterDiscount,
                'total_after_discount' => $cartTotalAfterDiscount,
                'status' => 'pending', 
            ]);

            foreach ($carts as $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price 
                ]);
            }

            Cart::where('session_id', $sessionId)->delete();
            return redirect()->route('order.success', ['order_id' => $order->order_id,'order_status' => $order->status]);
            //return redirect()->route('cart.index')->with('success', 'Order placed successfully.');
        }

        
    }


    public function showCart()
    {
        $cart = session()->get('cart');

        if (!$cart) {
            $cart = (object)[
                'items' => [],
                'total' => 0,
            ];
        }

        $subtotal = $cart->total;
        $taxes = $subtotal * 0.20;
        $discount = session()->get('cart_discount', 0);
        $subtotalAfterDiscount = max(0, $subtotal - $discount);
        $total = $subtotalAfterDiscount + $taxes;

        return view('cart.index', compact('cart', 'subtotal', 'taxes', 'discount', 'subtotalAfterDiscount', 'total'));
    }
}
