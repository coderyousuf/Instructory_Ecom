<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function cartPage(){
        $carts=Cart::content();
        $total_price=Cart::subtotal();
        // return $carts;

        return view('frontend.pages.shopping-cart', compact('carts', 'total_price'));
    }

    Public function addToCart(Request $request){
        // dd($request->all());
        $product_slug=$request->product_slug;
        $order_qty=$request->order_qty;

        $product=Product::whereSlug($product_slug)->first();

        Cart::add([
            'id'=>$product->id,
            'name'=>$product->name,
            'price'=>$product->product_price,
            'weight'=>0,
            'product_stock'=>$product->product_stock,
            'qty'=>$order_qty,
            'options'=>[
                'product_image'=>$product->product_image
            ]
            ]);
            Toastr::success('Product Added in to cart');
            return back();
    }

    public function removeFromCart($cart_id){
        // dd($cart_id);
        Cart::remove($cart_id);
        Toastr::info('Product Removed from Cart');
        return back();
    }

    public function couponApply(Request $request){
        if(!Auth::check()){
            Toastr::error('You must need to login first!!!');
            return redirect()->route('login.page');
        }
        $check=Coupon::where('coupon_name', $request->coupon_name)->first();
        // dd($check);
        // check coupon validity

        //if session got existing coupon, then don't allow double coupon
        if(Session::get('coupon')){
            Toastr::error('Already applied coupon!!!', 'info!!!');
            return redirect()->back();
        }
        if($check !=null){
            $check_validity=$check->validity_till > Carbon::now()->format('Y-m-d');
            // dd($check_validity);
            // if($check_validity){
            //     Session::put('coupon', [
            //         'name'=>$check->coupon_name,
            //         'discount_amount'=>(Cart::subtotal() * $check->discount_amount)/100,
            //         'cart_total'=>Cart::subtotal(),
            //         'balance'=>Cart::subtotal() - (Cart::subtotal() * $check->discount_amount)/100
            //     ]);
            if($check_validity){
            Session::put('coupon', [
                'name' => $check->coupon_name,
                'discount_amount' => round((Cart::subtotalFloat() * $check->discount_amount)/100),
                'cart_total' => Cart::subtotalFloat(),
                'balance' => round(Cart::subtotalFloat() - (Cart::subtotalFloat() * $check->discount_amount)/100)
            ]);
                Toastr::success('Coupon Fixed Applied!!', 'Successfully!!');
                return redirect()->back();
            }else{
                Toastr::error('Coupon Date Expire!!!', 'Info!!!');
                return redirect()->back();
            }
        }else{
            Toastr::error('Invalid Action! Check, Empty Cart');
            return redirect()->back();
        }
    }

    public function removeCoupon($coupon_name){
        Session::forget('coupon');
        Toastr::success('Coupon Removed', 'Successfully!!!');
        return redirect()->back();
    }
}

//inmage insert crud in laravel?
