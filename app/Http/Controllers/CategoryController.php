<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CategoryController extends Controller
{
    //direct list page
    public function listPage(Request $request)
    {
        $categoryData = DB::table('categories')->when($request->searchData, function ($query) {
            $query->where('name', 'like', '%' . request('searchData') . '%');
        })->orderBy('id', 'desc')
            ->paginate(5);

        $categoryData->appends(request()->all());
        return view('admin.category.list', compact('categoryData'));
    }

    //direct create page
    public function createPage()
    {
        return view('admin.category.categorycreate');
    }

    //create category
    public function createCategory(Request $request)
    {
        $this->validateCategory($request);
        $data = $this->changeArray($request);
        Category::create($data);
        return redirect()->route('category#listPage')->with(['createdCategory' => 'You Created Category Successfully!']);
    }

    //delete category
    public function deleteCategory($delete_id)
    {
        if ($delete_id != 0 || $delete_id != null) {
            Category::where('id', $delete_id)->delete();
            return back()->with(['deletedCategory' => 'You Deleted Category Successfully!']);
        };
    }

    //edit category
    public function editCategory($edit_id)
    {
        $categoryData = DB::table('categories')->where('id', $edit_id)->first();
        return view('admin.category.editpage', compact('categoryData'));
    }

    //update category
    public function updateCategory(Request $request)
    {
        $this->validateCategory($request);
        $data = $this->changeArray($request);
        Category::where('id', $request->categoryId)->update($data);
        return redirect()->route('category#listPage');
    }

    //validate category data
    protected function validateCategory(Request $request)
    {
        return $request->validate([
            'categoryName' => 'required|min:4|unique:categories,name,' . $request->categoryId
        ]);
    }

    //change to array
    protected function changeArray(Request $request)
    {
        return [
            'name' => $request->categoryName
        ];
    }
}
