<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.event-gallery.upload-gallery');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event-gallery.upload-gallery');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());
        if($request->has('event_gallery')){
            $base64_image         = $request->event_gallery;
            list($type, $data)  = explode(';', $base64_image);
            list(, $data)       = explode(',', $data);
            $data               = base64_decode($data);
            $thumb_name         = "thumb_".date('YmdHis').'.png';
            $thumb_path         = public_path("/images/upload/" . $thumb_name);
            file_put_contents($thumb_path, $data);

            if(Auth::user()->hasRole('Organizer')){
                $user = Auth::user()->id;
            }else{
                $user = null;
            }

            $gallery = new EventGallery;
            $gallery->image = $thumb_name;
            $gallery->user_id = $user;
            $gallery->created_at =date("Y-m-d H:i:s");
            $gallery->updated_at = date("Y-m-d H:i:s");
            $gallery->save();
        }
        return redirect('upload-gallery')->with('success','Event gallery has added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
