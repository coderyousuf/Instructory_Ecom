<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Billing;
use App\Models\Upazila;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Models\OrderDetails;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function checkoutPage(){
        $carts=Cart::content();
        $total_price=Cart::subtotal();
        $districts=District::select('id', 'name', 'bn_name')->get();
        return view('frontend.pages.checkout', compact('carts', 'total_price', 'districts'));
    }

    public function loadUpazillaAjax($district_id){
        $upazilas=Upazila::where('district_id', $district_id)->select('id','name')->get();
        return response()->json($upazilas, 200);
    }

    public function placeOrder(OrderStoreRequest $request){
        // dd($request->all());
        $billing=Billing::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone_number'=>$request->phone,
            'district_id'=>$request->district_id,
            'upazila_id'=>$request->upazila_id,
            'address'=>$request->address,
            'order_notes'=>$request->order_notes,
        ]);

        $order=Order::create([
            'user_id'=>Auth::id(),
            'billing_id'=>$billing->id,
            'sub_total'=>Session::get('coupon')['cart_total'] ?? round(Cart::subtotalFloat()),
            'discount_amount'=>Session::get('coupon')['discount_amount'] ?? 0,
            'coupon_name'=>Session::get('coupon')['name'] ?? '',
            'total'=>Session::get('coupon')['balance'] ?? round(Cart::subtotalFloat()),
        ]);

        foreach(Cart::content() as $cart_item){
            OrderDetails::create([
                'order_id'=>$order->id,
                'user_id'=>Auth::id(),
                'product_id'=>$cart_item->id,
                'product_qty'=>$cart_item->qty,
                'product_price'=>$cart_item->price,
            ]);
            Product::findOrFail($cart_item->id)->decrement('product_stock', $cart_item->qty);

        }
        Cart::destroy();
        Session::forget('coupon');

        Toastr::success('Your order Placed successfully!!!!!', 'Success');
        return redirect()->route('cart.page');
    }
}
