<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
// use Stripe\Stripe;
use Stripe;

class StripePaymentController extends Controller
{
//     //write code for API
//     public function stripePost(Request $request){
//         try{
//             $stripe=new \Stripe\StripeClient(
//                 env('STRIPE_SECRET')
//             );
//             $res=$stripe->tokens->create([
//                 'card'=>[
//                     'number'=>$request->number,
//                     'exp_month'=>$request->exp_number,
//                     'exp_year'=>$request->exp_year,
//                     'cvc'=>$request->cvc,
//                 ],
//             ]);

//             stripe\stripe::setApiKey(env('STRIPE_SECRET '));

//             $responce = $stripe->charges->create([
//                 'amount'=>$request->amount,
//                 'currency'=>'usd',
//                 'source'=>$res->id,
//                 'description'=>$request->description,
//             ]);
//             return response()->json([$responce->status], 201);
//         }
//         catch(Exception $ex){
//             return response()->json(['response'=>'Error'], 500);
//         }
//     }
// }
public function form(){
    return view('stripe.form');
}
public function makePayment(Request $request){
    $input = $request->all();

    \Stripe\Stripe::setApiKey('sk_test_51M6paYE2HXRmYqRHXXa8EACBYeTFdjlL55RbkkqB1GVadfWdXTwAVLcTlHBMSgVqVXb1jnINtUsZrTJgACXmJPPe00MOrg0OsX');
    $charge = \Stripe\Charge::create([
        'source' => $_POST['stripeToken'],
        'description' => "10 cucumbers from roger's Farm",
        'amount' => 1000,
        'currency' => 'usd'
    ]);
    if($charge->status == 'succeeded'){
        return redirect()->route('form.payment')->with('message', 'Payment done Successfully');
    }
}
}
