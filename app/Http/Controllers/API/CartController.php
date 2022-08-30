<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function addtocart(Request $request) {
        if (auth('sanctum')->check()) {

            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
            $qty = $request->qty;

            $productCheck = Product::where('id',$product_id)->first();

            if($productCheck) {

                if(Cart::where('product_id', $product_id)->where('user_id', $user_id)->exists()) {
                    return response()->json([
                        'status' => 409,
                        'message' => $productCheck->name. 'Already added to cart',
                    ]);
                }
                else {

                    $cartitem = new Cart;
                    $cartitem->user_id = $user_id;
                    $cartitem->product_id = $product_id;
                    $cartitem->qty = $qty;
                    $cartitem->save();

                    return response()->json([
                        'status' => 201,
                        'message' => 'Product has been added'
                    ]);
                }
            }
            else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Product not Found'
                ]);
            }

           
        }
        else {
            return response()->json([
                'status' => 401,
                'message' => 'login to add to cart'
            ]);
        }
    }
    
    public function viewcart() {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $cartitems = Cart::where('user_id', $user_id)->get();
            return response()->json([
                'status'=> 200,
                'cart'=> $cartitems,
            ]);
        }
        else {
            
            return response()->json([
                'status' => 401,
                'message' => 'login to view cart data'
            ]);
        }
    }

    public function updatequantity($cart_id, $scope) {
        if(auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $cartitem = Cart::where('id', $cart_id)->where('user_id', $user_id)->first();
            
            if ($scope == "inc") {
                
                $cartitem->qty += 1; 
                
            }
            else if ($scope == "dec") {
                
                $cartitem->qty -= 1; 

            }

            $cartitem->update();

            return response()->json([
                'status' => 200,
                'message' => 'Quantity Updated'
            ]);


        }
        else {
            return response()->json([
                'status' => 401,
                'message' => 'login to continue'
            ]);
        }
    }

    public function deleteCartitem ($cart_id) {

        if(auth('sanctum')->check()) {

            $user_id = auth('sanctum')->user()->id;
            $cartitem = Cart::where('id', $cart_id)->where('user_id', $user_id)->first();

            if ($cartitem) {
                $cartitem->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Cart Item removed Successfully.'
                ]);
            }
            else {

                return response()->json([
                    'status' => 404,
                    'message' => 'Cart Item not Found'
                ]);
            }
        }

        else {
            return response()->json([
                'status' => 401,
                'message' => 'login to continue'
            ]);
        }

    }
}
