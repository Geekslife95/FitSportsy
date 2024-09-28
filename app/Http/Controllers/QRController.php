<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QRController extends Controller
{
    public function organizerCodeScan($userId){
        $date = date("Y-m-d H:i:s");
        $uId = Common::decryptId($userId);
        $categoryData = Event::select('c.name','c.id')
                        ->join('category as c','c.id','category_id')->where(['c.status'=>1,'events.status'=>1,'is_deleted'=>0,'event_status'=>'Pending','user_id'=>$uId])
                        ->where(function($q) use($date){
                            $q->where('end_time', '>', $date)->orWhere('event_type',2);
                        })->groupBy('category_id')->get();
        $userData = User::select('name','first_name','last_name','address')->find($uId);                
        return view('frontend.qr.organizer-code-scan',compact('categoryData','userId','userData'));
    }

    public function getEventsByCategory(Request $request){
        $catId = $request->cat_id;
        $uId = Common::decryptId($request->uId);
        $date = date("Y-m-d H:i:s");
        $eventsData = Event::select('name','temple_name','id')->where(['events.status'=>1,'is_deleted'=>0,'event_status'=>'Pending','user_id'=>$uId,'category_id'=>$catId])
                                                            ->where(function($q) use($date){
                                                                $q->where('end_time', '>', $date)->orWhere('event_type',2);
                                                            })->get();
        return response()->json(['event_data'=>$eventsData,'s'=>1]);                                                    
    }

    public function storeOrnCodeScanSel(Request $request){
        $eventId = $request->event;
        $eventData = Event::select('name')->findorfail($eventId);
        // $inputObj = new \stdClass();
        // $inputObj->params = 'id='.$eventId;
        // $inputObj->url = url('qr-event-details');
        // $encLink = Common::encryptLink($inputObj);
        $link = url('event/'.$eventId.'/'.\Str::slug($eventData->name));
        return redirect($link);
    }

    public function qrEventDetails(){
        $setting = Common::siteGeneralSettings();
        $currency = $setting->currency_sybmol;
        $id = $this->memberObj['id'];
        $data = Event::select('id','category_id','user_id','name','event_type','description','tags','temple_name','address','city_name','recurring_days','start_time','end_time','gallery','image')->with(['category:id,name,image','organization:id,first_name,name,bio,last_name,image'])->find($id);
        if($data->event_type=='Particular'){
            $timezone = $setting->timezone;
            $date = Carbon::now($timezone);
            $data->ticket_data = Ticket::select('name','id','type','description','start_time','end_time','quantity','maximum_checkins','price')->withSum('total_orders','quantity')->where([['event_id', $data->id], ['is_deleted', 0], ['status', 1], ['end_time', '>=', $date->format('Y-m-d H:i:s')], ['start_time', '<=', $date->format('Y-m-d H:i:s')]])->orderBy('id', 'DESC')->get();
        }else{
            $data->ticket_data = Ticket::select('name','id','type','description','start_time','end_time','quantity','maximum_checkins','price')->withSum('total_orders','quantity')->where([['event_id', $data->id], ['is_deleted', 0], ['status', 1]])->orderBy('id', 'DESC')->get();
        }
        $images = explode(",", $data->gallery);
        return view('frontend.qr.qr-event-details', compact('currency', 'data', 'images'));
    }

    public function PrivacyPolicy(){
        return view('frontend.qr.privacy-policy');
    }

}
