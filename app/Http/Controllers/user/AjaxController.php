<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //sorting product list
    public function productList(Request $request)
    {
        if ($request->order == 'ascending') {
            $data = Product::orderBy('created_at', 'asc')->get();
        } else {
            $data = Product::orderBy('created_at', 'desc')->get();
        }

        return $data;
    }

    //add products to cart
    public function addToCart(Request $request)
    {
        $arrayData = $this->getArrayData($request);
        Cart::create($arrayData);
        $responseMessage = [
            'status' => 'success',
        ];
        return response()->json($responseMessage, 200);
    }

    //put data to order list
    public function listOrder(Request $request)
    {
        $totalPrice = 0;

        for ($i = 0; $i < count($request->toArray()); $i++)
        {
            OrderList::create($request[$i]);
            $totalPrice += $request[$i]['total'];
        }

        Order::create($this->getOrderArray($request,$totalPrice));

        Cart::where('user_id',Auth::user()->id)->delete();

        return response()->json(['status'=>'success'],200);
    }

    //remove cart item
    public function removeCartItem(Request $request)
    {
        Cart::where('id',$request->cartId)->delete();
    }

    //clear cart data
    public function clearCart()
    {
        Cart::where('user_id',Auth::user()->id)->delete();
    }

    //get array data for database upload
    protected function getArrayData(Request $request)
    {
        return [
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->orderCount
        ];
    }

    //get array data for orders table
    protected function getOrderArray(Request $request,$totalPrice)
    {
        return [
            'user_id' => Auth::user()->id,
            'order_code' => $request[0]['order_code'],
            'total_price' => $totalPrice+3000,
        ];
    }
}
