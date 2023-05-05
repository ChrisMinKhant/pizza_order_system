<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //direct to order list page
    public function orderListPage()
    {
        $orderListData = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->orderBy('created_at','desc')
            ->get();

        return view('admin.order.list', compact('orderListData'));
    }

    //search with status
    public function searchWithStatus(Request $request)
    {
        $orderListData = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', 'orders.user_id');

        if ($request->searchWithStatus == null) {
            $orderListData = $orderListData->get();
        } else {
            $orderListData = $orderListData->where('orders.status', $request->searchWithStatus)->get();
        }

        return view('admin.order.list', compact('orderListData'));
    }

    //search data (form)
    public function searchData(Request $request)
    {
        $orderListData = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->orWhere('users.name', 'like', '%' . $request->searchData . '%')
            ->orWhere('orders.order_code', 'like', '%' . $request->searchData . '%')
            ->get();
        //ID,Total Price and Date Left

        return view('admin.order.list', compact('orderListData'));
    }

    //change order status
    public function changeOrderStatus(Request $request)
    {
        Order::where('id', $request->order_id)->update(['status' => $request->order_status]);
    }

    //product list through order code
    public function productList($orderCode)
    {
        $orders = Order::where('order_code',$orderCode)->first();
        $productListData = OrderList::select('order_lists.*', 'products.name as product_name', 'products.image as product_image','users.name as user_name', 'users.id as user_id')
            ->leftJoin('products', 'products.id', 'order_lists.product_id')
            ->leftJoin('users','users.id','order_lists.user_id')
            ->where('order_code', $orderCode)
            ->get();

        return view('admin.order.productlist', compact(['productListData','orders']));
    }
}
