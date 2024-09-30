<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Popups;

class PopupController extends Controller
{
    public function allData(){
        $popups = Popups::Where('status','=',0)->orderBy('id','DESC')->get();
        // dd($popups);
        return view('admin.popups',['popups'=>$popups]);
    }

    public function createPopup(){
        return view('admin.add-popup');
    }

    public function addNew(Request $req){
        $req->validate([
            // 'url'=>'required',
            'image'=>'required',
            'city'=>'required'
        ]);

        $checkPopup = Popups::Where('city',$req->city)->where('status',0)->count();
        if($checkPopup > 0){

            $popup = Popups::Where('city',$req->city)->where('status',0)->orderBy('id','DESC')->first();
            if(isset($req->image)){
                $base64_image         = $req->image;
                list($type, $data)  = explode(';', $base64_image);
                list(, $data)       = explode(',', $data);
                $data               = base64_decode($data);
                $thumb_name         = "thumb_".date('YmdHis').'.png';
                $thumb_path         = public_path("upload/popup/" . $thumb_name);
                file_put_contents($thumb_path, $data);
                $popup->image  = $thumb_name; 
            }
            $popup->city = $req->city;
            $popup->img_url = $req->url;
            $popup->save(); 
        }else{
            $popup = new Popups;
            if(isset($req->image)){
                $base64_image         = $req->image;
                list($type, $data)  = explode(';', $base64_image);
                list(, $data)       = explode(',', $data);
                $data               = base64_decode($data);
                $thumb_name         = "thumb_".date('YmdHis').'.png';
                $thumb_path         = public_path("upload/popup/" . $thumb_name);
                file_put_contents($thumb_path, $data);
                $popup->image  = $thumb_name; 
            }
            $popup->city = $req->city;
            $popup->img_url = $req->url;
            $popup->save();        
        }
        return redirect()->back()->with('success','Popup Added Successfully!!');
    }

    public function destroy($id){
        if(!is_null($id)){
            $popups = Popups::Where('id',$id)->first();
            $popups->status = 1;
            $popups->save();
        }
        return redirect()->back()->with('success','Popup Deleted Successfully!!');
    }

}
