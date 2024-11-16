<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\AppHelper;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\City;
use App\Models\Event;
use App\Models\EventDescription;
use App\Models\EventParent;
use App\Models\EventGallery;
use App\Models\TempEvent;
use App\Models\Ticket;
use App\Models\Subscription;
use App\Models\UserEventSubscription;
use Session,Common;

class EventDashboard extends Controller
{
    public function dashboard(){
        // $userid = Auth::id();
        // $checkEvent = TempEvent::Where('user_id',$userid)->where('status',0)->orderBy('id','DESC')->first();
        // if($checkEvent != NULL){
        //     if($checkEvent->step_count == 2){
        //         return redirect('/dashboard-event-location');
        //     }else if($checkEvent->step_count == 3){
        //         return redirect('/dashboard-event-description');
        //     }else if($checkEvent->step_count == 4){
        //         return redirect('/dashboard-event-photos');
        //     }else if($checkEvent->step_count == 5){
        //         return redirect('/dashboard-add-ticket');
        //     }
        // }
        // return redirect('/dashboard');
        return view('eventDashboard.dashboard');
    }

    public function dashboardEvents(Request $req){
     
        try{
            $urlVar = $req->eq;
            $eventType = Common::decryptLink($urlVar);
        }catch(\Exception $e){
            return redirect('dashboard');
        }
        
        $userid = Auth::id();
        $checkEvent = TempEvent::Where('user_id',$userid)->where('status',0)->orderBy('id','DESC')->first();
        if($checkEvent != NULL){
            abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $category = Category::where('status', 1)->orderBy('id', 'DESC')->get();
            $users = [];
            if (Auth::user()->hasRole('admin')) {
                $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
                $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
            } else if (Auth::user()->hasRole('Organizer')) {
                $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            }
            return view('eventDashboard.event.events',compact('category', 'users', 'scanner','checkEvent'));
        }
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category = Category::where('status', 1)->orderBy('id', 'DESC')->get();
        $users = [];
        if (Auth::user()->hasRole('admin')) {
            $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
            $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
        } else if (Auth::user()->hasRole('Organizer')) {
            $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        return view('eventDashboard.event.events',compact('category', 'users', 'scanner'));
    }

    public function postdashboardEvents(Request $req){
       
       
        $req->validate([
            'category_id'=>'required',
            'event_name'=>'required',
            'event_type'=>'required',
            'status'=>'required',
            // 'organizer_id'=>'required',
        ],[
            'category_id.required'=>'Category Field is required',
            'event_name.required'=>'Coaching Title Field is required',
            'event_type.required'=>'Event Type Field is required',
            // 'organizer_id.required'=>'Organiser Field is required',
            'status.required'=>'Status Field is required',
        ]);
        $eventType = Common::decryptLink($req->eq);
        $userId = Auth::id();
        $checkPreviousData = TempEvent::Where('user_id',$userId)->where('status',0)->orderBy('id','DESC')->first();
       
        if($checkPreviousData != NULL){ 
            $days = null;
            $slotArr = null;
            $startTime = $req->start_time;
            $endTime = $req->end_time;
            if($req->event_type==2){
                if(!empty($req->days)){
                    $days = implode(",",$req->days);
                }
                if(!empty($req->slot_start)){
                    foreach($req->slot_start as $key=>$val){
                        $slotArr[] = [
                            'start_time'=>$val,
                            'end_time'=>$req->slot_end[$key],
                        ];
                    }
                }
    
                $startTime = null;
                $endTime = null;
            }
    
            if($req->event_type==3){
                $startTime = null;
                $endTime = null;
                $slotArr = null;
            }
           

            if($req->organizer_id == ""){
                $req->organizer_id = Auth::id();
            }
            
            $jsonData = json_encode([
                'event_name'=>$req->event_name,
                'total_seats'=>$req->total_seats,
                'age_group'=>$req->age_group,
                'demo_session'=>$req->demo_session,
                'category_id'=>$req->category_id,
                'status'=>$req->status,
                'event_type'=>$req->event_type,
                'start_time'=>$startTime,
                'end_time'=>$endTime,
                'days'=>$days,
                'slot_time'=>$slotArr,
                'organizer_id'=>$req->organizer_id,
                'scanner_id'=>$req->scanner_id,
                'ticket_type'=>$req->ticket_type,
                'eventType'=>$eventType['event_type']
            ]);
            
            $checkPreviousData->basic_info = $jsonData;
            $checkPreviousData->save();
            return redirect('/dashboard-event-location?eq='.$req->eq);
        }

        $days = null;
        $slotArr = null;
        $startTime = $req->start_time;
        $endTime = $req->end_time;
        if($req->event_type==2){
            if(!empty($req->days)){
                $days = implode(",",$req->days);
            }
            if(!empty($req->slot_start)){
                foreach($req->slot_start as $key=>$val){
                    $slotArr[] = [
                        'start_time'=>$val,
                        'end_time'=>$req->slot_end[$key],
                    ];
                }
            }

            $startTime = null;
            $endTime = null;
        }

        if($req->event_type==3){
            $startTime = null;
            $endTime = null;
            $slotArr = null;
        }

        if($req->organizer_id == ""){
            $req->organizer_id = Auth::id();
        }
        
        $jsonData = json_encode([
           'event_name'=>$req->event_name,
            'total_seats'=>$req->total_seats,
            'age_group'=>$req->age_group,
            'demo_session'=>$req->demo_session,
            'category_id'=>$req->category_id,
            'status'=>$req->status,
            'event_type'=>$req->event_type,
            'start_time'=>$startTime,
            'end_time'=>$endTime,
            'days'=>$days,
            'slot_time'=>$slotArr,
            'organizer_id'=>$req->organizer_id,
            'scanner_id'=>$req->scanner_id,
            'ticket_type'=>$req->ticket_type,
            'eventType'=>$eventType['event_type']
        ]);

        $tempData = new TempEvent;
        $tempData->user_id = $userId; 
        $tempData->basic_info = $jsonData;
        $tempData->step_count = 2;
        $tempData->save();

        return redirect('/dashboard-event-location?eq='.$req->eq);
    }

    
    public function dashboardEventlocation(){
        
        $userid = Auth::id();
        $checkEvent = TempEvent::Where('user_id',$userid)->where('status',0)->orderBy('id','DESC')->first();
        if($checkEvent != NULL){
            return view('eventDashboard.event.event-location',compact('checkEvent'));
        }
        return redirect()->back()->with('warning','Complete The Step To Continue');
    }

    public function postdashboardEventlocation(Request $req){

        $req->validate([
            'temple_name'=>'required',
            'address'=>'required',
            'city_name'=>'required',
        ],[
            'temple_name.required'=>'Event Place feild is required',
            'address.required'=>'Event Address feild is required',
            'city_name.required'=>'City Name feild is required',
        ]);
        $userId = Auth::id();
        $checkPreviousData = TempEvent::Where('user_id',$userId)->where('status',0)->orderBy('id','DESC')->first();
        if($checkPreviousData != NULL){ 
            if($checkPreviousData->step_count == 2){
                $checkPreviousData->step_count = 3;
            }
            $data = $req->all();
            unset($data['_token']);
            $checkPreviousData->location_info = json_encode($data);
            $checkPreviousData->save();
            return redirect('/dashboard-event-description?eq='.$req->eq);
        }
        return redirect()->back()->with('warning','Complete The Step To Continue');
    }

    public function dashboardEventdescription(){
        $userid = Auth::id();
        $checkEvent = TempEvent::Where('user_id',$userid)->where('status',0)->orderBy('id','DESC')->first();
        if($checkEvent != NULL){
            if($checkEvent->step_count >= 3){
                
                return view('eventDashboard.event.event-description', compact('checkEvent'));
            }
            return redirect('/dashboard-event-location?eq='.$req->eq);
        }
        return redirect()->back()->with('warning','Complete The Step To Continue');
    }

    public function postdashboardEventdescription(Request $req){
        $req->validate([
            'event_description'=>'required',
        ],[
            'event_description.required'=>"This Feild is Required"
        ]);
       
        $userId = Auth::id();
        $checkPreviousData = TempEvent::Where('user_id',$userId)->where('status',0)->orderBy('id','DESC')->first();
        if($checkPreviousData != NULL){ 
            if($checkPreviousData->step_count == 3){
                $checkPreviousData->step_count = 4;
            }
            $data = $req->all();
            unset($data['_token']);
            $checkPreviousData->description_info = json_encode($data);
            $checkPreviousData->save();
            return redirect('/dashboard-event-photos?eq='.$req->eq);
        }
        return redirect()->back()->with('warning','Complete The Step To Continue');
    }

    public function dashboardEventphotos(){
        $userid = Auth::id();
        $checkEvent = TempEvent::Where('user_id',$userid)->where('status',0)->orderBy('id','DESC')->first();
        if($checkEvent != NULL){
            if($checkEvent->step_count >= 4){
                return view('eventDashboard.event.event-photo',compact('checkEvent'));
            }
            return redirect('/dashboard-event-description?eq='.$req->eq);
        }
        return redirect()->back()->with('warning','Complete The Step To Continue');
    }

    public function postdashboardEventphotos(Request $request){
        $request->validate([
            'image'=>'required'
        ],[
           'image.required'=>'This Feild is Required', 
        ]);
        $userID = Auth::id();
        $mainImage = null;
        if ($request->hasFile('image')) {
            $mainImage = (new AppHelper)->saveImage($request);
            $dtImg = ['image'=>$mainImage,'user_id'=>$userID,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")];
            EventGallery::insert($dtImg);
        }
        
        $banner_img = NULL;
        if($request->has('main_image')){
            $image = $request->file('main_image');
            $name = time().'-'.uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $banner_img = $name;
        }

        $galleryImages = null;
        if($request->has('gallery_image')){
            $gallImage = [];
            foreach($request->file('gallery_image') as $k=>$image){
                $gallImage[] = [
                    'coach_name'=>$request->coach_name[$k],
                    'image'=>(new AppHelper)->saveImageWithPath($image, 'couch-image')
                ];
            }
            $galleryImages = json_encode($gallImage);
        }

        $userId = Auth::id();
        $checkPreviousData = TempEvent::Where('user_id',$userId)->where('status',0)->orderBy('id','DESC')->first();
        if($checkPreviousData != NULL){ 
            if($checkPreviousData->step_count == 4){
                $checkPreviousData->status = 1;
                $checkPreviousData->photos_info = json_encode(['postcardImage'=>$mainImage,'gallery'=>$galleryImages,'banner_img'=>$banner_img]);

                $basicData = json_decode($checkPreviousData->basic_info);
                $locationData = json_decode($checkPreviousData->location_info);
                $descriptionData = json_decode($checkPreviousData->description_info);
                $photoData = json_decode($checkPreviousData->photos_info);
               
                try{
                    \DB::beginTransaction();
                    $eventPData = new EventParent;
                    $eventPData->event_name = $basicData->event_name;
                    $eventPData->user_id = $userId;
                    $eventPData->status = 1;
                    $eventPData->save();

                    $eventDData = new EventDescription;
                    $eventDData->user_id = $userId;
                    $eventDData->title = $descriptionData->desc_title;
                    $eventDData->description = $descriptionData->event_description;
                    $eventDData->amenities = isset($descriptionData->amenities) ? json_encode($descriptionData->amenities) : null;
                    $eventDData->sports_available = isset($descriptionData->sports_available) ? json_encode($descriptionData->sports_available) : null;
                    $eventDData->status = 1;
                    $eventDData->save();

                    if($basicData->event_type == 1){
                        $eventType = "Particular";
                    }else if($basicData->event_type == 2){
                        $eventType = "Recurring";
                    }else if($basicData->event_type == 3){
                        $eventType = "OnDemand";
                    }

                    $newEvent = new Event;
                    $newEvent->temple_name = $locationData->temple_name;
                    $newEvent->venue_name = $locationData->venue_name;
                    $newEvent->gallery = $galleryImages;
                    $newEvent->banner_img = $banner_img;
                    $newEvent->ticket_type = $basicData->ticket_type == Null ? 0  : $basicData->ticket_type;
                    $newEvent->user_id = $basicData->organizer_id;
                    $newEvent->name = $basicData->event_name;
                    $newEvent->total_seats = $basicData->total_seats;
                    $newEvent->age_group = $basicData->age_group;
                    $newEvent->demo_session = $basicData->demo_session;
                    $newEvent->type = NULL;
                    $newEvent->url = NULL;
                    $newEvent->scanner_id = $basicData->scanner_id;
                    $newEvent->image = $mainImage;
                    $newEvent->address = $locationData->address;
                    $newEvent->category_id = $basicData->category_id;
                    $newEvent->city_name = $locationData->city_name;
                    $newEvent->start_time = $basicData->start_time;
                    $newEvent->end_time = $basicData->end_time;
                    $newEvent->recurring_days = $basicData->days;
                    $newEvent->time_slots = $basicData->slot_time!=null ? json_encode($basicData->slot_time) : null;
                    $newEvent->description = $descriptionData->event_description;
                    $newEvent->tags = (isset($descriptionData->tags)) ? json_encode($descriptionData->tags) : null;
                    $newEvent->skill_level = (isset($descriptionData->skill_level)) ? json_encode($descriptionData->skill_level) : null;
                    $newEvent->session_plan = $descriptionData->session_plan;
                    $newEvent->coaching_fee = $descriptionData->coaching_fee;
                    $newEvent->bring_equipment = $descriptionData->bring_equipment;
                    $newEvent->status = $basicData->status;
                    $newEvent->event_type = $eventType;
                    $newEvent->event_status = "Pending";
                    $newEvent->event_parent_id = $eventPData->id;
                    $newEvent->event_description_id = $eventDData->id;
                    $newEvent->event_cat = $basicData->eventType;
                    $newEvent->created_at = date("Y-m-d H:i:s");
                    $newEvent->updated_at = date("Y-m-d H:i:s");
                    $newEvent->save();

                    if( $newEvent->save() == true){
                        $checkPreviousData->save();
                    }

                    
                    \DB::commit();
                }catch(\Exception $e){
                    \DB::rollback();
                    dd('something went wrong...');
                }

                $checkPreviousData = TempEvent::Where('user_id',$userId)->where('status',1)->orderBy('id','DESC')->first();
                $checkPreviousData->delete();

                $inputObjB = new \stdClass();
                $inputObjB->url = url('dashboard-ticket-listing');
                $inputObjB->params = 'event_id='.$newEvent->id;
                $subLink = Common::encryptLink($inputObjB);
                return redirect($subLink)->with('success','Event Created Successfully');
            }
            return redirect('/dashboard-event-description?eq='.$request->eq)->with('warning','Complete The Step To Continue');
        }
        return redirect('/dashboard-events?eq='.$request->eq);  
    }  

    public function dashboardTicketListing(Request $req){
        $event = Common::decryptLink($req->eq);
        $ticket = Ticket::Where('event_id',$event['event_id'])->get();
        $eventTicketType = Event::Where('id',$event['event_id'])->first();

        if($eventTicketType->ticket_type == 0){
            $inputObjB = new \stdClass();
            $inputObjB->url = url('dashboard-add-basic-ticket');
            $inputObjB->params = 'event_id='.$event['event_id'];
            $subLink = Common::encryptLink($inputObjB);
        }else{
            $inputObjB = new \stdClass();
            $inputObjB->url = url('dashboard-add-advance-ticket');
            $inputObjB->params = 'event_id='.$event['event_id'];
            $subLink = Common::encryptLink($inputObjB);
        }

        $inputObjB2 = new \stdClass();
        $inputObjB2->url = url('dashboard-ticket-subscription');
        $inputObjB2->params = 'event_id='.$event['event_id'];
        $subLink2 = Common::encryptLink($inputObjB2);
        return view('eventDashboard.ticket.ticket-listing',compact('ticket','subLink','subLink2'));
    }

    public function dashboardAddticket(Request $req){
        $event = Common::decryptLink($req->eq);
        $eventDeatils = Event::Where('id',$event['event_id'])->with('category')->first();
        // dd($eventDeatils);
        return view('eventDashboard.ticket.add-ticket',compact('eventDeatils'));
    }

    public function dashboardAddticketAdvance(Request $req){
        $event = Common::decryptLink($req->eq);
        $eventDeatils = Event::Where('id',$event['event_id'])->where('ticket_type',1)->with('category')->first();
        $ticket = Ticket::Where('event_id',$event['event_id'])->get();
        if(count($ticket) > 0){
            return redirect()->back()->with('success','Your Ticket is Created Already');
        }
        return view('eventDashboard.ticket.add-advance-ticket',compact('eventDeatils'));
    }

    public function postTicketListing(Request $request){

        $request->validate([
            'name' => 'bail|required',
            'quantity' => 'bail|required',
            'ticket_per_order' => 'bail|required',
        ]);

        $data = $request->all();
        if ($request->type == "free") {
            $data['price'] = 0;
        }

        // dd($request->all());
        $data['allday'] = 0;
        $data['platform_fee_amount'] = 5;
        $data['gateway_fee_amount'] = 5;
        $data['superShow_fee_amount'] = 5;
        $data['superShow_fee'] =  $request->superShow_fee;
        $data['gateway_fee'] =  $request->gateway_fee;
        $data['platform_fee'] =  $request->platform_fee;
        $data['superShow_fee_type'] =  "DISCOUNT";
        $data['gateway_fee_type'] =  "DISCOUNT";
        $data['platform_fee_type'] =  "DISCOUNT";
        $data['start_time'] =  $request->sale_start_time;
        $data['end_time'] =  $request->sale_end_time;
        $data['discount_type'] = $request->disc_type;
        $data['discount_amount'] = $request->discount;
        $data['pay_now'] = ($request->pay_now == null ? 0 : $request->pay_now);
        $data['pay_place'] = ($request->pay_place == null ? 0 : $request->pay_place);
        $ticektNum = Common::generateUniqueTicketNum(chr(rand(65, 90)) . chr(rand(65, 90)) . '-' . rand(999, 10000)); 
        $data['ticket_number'] = $ticektNum;
        $event = Event::find($request->event_id);
        $data['user_id'] = $event->user_id;
        Ticket::create($data);

        $inputObjB = new \stdClass();
        $inputObjB->url = url('dashboard-ticket-listing');
        $inputObjB->params = 'event_id='.$request->event_id;
        $subLink = Common::encryptLink($inputObjB);
        return redirect($subLink)->with('success','Ticket Created Successfully');
    }


    public function dashboardTicketSubscription(Request $req){
        $event = Common::decryptLink($req->eq);
        $eventId = Event::select('name','id')->where('id',$event)->first();
        $subscription = Subscription::where('status',1)->get();
        return view('eventDashboard.ticket.ticket-subscription',compact('subscription','eventId'));
    }

    public function getSubscriptionAmount(Request $req){
        $amount = Subscription::select('price')->Where('id',$req->id)->first();
        return response()->json(['amount'=>round($amount->price)]);
    }

    public function get_curl_handle($razorpay_payment_id, $amount, $currency_code){
         $settingData = Common::paymentKeysAll();
         $url = 'https://api.razorpay.com/v1/payments/' . $razorpay_payment_id . '/capture';
         $key_id = $settingData->razorPublishKey;
         $key_secret = $settingData->razorSecretKey;
 
          $curl = curl_init();
 
         curl_setopt_array($curl, [
         CURLOPT_URL => "https://api.razorpay.com/v1/payments/".$razorpay_payment_id,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => "",
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 30,
         CURLOPT_USERPWD=>$key_id . ':' . $key_secret,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => "GET",
         ]);
 
         return $curl;
    }

    public function storeEventSubscription(Request $request){
        $userId = Auth::id();
        if(!empty($request->razorpay_payment_id) && !empty($request->merchant_order_id)){
            $razorpay_payment_id = $request->razorpay_payment_id;
            $currency_code = $request->currency_code;
            $amount = $request->merchant_total;
            $merchant_order_id = $request->merchant_order_id;
            $success = false;
            $error = '';
            try{
                $ch = $this->get_curl_handle($razorpay_payment_id, $amount, $currency_code);
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false){
                    $success = false;
                    $error = 'Curl error: ' . curl_error($ch);
                }else{
                    $response_array = json_decode($result, true);
                    if ($http_status === 200 and isset($response_array['error']) === false){
                        $success = true;
                    }else{
                        $success = false;
                        if (!empty($response_array['error']['code'])){
                            $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                        }else{
                            $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                        }
                    }
                }
                curl_close($ch);
            }catch(\Exception $e){
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }
            if ($success === true){
                $eventSub = UserEventSubscription::select('id')->where(['event_id'=>$request->event_id,'payment_token'=>$merchant_order_id])->first();
                if(!$eventSub){
                    $subscriptionId = UserEventSubscription::insertGetId([
                        'event_id'=>$request->event_id,
                        'subscription_id'=>$request->subscription_id,
                        'organiser_id'=>$userId,
                        'payment'=>$amount/100,
                        'payment_type'=>'Razorpay',
                        'payment_status'=>1,
                        'payment_token'=>$razorpay_payment_id,
                        'created_at'=>date("Y-m-d H:i:s"),
                        'updated_at'=>date("Y-m-d H:i:s")
                    ]);
                }else{
                    $subscriptionId = $eventSub->id;
                }
                return redirect('/thankyou-subscriber')->with('success','Subscribed Successfully...');
            }else{
                return redirect($request->merchant_furl_id);
            }
        }else{
            echo 'An error occured. Contact site administrator, please!';
        }
    }

    public function thankyouSubscriber(){
        return view('eventDashboard.ticket.thankyou');
    }

    public function postdashboardAddticketAdvance(Request $req){

        $event = Event::find($req->event_id);
        if($req->frontRow){
            // For Front Row
            $req->validate([
                'fronttype' => 'required',
                'front_name' => 'required',
                'front_status' => 'required',
                'frontRows' => 'required',
            ]);
          
            if ($req->fronttype == "free") {
                $priceF = 0;
            }else{
                $priceF = $req->front_price;
            }
            
            $fQunatity = 0;
            foreach($req->frontRows as $cost){
                $fQunatity += $cost;
            }

            $ticket = new Ticket;
            $ticket->event_id = $req->event_id;
            $ticket->user_id = $event->user_id;
            $ticket->name = $req->front_name;
            $ticket->type = $req->fronttype;
            $ticket->allday = 0;
            $ticket->start_time =  $req->sale_start_time;
            $ticket->end_time =  $req->sale_end_time;
            $ticket->ticket_per_order = $req->max_ticket;
            $ticket->quantity = $fQunatity;
            $ticket->pay_now = ($req->pay_now == null ? 0 : $req->pay_now);
            $ticket->pay_place = ($req->pay_place == null ? 0 : $req->pay_place);
            $ticket->price = $priceF;
            $ticket->discount_type = $req->front_disc_type;
            $ticket->discount_amount = $req->front_discount;
            $ticket->superShow_fee_type = "DISCOUNT";
            $ticket->superShow_fee = $req->superShow_fee;
            $ticket->gateway_fee_type = "DISCOUNT";
            $ticket->gateway_fee = $req->gateway_fee;
            $ticket->platform_fee_type = "DISCOUNT";
            $ticket->platform_fee_amount = 5;
            $ticket->gateway_fee_amount = 5;
            $ticket->superShow_fee_amount = 5;
            $ticket->platform_fee = $req->platform_fee;
            $ticket->description = $req->front_description;
            $ticket->status = $req->front_status;
            $ticket->ticket_type = 1;
            $ticket->ticket_row = json_encode($req->frontRows);
            $ticektNum = Common::generateUniqueTicketNum(chr(rand(65, 90)) . chr(rand(65, 90)) . '-' . rand(999, 10000)); 
            $ticket->ticket_number = $ticektNum;
            $ticket->save();
        }

        if($req->middleRow){
            // For Middle Row
            $req->validate([
                'middletype' => 'required',
                'middle_name' => 'required',
                'middle_status' => 'required',
                'middleRows' => 'required',
            ]);
          
            if ($req->middletype == "free") {
                $priceF = 0;
            }else{
                $priceF = $req->middle_price;
            }

            $mQunatity = 0;
            foreach($req->middleRows as $cost){
                $mQunatity += $cost;
            }

            $ticket = new Ticket;
            $ticket->start_time =  $req->sale_start_time;
            $ticket->end_time =  $req->sale_end_time;
            $ticket->event_id = $req->event_id;
            $ticket->user_id = $event->user_id;
            $ticket->name = $req->middle_name;
            $ticket->type = $req->middletype;
            $ticket->allday = 0;
            $ticket->ticket_per_order = $req->max_ticket;
            $ticket->quantity = $mQunatity;
            $ticket->pay_now = ($req->pay_now == null ? 0 : $req->pay_now);
            $ticket->pay_place = ($req->pay_place == null ? 0 : $req->pay_place);
            $ticket->price = $priceF;
            $ticket->discount_type = $req->middle_disc_type;
            $ticket->discount_amount = $req->middle_discount;
            $ticket->superShow_fee_type = "DISCOUNT";
            $ticket->superShow_fee = $req->superShow_fee;
            $ticket->gateway_fee_type = "DISCOUNT";
            $ticket->gateway_fee = $req->gateway_fee;
            $ticket->platform_fee_type = "DISCOUNT";
            $ticket->platform_fee_amount = 5;
            $ticket->gateway_fee_amount = 5;
            $ticket->superShow_fee_amount = 5;
            $ticket->platform_fee = $req->platform_fee;
            $ticket->description = $req->middle_description;
            $ticket->status = $req->middle_status;
            $ticket->ticket_type = 2;
            $ticket->ticket_row = json_encode($req->middleRows);
            $ticektNum = Common::generateUniqueTicketNum(chr(rand(65, 90)) . chr(rand(65, 90)) . '-' . rand(999, 10000)); 
            $ticket->ticket_number = $ticektNum;
            $ticket->save();
        }

        if($req->backRow){
            // For Back Row
            $req->validate([
                'backtype' => 'required',
                'back_name' => 'required',
                'back_status' => 'required',
                'backRows' => 'required',
            ]);
          
            if ($req->backtype == "free") {
                $priceF = 0;
            }else{
                $priceF = $req->back_price;
            }

            $bQunatity = 0;
            foreach($req->backRows as $cost){
                $bQunatity += $cost;
            }

            $ticket = new Ticket;
            $ticket->start_time =  $req->sale_start_time;
            $ticket->end_time =  $req->sale_end_time;
            $ticket->event_id = $req->event_id;
            $ticket->user_id = $event->user_id;
            $ticket->name = $req->back_name;
            $ticket->type = $req->backtype;
            $ticket->allday = 0;
            $ticket->ticket_per_order = $req->max_ticket;
            $ticket->quantity = $bQunatity;
            $ticket->pay_now = ($req->pay_now == null ? 0 : $req->pay_now);
            $ticket->pay_place = ($req->pay_place == null ? 0 : $req->pay_place);
            $ticket->price = $priceF;
            $ticket->discount_type = $req->back_disc_type;
            $ticket->discount_amount = $req->back_discount;
            $ticket->superShow_fee_amount = 5;
            $ticket->superShow_fee_type = "DISCOUNT";
            $ticket->superShow_fee = $req->superShow_fee;
            $ticket->gateway_fee_amount = 5;
            $ticket->gateway_fee_type = "DISCOUNT";
            $ticket->gateway_fee = $req->gateway_fee;
            $ticket->platform_fee_amount = 5;
            $ticket->platform_fee_type = "DISCOUNT";
            $ticket->platform_fee = $req->platform_fee;
            $ticket->description = $req->back_description;
            $ticket->status = $req->back_status;
            $ticket->ticket_type = 3;
            $ticket->ticket_row = json_encode($req->backRows);
            $ticektNum = Common::generateUniqueTicketNum(chr(rand(65, 90)) . chr(rand(65, 90)) . '-' . rand(999, 10000)); 
            $ticket->ticket_number = $ticektNum;
            $ticket->save();
        }

        $inputObjB2 = new \stdClass();
        $inputObjB2->url = url('dashboard-ticket-subscription');
        $inputObjB2->params = 'event_id='.$req->event_id;
        $subLink2 = Common::encryptLink($inputObjB2);
        return redirect($subLink2)->with('success','Ticket Created Successfully');

    }

    public function logout(){   
        // dd('asdf'); 
        Auth::logout();
        Session::flush();
        return redirect('user-login');
    }
    
}