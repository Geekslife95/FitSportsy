<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category = Category::OrderBy('id','DESC')->get();
        return view('admin.category.index', compact('category'));
    }

    public function create()
    {
        abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->all();
        $slug = \Str::slug($request->name, '-');
        if ($request->hasFile('image')) {
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = (new AppHelper)->saveImage($request);
        }
        $data['slug'] = $slug;
        $data['benefits'] = $request->benefits;
        Category::create( $data);
        \Cache::forget('event-categories');
        return redirect()->route('category.index')->withStatus(__('Category has added successfully.'));
    }

    public function edit(Category $category)
    {
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.category.edit', compact( 'category'));
    }

    public function update(Request $request, Category $category)
    {

        $request->validate([
            'name' => 'bail|required',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            (new AppHelper)->deleteFile($category->image);
            $data['image'] = (new AppHelper)->saveImage($request);
        }

        if ($request->hasFile('banner_image')) {
            if($category->banner_image!=null){
                (new AppHelper)->deleteFile($category->banner_image);
            }
            $image = $request->file('banner_image');
            $name = time().'-'.uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['banner_image'] = $name;
        }
        $data['benefits'] = $request->benefits;
        Category::find($category->id)->update( $data);
        \Cache::forget('event-categories');
        return redirect()->route('category.index')->withStatus(__('Category has updated successfully.'));
    }

}
