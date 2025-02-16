<?php

namespace App\Http\Controllers;

use App\Facades\FileHandler;
use Illuminate\Http\Request;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories',
                'cover' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:20048'
            ]);
            $cover = $request->cover;
            $coverName = FileHandler::storeFile($cover, null, $cover->getClientOriginalExtension());

            Category::create([
                'name' => $request->name,
                'cover' => $coverName
            ]);

            Alert::success("Success", "Category created successfully");
            return redirect()->route('categories.index');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,id,'.$id,
                'cover' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $category = Category::findOrFail($id);
            if($request->has('cover'))
            {
                $cover = $request->cover;
                $coverName = FileHandler::updateFile($cover, $category->cover, null, $cover->getClientOriginalExtension());
            }else{
                $coverName = $category->cover;
            }


            $category->update([
                'name' => $request->name,
                'cover' => $coverName
            ]);

            Alert::success("Success", "Category updated successfully");
            return redirect()->route('categories.index');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            Alert::success("Success", "Category deleted successfully");
            return redirect()->route('categories.index');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'category_ids' => 'required|array',
                'category_ids.*' => 'exists:categories,id',
            ]);

            Category::whereIn('id', $request->category_ids)->delete();

            Alert::success('Success', 'Selected categories have been deleted successfully');
            return redirect()->route('categories.index');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete categories: ' . $e->getMessage());
        }
    }

}
