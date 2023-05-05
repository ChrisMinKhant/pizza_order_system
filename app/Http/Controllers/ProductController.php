<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //direct product list page
    public function productListPage()
    {
        $productData = Product::select('products.*', 'categories.name as category_name')
            ->when(request('searchData'), function ($query) {
                $query->where('products.name', 'like', '%' . request('searchData') . '%');
            })
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->orderBy('products.created_at', 'desc')
            ->paginate(3);

        $productData->appends(request()->all());
        return view('admin.product.productlist', compact('productData'));
    }

    //direct product create page
    public function productCreatePage()
    {
        $categoryData = Category::select('id', 'name')->get();
        return view('admin.product.productcreate', compact('categoryData'));
    }

    //create product
    public function productCreate(Request $request)
    {
        $this->validateProductData($request, "create");
        $requestedData = $this->requestData($request);

        $imageName = uniqid() . $request->file('productImage')->getClientOriginalName();
        $request->file('productImage')->storeAs('public', $imageName);
        $requestedData['image'] = $imageName;

        Product::create($requestedData);

        return redirect()->route('admin#product#listPage');
    }

    //delete product
    public function deleteProduct($productId)
    {
        Product::where('id', $productId)->delete();
        return redirect()->route('admin#product#listPage');
    }

    //direct product detail page
    public function productDetailPage($productId)
    {
        $productData = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $productId)->first();
        return view('admin.product.productedit', compact('productData'));
    }

    //direct product edit page
    public function productEditPage($productId)
    {
        $productData = Product::where('id', $productId)->first();
        $categoryData = Category::get();

        return view('admin.product.productupdate', compact('productData', 'categoryData'));
    }

    //product update
    public function productUpdate(Request $request)
    {
        $this->validateProductData($request, "update");
        $dataRequest = $this->requestData($request);

        if ($request->hasFile('productImage')) {
            $dbImage = Product::select('image')->where('id', $request->productId)->first();
            Storage::delete('public/' . $dbImage['image']);

            $requestedImage = uniqid() . $request->file('productImage')->getClientOriginalName();
            $request->file('productImage')->storeAs('public', $requestedImage);
            $dataRequest['image'] = $requestedImage;
        }

        Product::where('id', $request->productId)->update($dataRequest);

        return redirect()->route('admin#product#listPage');
    }

    //build up data for database
    protected function requestData(Request $request)
    {
        return [
            'category_id' => $request->productCategory,
            'name' => $request->productName,
            'description' => $request->productDescription,
            'waiting_time' => $request->productWaitingTime,
            'price' => $request->productPrice,
        ];
    }

    //validate product data
    protected function validateProductData(Request $request, $status)
    {
        $validationRules = [
            'productName' => 'required|min:5|unique:products,name,' . $request->productId,
            'productCategory' => 'required',
            'productDescription' => 'required|min:10',
            'productWaitingTime' => 'required',
            'productPrice' => 'required|min:4'
        ];

        $validationRules['productImage'] = $status == "create" ? 'required|mimes:png,jpg,jpeg,webp,jfif' : 'mimes:png,jpg,jpeg,webp,jfif';

        return $request->validate($validationRules);
    }
}
