<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //direct user home page
    public function home()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        $categories = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();

        return view('user.main.home', compact('products', 'categories', 'cart', 'history'));
    }

    //direct user password change page
    public function passwordChangePage()
    {
        return view('user.account.password.passwordChangePage');
    }

    //direct user account edit page
    public function accountEditPage()
    {
        return view('user.account.infoEditPage');
    }

    //change password
    public function passwordChange(Request $request)
    {
        $validatedPassword = $this->validatePassword($request);                                     //password validation

        $dbOldPassword = User::select('password')->where('id', Auth::user()->id)->first();

        if (!Hash::check($validatedPassword['oldPassword'], $dbOldPassword->password)) {            //checking old and db old password
            return back()->with(['notMatch' => "Your Credential Doesn't Match"]);
        }

        User::where('id', Auth::user()->id)->update([                                               //updating new password to database
            'password' => Hash::make($validatedPassword['newPassword'])
        ]);

        return back()->with(['passwordChanged' => 'Changing Password Success!']);
    }

    //user account edit
    public function accountEdit($adminId, Request $request)
    {
        $arrayData = $this->validateAccountInfo($request);

        if ($request->hasFile('image')) {
            $dbImage = User::where('id', $adminId)->first()->image;

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $arrayData['image'] = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $arrayData['image']);
        }

        User::where('id', $adminId)->update($arrayData);

        return back()->with(['accountUpdate' => 'Account Updated Successfully!']);
    }

    //category filter
    public function categoryFilter($filter_id)
    {
        $products = Product::where('category_id', $filter_id)->orderBy('created_at', 'desc')->get();
        $categories = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();

        return view('user.main.home', compact('products', 'categories', 'cart', 'history'));
    }

    //direct product detail page
    public function productDetailPage($requestedId)
    {
        $requestedProduct = Product::where('id', $requestedId)->first();
        Product::where('id', $requestedId)->update(['view_count' => $requestedProduct->view_count + 1]);
        $products = Product::get();

        return view('user.main.details', compact('requestedProduct', 'products'));
    }

    //direct cart list page
    public function cartList()
    {
        $cartList = Cart::select('carts.*', 'products.name as product_name', 'products.price as product_price', 'products.image as product_image')
            ->where('carts.user_id', Auth::user()->id)
            ->leftJoin('products', 'products.id', 'carts.product_id')
            ->get();

        $subTotal = 0;

        foreach ($cartList as $cartProducts) {
            $subTotal += $cartProducts->qty * $cartProducts->product_price;
        }

        return view('user.main.cart', compact('cartList', 'subTotal'));
    }

    //direct to user's order history page
    public function historyPage()
    {
        $orderData = Order::where('user_id', Auth::user()->id)->paginate('5');
        return view('user.main.history', compact('orderData'));
    }

    //direct to user contact page
    public function contactPage()
    {
        return view('user.main.contact');
    }

    //send message
    public function sentMessage(Request $request)
    {
        if($request->name != Auth::user()->name)
        {
            return redirect()->route('user#contactPage')->with(['messageError' => 'Your Name Must Be Equal To Account Name!']);
        }else if($request->email != Auth::user()->email)
        {
            return redirect()->route('user#contactPage')->with(['messageError' => 'Your Email Must Be Equal To Account Email!']);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];

        Contact::create($data);
        return redirect()->route('user#homepage');
    }


    //password fields validation
    protected function validatePassword(Request $request)
    {
        return $request->validate([
            'oldPassword' => 'required|min:6|max:10',
            'newPassword' => 'required|min:6|max:10',
            'confirmPassword' => 'required|min:6|max:10|same:newPassword'
        ]);
    }

    //user account info validation
    protected function validateAccountInfo(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'image' => 'mimes:jpg,jpeg,png,webp|file',
        ]);
    }
}
