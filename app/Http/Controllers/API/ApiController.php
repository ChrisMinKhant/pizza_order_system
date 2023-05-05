<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class ApiController extends Controller
{
    //get all users -> api call with id
    public function getAllUsersWithId($requestedId)
    {
        $data = User::where('id', $requestedId)->get();

        if (!$data->isEmpty()) {
            return response()->json($data, 200);
        } else {
            return response()->json($data, 204);
        }
    }

    //get all users -> api call without id
    public function getAllUsersWithoutId()
    {
        $data = User::get();
        return response()->json($data, 200);
    }

    //get all categories -> api call without id
    public function getAllCategoriesWithoutId()
    {
        $data = Category::get();
        return response()->json($data, 200);
    }

    //get all categories -> api call without id
    public function getAllCategoriesWithId($requestedId)
    {
        $data = Category::where('id', $requestedId)->get();
        if (!$data->isEmpty()) {
            return response()->json($data, 200);
        } else {
            return response()->json($data, 204);
        }
    }

    //get all products -> api call without id
    public function getAllProductsWithoutId()
    {
        $data = Product::get();
        return response()->json($data, 200);
    }

    //get all products -> api call without id
    public function getAllProductsWithId($requestedId)
    {
        $data = Product::where('id', $requestedId)->get();
        if (!$data->isEmpty()) {
            return response()->json($data, 200);
        } else {
            return response()->json($data, 204);
        }
    }

    //get all contacts -> api call without id
    public function getAllContactsWithoutId()
    {
        $data = Contact::get();
        return response()->json($data, 200);
    }

    //get all contacts -> api call without id
    public function getAllContactsWithId($requestedId)
    {
        $data = Contact::where('id', $requestedId)->get();
        if (!$data->isEmpty()) {
            return response()->json($data, 200);
        } else {
            return response()->json($data, 204);
        }
    }

    //create new category
    public function createCategory(Request $request)
    {
        Category::create([
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $data = Category::get();

        return response()->json(['status' => 'Cateogry Created!', 'Categories' => $data], 200);
    }

    //update category
    public function updateCategory(Request $request, $requestedId)
    {
        $data = Category::where('id', $requestedId)->get();

        if (!$data->isEmpty()) {

            Category::where('id', $requestedId)->update(['name' => $request->name]);
            $data = Category::get();

            return response()->json(['status' => 'Category Updated!', 'Categories' => $data], 200);

        } else {
            return response()->json($data, 204);
        }
    }

    //delete category
    public function deleteCategory($requestedId)
    {
        $data = Category::where('id', $requestedId)->get();

        if (!$data->isEmpty()) {

            Category::where('id', $requestedId)->delete();
            $data = Category::get();

            return response()->json(['status' => 'Category Updated!', 'Categories' => $data], 200);

        } else {
            return response()->json($data, 204);
        }
    }
}
