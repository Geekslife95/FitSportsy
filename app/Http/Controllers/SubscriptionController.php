<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Auth,Common;

class SubscriptionController extends Controller
{
    public function createSubscription(){
        if(Auth::check()){
            return view('admin.subscription.create');
        }
        return redirect('/login');
    }

    public function postcreateSubscription(Request $req){
        $req->validate([
            'title'=>'required',
            'services'=>'required',
            'sub_price'=>'required',
            'sub_type'=>'required',
            'sub_duration'=>'required',
            'status'=>'required'
        ]);


        $subscription = new Subscription;
        $subscription->title = $req->title;
        $subscription->services = json_encode($req->services);
        $subscription->price = $req->sub_price;
        $subscription->duration = $req->sub_duration;
        $subscription->type = $req->sub_type;
        $subscription->status = $req->status;
        $subscription->save();

        return redirect('/admin/view-subscription')->with('success','Subscription Added Successfully');

    }

    public function editSubscription(Request $req){
        if(Auth::check()){
            $subId = Common::decryptLink($req->eq);
            $subDeatils = Subscription::Where('id',$subId['id'])->first();
            return view('admin.subscription.edit',compact('subDeatils'));
        }
        return redirect('/login');
    }

    public function posteditSubscription(Request $req){

        $req->validate([
            'title'=>'required',
            'services'=>'required',
            'sub_price'=>'required',
            'sub_type'=>'required',
            'sub_duration'=>'required',
            'status'=>'required'
        ]);

        $subId = Common::decryptLink($req->eq);
        $subscription = Subscription::WHERE('id',$subId['id'])->first();
        $subscription->title = $req->title;
        $subscription->services = json_encode($req->services);
        $subscription->price = $req->sub_price;
        $subscription->duration = $req->sub_duration;
        $subscription->type = $req->sub_type;
        $subscription->status = $req->status;
        $subscription->save();

        return redirect('/admin/view-subscription')->with('success','Subscription Added Successfully');

    }

    public function viewAllSubscription(){
        if(Auth::check()){
            $subscription = Subscription::orderBy('id','DESC')->get();
            return view('admin.subscription.view',compact('subscription'));
        }
        return redirect('/login');
    }

    public function updateStatusSubscription(Request $req){
        $subId = Common::decryptLink($req->eq);
        $subscription = Subscription::Where('id',$subId['id'])->first();
        if($subscription->status == 1){
            $subscription->status = 0;
        }else{
            $subscription->status = 1;
        }
        $subscription->save();
        return redirect()->back()->with('success','Status Updated Successfully');
    }

}
