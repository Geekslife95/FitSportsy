<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Event;
use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Carbon;

class BannerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('banner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $banner = Banner::orderBy('id', 'DESC')->get();

        return view('admin.banner.index', compact('banner'));
    }

    public function create()
    {
        abort_if(Gate::denies('banner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
            'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:3048',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        Banner::create($data);
        return redirect()->route('banner.index')->withStatus(__('Banner has added successfully.'));
    }

    public function edit(Banner $banner)
    {
        abort_if(Gate::denies('banner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            (new AppHelper)->deleteFile($banner->image);
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        $banner = Banner::find($banner->id)->update($data);
        return redirect()->route('banner.index')->withStatus(__('Banner has updated successfully.'));
    }

    public function destroy(Banner $banner)
    {
        try {
            (new AppHelper)->deleteFile($banner->image);
            $banner->delete();
            return true;
        } catch (Throwable $th) {
            return response('Data is Connected with other Data', 400);
        }
    }
}
