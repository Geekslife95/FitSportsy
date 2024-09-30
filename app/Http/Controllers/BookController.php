<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderChild;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Tax;
use Common,Auth,Illuminate\Support\Carbon;
use App\Models\Event;
use App\Http\Resources\EventResource;
use App\Models\WhatsappSubscriber;
use Illuminate\Support\Facades\Mail;
use App\Models\SpiritualVolunteers;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    // public function bookEventTicket(){
    //     $id = $this->memberObj['id'];
    //     $type = $this->memberObj['type'];
    //     $ticketData = [];
    //     $timeSlots = [];
    //     $daysArr = [];
    //     if($type=='Particular'){
    //         $setting = Common::siteGeneralSettings();
    //         $timezone = $setting->timezone;
    //         $date = Carbon::now($timezone);
    //         $ticketData = Ticket::select('id','ticket_number','name','price','event_id','quantity','ticket_per_order','start_time','end_time')->withSum('total_orders','quantity')->with('event')->where('id',$id)->where('end_time', '>=', $date->format('Y-m-d H:i:s'))->where('start_time', '<=', $date->format('Y-m-d H:i:s'))->first();
    //     }else{
    //         $ticketData = Ticket::select('id','ticket_number','name','price','event_id','quantity','ticket_per_order')->withSum('total_orders','quantity')->with('event')->where('id',$id)->first();
    //         $daysAr = explode(",",$ticketData->event->recurring_days);
    //         $nextTwoWeeks = Common::nextTwoWeeks();
    //         foreach($nextTwoWeeks as $vl){
    //             if(in_array(date("l",strtotime($vl)),$daysAr)){
    //                 $daysArr[] = $vl;
    //             }
    //         }
    //         $timeSlots = json_decode($ticketData->event->time_slots);
    //     }
    //     if(!$ticketData){
    //         return redirect('/');
    //     }
    //     $inputObj = new \stdClass();
    //     $inputObj->params = 'id='.$id;
    //     $inputObj->url = url('get-ticket-counts');
    //     $ticketCheckLink = Common::encryptLink($inputObj);

    //     $inputObjR = new \stdClass();
    //     $inputObjR->params = 'id='.$id;
    //     $inputObjR->url = url('save-ticket-bookings');
    //     $ticketPostLink = Common::encryptLink($inputObjR);
    //     return view('frontend.book-event.book-event-ticket',compact('ticketData','daysArr','timeSlots','type','ticketCheckLink','ticketPostLink'));
    // }


    public function bookEventTicket(){
        $id = $this->memberObj['id'];
        $type = $this->memberObj['type'];
        // dd($type);
        $ticketData = [];
        $timeSlots = [];
        $daysArr = [];
        if($type == "Particular"){
            $setting = Common::siteGeneralSettings();
            $timezone = $setting->timezone;
            $date = Carbon::now($timezone);
            $ticketData = Ticket::select('id','ticket_number','name','price','event_id','quantity','ticket_per_order','start_time','end_time')->withSum('total_orders','quantity')->with('event')->where('id',$id)->where('end_time', '>=', $date->format('Y-m-d H:i:s'))->where('start_time', '<=', $date->format('Y-m-d H:i:s'))->first();
            $daysAr = explode(",",$ticketData->event->recurring_days);
            $nextTwoWeeks = Common::nextTwoWeeks();
            foreach($nextTwoWeeks as $vl){
                $daysArr[] = $vl;
                if(in_array(date("l",strtotime($vl)),$daysAr)){
                }
            }
        }else{
            $ticketData = Ticket::select('id','ticket_number','name','price','event_id','quantity','ticket_per_order')->withSum('total_orders','quantity')->with('event')->where('id',$id)->first();
            $daysAr = explode(",",$ticketData->event->recurring_days);
            $nextTwoWeeks = Common::nextTwoWeeks();
            foreach($nextTwoWeeks as $vl){
                $daysArr[] = $vl;
                if(in_array(date("l",strtotime($vl)),$daysAr)){
                }
            }
            $timeSlots = json_decode($ticketData->event->time_slots);
            // dd($timeSlots);
        }
        if(!$ticketData){
            return redirect('/');
        }
        $selectedCity = \Session::has('CURR_CITY') ? \Session::get('CURR_CITY') : 'All';
        // get all matches events temples da

        $inputObj = new \stdClass();
        $inputObj->params = 'id='.$id;
        $inputObj->url = url('get-ticket-counts');
        $ticketCheckLink = Common::encryptLink($inputObj);

        $inputObjR = new \stdClass();
        $inputObjR->params = 'id='.$id;
        $inputObjR->url = url('save-ticket-bookings');
        $ticketPostLink = Common::encryptLink($inputObjR);
        // dd($ticketData);
        return view('frontend.book-event.book-event-ticket',compact('ticketData','daysArr','timeSlots','type','ticketCheckLink','ticketPostLink',));
    }

    // Get Event list according to date & location
    public function getEventList(Request $request){
        $carbonDate = Carbon::createFromFormat('d M Y', $request->date);
        $day = $carbonDate->isoFormat('dddd');
        $date = $carbonDate->format('Y-m-d');
        $similarEvents = Event::query();

        $similarEvents->select('events.name as name','id','temple_name','address','event_type','time_slots','recurring_days','start_time','end_time')
                        ->where([['status', 1], ['is_deleted', 0], ['event_status', 'Pending']])
                        ->where(function($q) use ($date, $day){
                            $q->where('event_type', 'OnDemand')
                                ->orWhere(function($q) use ($day){
                                    $q->where('event_type', 'Recurring')
                                        ->where('recurring_days', 'LIKE', "%$day%");
                                })
                                ->orWhere(function($q) use ($date){
                                    $q->where('event_type', 'Particular')
                                        ->where('start_time', 'LIKE', "$date%");
                                });
                        })
                        ->where('name',$request->name)
                        ->orderBy('event_type','ASC')
                        ->orderBy('events.start_time', 'desc');

        if(session('CURR_CITY') && session('CURR_CITY') != 'All'){
            $similarEvents->where('city_name', session('CURR_CITY'));
        }
        $similarEvents = $similarEvents->get();
        return EventResource::collection($similarEvents);
    }

    public function setTicketCheckout(Request $request)
    {
        $ticket = $request->all();
        \Session::put('ticket', $ticket);
        $inputObjR = new \stdClass();
        $inputObjR->params = 'id='.$ticket['ticket_id'];
        $inputObjR->url = url('event-ticket-checkout');
        $redirection_link = Common::encryptLink($inputObjR);
        return response([
            'success' => true,
            'redirection_link' => $redirection_link
        ]);
    }

    public function eventTicketCheckout(Request $request){
        $id = $this->memberObj['id'];
        $ticket = Ticket::where('id', $id)->first();
        $inputObjR = new \stdClass();
        $inputObjR->params = 'id='.$ticket->id;
        $inputObjR->url = url('save-ticket-bookings');
        $ticketPostLink = Common::encryptLink($inputObjR);
        return view('frontend.book-event.checkout', compact('ticket','ticketPostLink'));
    }

    public function getTicketCounts(Request $request){
        $dt = $request->dt;
        $tm = $request->tm;
        $date = date("Y-m-d",strtotime($dt));
        $id = $this->memberObj['id'];
        $ticketData = Ticket::select('quantity')->where('id',$id)->first();
        $quantity = $ticketData->quantity;
        $ticketBooked = Order::where(['ticket_date'=>$date,'ticket_slot'=>$tm])->sum('quantity');
        return $ticketBooked > $quantity ? 0 : ($quantity - $ticketBooked);
    }

    public function saveTicketBookings(Request $request){
        $ticketId = $this->memberObj['id'];
        $dataValidate = [
            'prasada_name'=>'required',
            // 'prasada_address'=>'required',
            // 'prasada_city'=>'required',
            'prasada_mobile'=>'required',
            'prasada_email'=>'required|email'
        ];
        if($request->e_type=='Recurring'){
            $dataValidate['date_radio'] = 'required';
            $dataValidate['time_radio'] = 'required';
            // check if seats available
            $ticketData = Ticket::select('quantity')->where('id',$ticketId)->first();
            $ticketBooked = Order::where(['ticket_date'=>$request->date_radio,'ticket_slot'=>$request->time_radio])->sum('quantity');
            $quantity = $ticketData->quantity;
            $remainingTicket = $ticketBooked > $quantity ? 0 : ($quantity - $ticketBooked);
            if($remainingTicket < count($request->full_name)){
                return redirect()->back()->with('warning',$remainingTicket. 'Tickets are available for selected date and time slots');
            }
        }

        $request->validate($dataValidate);
        \Session::forget('eventTicketBook');
        $data = $request->all();
        unset($data['eq']);
        unset($data['_token']);
        \Session::put('eventTicketBook',$data);
        $inputObj = new \stdClass();
        $inputObj->params = 'id='.$ticketId;
        $inputObj->url = url('confirm-ticket-book');
        $ticketCheckLink = Common::encryptLink($inputObj);
        return redirect($ticketCheckLink);
    }

    public function confirmTicketBook(){
        // $ticketId = $this->memberObj['id'];
        // if(!\Session::has('eventTicketBook')){
        //     return redirect('/');
        // }
        // $data = \Session::get('eventTicketBook');
        // $totalPersons = count($data['full_name']);
        // if(!$data){
        //     return redirect('/');
        // }
        // $taxData = Tax::select('name','price','amount_type')->where('status',1)->get();
        // $ticketData = Ticket::select('id','name','price','event_id','quantity','ticket_sold','discount_amount','discount_type','price','convenience_amount','convenience_type','pay_now','pay_place')->withSum('total_orders','quantity')->with('event')->where('id',$ticketId)->first();
        // // dd($ticketId);
        // $inputObj = new \stdClass();
        // $inputObj->params = 'id='.$ticketId;
        // $inputObj->url = url('calculate-book-amount');
        // $ticketCheckLink = Common::encryptLink($inputObj);

        // $inputObjB = new \stdClass();
        // $inputObjB->url = url('store-book-ticket-razor');
        // $inputObjB->params = 'id='.$ticketId;
        // $subLink = Common::encryptLink($inputObjB);

        // return view('frontend.book-event.confirm-ticket-book',compact('ticketData','totalPersons','taxData','ticketCheckLink','subLink','data'));
        // $type = $this->memberObj['type'];

     
       
        $ticketId = $this->memberObj['id'];
        if(!\Session::has('eventTicketBook')){
            return redirect('/');
        }
        $data = \Session::get('eventTicketBook');
        $totalPersons = $data['totalSeats'];
        if(!$data){
            return redirect('/');
        }
        $taxData = Tax::select('name','price','amount_type')->where('status',1)->get();
        $arrCnt = [];
        if(is_array(json_decode($ticketId))){
            $ticketArr = json_decode($ticketId,true);
            $arrCnt = array_count_values($ticketArr);
            $ticketData = Ticket::select('id','name','price','event_id','quantity','ticket_sold','discount_amount','discount_type','price','pay_now','pay_place','superShow_fee_amount','superShow_fee_type','superShow_fee','gateway_fee_amount','gateway_fee_type','gateway_fee','platform_fee_amount','platform_fee_type','platform_fee')->withSum('total_orders','quantity')->with('event')->WhereIn('id',json_decode($ticketId))->get();
            
            $inputObjB = new \stdClass();
            $inputObjB->url = url('store-book-seat-ticket-razor');
            $inputObjB->params = 'id='.$ticketId;
            $subLink = Common::encryptLink($inputObjB);
        }else{
            $ticketData = Ticket::select('id','name','price','event_id','quantity','ticket_sold','discount_amount','discount_type','price','pay_now','pay_place','superShow_fee_amount','superShow_fee_type','superShow_fee','gateway_fee_amount','gateway_fee_type','gateway_fee','platform_fee_amount','platform_fee_type','platform_fee')->withSum('total_orders','quantity')->with('event')->where('id',$ticketId)->first();
            
            $inputObjB = new \stdClass();
            $inputObjB->url = url('store-book-ticket-razor');
            $inputObjB->params = 'id='.$ticketId;
            $subLink = Common::encryptLink($inputObjB);
        }

        // dd($ticketData);

        $inputObj = new \stdClass();
        $inputObj->params = 'id='.$ticketId;
        $inputObj->url = url('calculate-book-amount');
        $ticketCheckLink = Common::encryptLink($inputObj);

        

        return view('frontend.book-event.confirm-ticket-book',compact('ticketData','totalPersons','taxData','ticketCheckLink','subLink','data','arrCnt'));
    }

    public function getPromoDiscount(Request $request){
        $code = $request->code;
        $date = date("Y-m-d");
        $ticketAmount = (float)$request->amount;
        $couponData = Coupon::select('discount_type','discount','id')->where('coupon_code',$code)->where('start_date','<=',$date)->where('end_date','>=',$date)->first();
        if(!$couponData){
            return response()->json(['s'=>2]);
        }
        $amount = $couponData->discount;
        $famount = $ticketAmount - $amount;
        if($couponData->discount_type==0){
            $amount = ($ticketAmount * $couponData->discount)/100;
            $famount = $ticketAmount - $amount;
        }
        return response()->json(['s'=>1,'amount'=>round($amount,2),'famount'=>round($famount,2),'id'=>$couponData->id]);
    }

    public function calculateBookAmount(Request $request){
        $coupon = $request->coupon;
        $donation = $request->donation;
        $ticketId = $this->memberObj['id'];
        $data = \Session::get('eventTicketBook');
        $totalPersons =  $data['totalSeats'];
        $con_fee = 0;
        $superShowFee = 0;
        $gateWayFee = 0;
        $playFormFee = 0;
        if(!$data){
            return response()->json(['amount'=>0]);
        }
        $taxData = Tax::select('name','price','amount_type')->where('status',1)->get();
        $arrCnt = [];
        if(is_array(json_decode($ticketId))){
            $ticketId = json_decode($ticketId);
            $arrCnt = array_count_values($ticketId);
            $ticketData = Ticket::select('id','name','price','event_id','quantity','discount_amount','discount_type','price','superShow_fee_amount','superShow_fee_type','superShow_fee','gateway_fee_amount','gateway_fee_type','gateway_fee','platform_fee_amount','platform_fee_type','platform_fee')->withSum('total_orders','quantity')->with('event')->whereIn('id',$ticketId)->get();
            $fAmount = 0;
            $totalAmntTC = 0;
            foreach($ticketData as $item){
                $fAmount = $item->price;
                if($item->discount_type == "FLAT"){
                    $fAmount = ($fAmount) - ($item->discount_amount);
                }elseif($item->discount_type == "DISCOUNT"){
                    $fAmount = ($fAmount) - ($fAmount * $item->discount_amount)/100;
                }
                $cntt = $arrCnt[$item->id];
                $totalAmntTC = ($totalAmntTC + $fAmount) * $cntt;
            }
            $ticketAmount = $totalAmntTC;

            if ($ticketData[0]->superShow_fee == 2){
                if ($ticketData[0]->superShow_fee_type == "FIXED"){
                    $superShowFee = ($ticketData[0]->superShow_fee_amount);
                }else{
                    $superShowFee = ($ticketAmount * $ticketData[0]->superShow_fee_amount)/100; 
                }
            }
    
            if ($ticketData[0]->gateway_fee == 2){
                if ($ticketData[0]->gateway_fee_type == "FIXED"){
                    $gateWayFee = ($ticketData[0]->gateway_fee_amount);
                }else{
                    $gateWayFee = ($ticketAmount * $ticketData[0]->gateway_fee_amount)/100; 
                }
            }
    
            if ($ticketData[0]->platform_fee == 2){
                if ($ticketData[0]->platform_fee_type == "FIXED"){
                    $playFormFee = ($ticketData[0]->platform_fee_amount);
                }else{
                    $playFormFee = ($ticketAmount * $ticketData[0]->platform_fee_amount)/100; 
                }
            }

        }else{
            $ticketData = Ticket::select('id','name','price','event_id','quantity','discount_amount','discount_type','price','superShow_fee_amount','superShow_fee_type','superShow_fee','gateway_fee_amount','gateway_fee_type','gateway_fee','platform_fee_amount','platform_fee_type','platform_fee')->withSum('total_orders','quantity')->with('event')->where('id',$ticketId)->first();

            $totalAmntTC = $ticketData->price;  
            if($ticketData->discount_type == "FLAT"){
                $totalAmntTC = ($ticketData->price) - ($ticketData->discount_amount); 
            }elseif($ticketData->discount_type == "DISCOUNT"){
                $totalAmntTC = ($ticketData->price) - ($ticketData->price * $ticketData->discount_amount)/100;
            }
            $ticketAmount =  round(($totalPersons * $totalAmntTC),2); 
    
            if ($ticketData->superShow_fee == 2){
                if ($ticketData->superShow_fee_type == "FIXED"){
                    $superShowFee = ($ticketData->superShow_fee_amount);
                }else{
                    $superShowFee = ($ticketAmount * $ticketData->superShow_fee_amount)/100; 
                }
            }
    
            if ($ticketData->gateway_fee == 2){
                if ($ticketData->gateway_fee_type == "FIXED"){
                    $gateWayFee = ($ticketData->gateway_fee_amount);
                }else{
                    $gateWayFee = ($ticketAmount * $ticketData->gateway_fee_amount)/100; 
                }
            }
    
            if ($ticketData->platform_fee == 2){
                if ($ticketData->platform_fee_type == "FIXED"){
                    $playFormFee = ($ticketData->platform_fee_amount);
                }else{
                    $playFormFee = ($ticketAmount * $ticketData->platform_fee_amount)/100; 
                }
            }
        }

        $ticketAmount = round($ticketAmount+$gateWayFee+$playFormFee+$superShowFee,2); 

        foreach ($taxData as $tax){
            $txamount = $tax->price;
            if($tax->amount_type=="percentage"){
                $txamount = ((($ticketAmount) * $tax->price) / 100);
            }
            $ticketAmount = round($ticketAmount + $txamount,2); 
        }
        
        // Donation Fee
        $ticketAmount = $ticketAmount+$donation;  

        $date = date("Y-m-d");
        $couponData = Coupon::select('discount_type','discount')->where('coupon_code',$coupon)->where('start_date','<=',$date)->where('end_date','>=',$date)->first();

        $famount = $ticketAmount;
        if($couponData){
            $amount = $couponData->discount;
            $famount = ($ticketAmount - $amount);
            if($couponData->discount_type == 0){
                $amount = ($ticketAmount * $couponData->discount)/100;
                $famount = ($ticketAmount - $amount);
            }
        }
        return response()->json(['amount'=>round($famount,2)]);
    }

    public function get_curl_handle($razorpay_payment_id, $amount, $currency_code){
       //  $settingData = Common::paymentKeysAll();
       //  $url = 'https://api.razorpay.com/v1/payments/' . $razorpay_payment_id . '/capture';
       //  $key_id = $settingData->razorPublishKey;
       //  $key_secret = $settingData->razorSecretKey;
       //  $arr = array(
       //      'amount' => $amount,
       //      'currency' => $currency_code
       //  );
       //  $arr1 = json_encode($arr);
       //  $fields_string = $arr1;
       //  $ch = curl_init();
       // //set the url, number of POST vars, POST data
       //  curl_setopt($ch, CURLOPT_URL, $url);
       //  curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
       //  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
       //  curl_setopt($ch, CURLOPT_POST, 1);
       //  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
       //  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       //  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       //  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
       //      'Content-Type: application/json'
       //  ));
       //  return $ch;
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

    public function sendTicketEmail($data){
        try{
            Mail::send('templates.ticket-book-email', $data, function($message) use($data) {
                $message->to($data['email'], 'Supershows')->subject
                    ('Supershows Ticket Book Confirmation - '.date("d M Y h:i A"));
            });
        }catch(\Exception $e){
            //
        }
    }

    public function sendWhatsAppNotification($whatAppDetails){
        try{
            // $response = Http::withBody( 
            //     '{
            //     "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NWIwNWFlZTg5ZTI5NTIwZmE4NjVkYyIsIm5hbWUiOiJCb29rbXlQdWphU2V2YSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGU1OWM1ZjNkYmZlYzAxNmI0OTM3ZmMiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMDQ2NDA0Nn0.44ZUFuJfyla1fzjVneX699hHXHXFh4j0c8YgyHIczYk",
            //     "campaignName": "Event Ticket Booked",
            //     "destination": "+919012400499",
            //     "userName": "Devansh",
            //     "source": "Website lead",
            //     "media":{
            //     "url": "https://bookmypujaseva.com/images/upload/64e5ea47be10f.png",
            //         "filename": "logo"
            //     },
            //     "templateParams": [
            //         "Devansh",
            //         "Devansh",
            //         "Devansh",
            //         "Devansh",
            //         "Devansh"
            //     ]
            //     }', 'json' 
            // ) 
            // ->withHeaders([ 
            //     'Accept'=> '*/*', 
            //     'Content-Type'=> 'application/json', 
            // ]) 
            // ->post('https://backend.aisensy.com/campaign/t1/api/v2');
           
            $event = Event::Where('id',$whatAppDetails['event_id'])->first();
            $eventName = $event->name;
            $location = $event->address;

            $data = [
                "apiKey"=> "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NWIwNWFlZTg5ZTI5NTIwZmE4NjVkYyIsIm5hbWUiOiJCb29rbXlQdWphU2V2YSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGU1OWM1ZjNkYmZlYzAxNmI0OTM3ZmMiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMDQ2NDA0Nn0.44ZUFuJfyla1fzjVneX699hHXHXFh4j0c8YgyHIczYk",
                "campaignName"=> "Event Ticket Booked",
                "destination"=> "+91".$whatAppDetails['number'],
                "userName"=> $whatAppDetails['name'],
                "source"=> "Website Lead",
                "media"=>[
                "url"=> "https://bookmypujaseva.com/images/upload/64e5ea47be10f.png",
                    "filename"=> "logo"
                ],
                "templateParams"=> [
                    $whatAppDetails['name'],
                    $eventName,
                    date("d M Y",strtotime($whatAppDetails['ticket_date'])),
                    $whatAppDetails['ticket_slot'],
                    $location
                ]
            ];
            $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => "https://backend.aisensy.com/campaign/t1/api/v2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Accept: */*",
                "Content-Type: application/json",
            ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
            echo $response;
            }


        }catch(\Exception $e){
            //
            echo $e->getMessage();
        }
    }

    // New 
    public function storeBookSeatTicketRazor(Request $request){
        $ticketId = $this->memberObj['id'];
        $ticketId = json_decode($ticketId);
        $userId = Auth::guard('appuser')->check() ? Auth::guard('appuser')->user()->id : 0;
        $ticketData = Ticket::select('event_id','e.user_id')->join('events as e','e.id','event_id')->find($ticketId[0]);
        $data = \Session::get('eventTicketBook');
        $totalPersons = $data['totalSeats'];
        // dd($data);
        $ticketNumGen = Common::generateUniqueUserTicketNumber(chr(rand(65,90)).chr(rand(65,90)).'-'.rand(9999,100000));
        // dd($data['seatSlot']);
        $seatNumber = [];
        foreach($data['seatSlot'] as $item){
            $item = json_decode($item);
            array_push($seatNumber,$item[0].$item[1]);
        }
        // dd();
        $orgCommission = "";
        if($request->payment_type==1){
            if(!empty($request->razorpay_payment_id) && !empty($request->merchant_order_id)){
                $razorpay_payment_id = $request->razorpay_payment_id;
                $currency_code = $request->currency_code;
                $amount = $request->merchant_total;
                $merchant_order_id = $request->merchant_order_id;
                $success = false;
                $error = "";
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
                    $checkData = OrderChild::select('order_id')->whereIn('ticket_id',$ticketId)->Where('payment_token',$merchant_order_id)->first();
                    if(!$checkData){
                    $orderId = Order::insertGetId([
                        'order_id'=>$merchant_order_id,
                        'book_seats'=>json_encode($seatNumber),
                        'seat_details'=>json_encode($ticketId),
                        'customer_id'=>$userId,
                        'organization_id'=>$ticketData->user_id,
                        'org_commission'=>$request->org_commission,
                        'event_id'=>$ticketData->event_id,
                        'checkins_count'=>0,
                        'ticket_id'=>NULL,
                        'coupon_id'=>$request->coupon_id > 0 ? $request->coupon_id : null,
                        'quantity'=>$totalPersons,
                        'coupon_discount'=>round($request->coupon_discount,2),
                        'ticket_date'=>Carbon::parse($data['date'])->format('Y-m-d'),
                        'ticket_slot'=>$data['time'],
                        'tax'=>round($request->total_tax,2),
                        'payment'=>$amount/100,
                        'payment_type'=>'Razorpay',
                        'payment_status'=>1,
                        'payment_token'=>$razorpay_payment_id,
                        'order_status'=>'Pending',
                        'discount_amount'=>$request->discount_amount,
                        'convenience_amount'=>$request->fee,
                        'is_donated'=>$request->donate_checked > 0 ? 1 : 0,
                        'org_pay_status'=>0,
                        'created_at'=>date("Y-m-d H:i:s"),
                        'updated_at'=>date("Y-m-d H:i:s")
                    ]);
                    $devoteePersons = null;
                    $userData = [
                        'prasada_name'=>$request->card_holder_name,
                        'prasada_address'=>$request->address,
                        'prasada_mobile'=>$request->number,
                        'prasada_email'=>$request->email,
                    ];
                    $userData = json_encode($userData);
                    foreach($ticketId as $key => $item){
                        OrderChild::insert([
                            'ticket_id'=>$item,
                            'order_id'=>$orderId,
                            'customer_id'=>$userId,
                            'ticket_number'=>$ticketNumGen,
                            'prasada_address'=>$seatNumber[$key],
                            'ticket_date'=>Carbon::parse($data['date'])->format('Y-m-d'),
                            'ticket_slot'=>$data['time'],
                            'devotee_persons'=>$userData,
                            'payment_token'=>$razorpay_payment_id,
                            'donation'=>$request->donate_checked > 0 ? $request->donate_checked : 0,
                            'status'=>0,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s"),
                        ]);
                    }
                }else{
                    $orderId = $checkData->id;
                }

                if(isset($data['whattsapp_subscribe'])){
                    WhatsappSubscriber::insert([
                        'phone_number'=>$request->number,
                        'created_at'=>date("Y-m-d H:i:s"),
                        'updated_at'=>date("Y-m-d H:i:s")
                    ]);
                }

                $inputObjB = new \stdClass();
                $inputObjB->url = url('booked-ticket-details');
                $inputObjB->params = 'order_id='.$orderId;
                $subLink = Common::encryptLink($inputObjB);
                \Session::forget('eventTicketBook');
                
                // send mail

                $mailData = ['link'=>$subLink,'email'=>$request->email];
                $whatAppDetails = ['name'=>$request->card_holder_name,'number'=>$request->number,'ticket_date'=>Carbon::parse($data['date'])->format('Y-m-d'),'ticket_slot'=>$data['time'],'event_id'=>$ticketData->event_id];
                $this->sendTicketEmail($mailData);
                $this->sendWhatsAppNotification($whatAppDetails);
                return redirect($subLink)->with('success','Ticket Booked Successfully...');
                }else{
                    return redirect($request->merchant_furl_id);
                }
            }else{
                echo 'An error occured. Contact site administrator, please!';
            }
        }else{
            $merchant_order_id = $request->merchant_order_id;
            $razorpay_payment_id = 'cod_'.time().rand(1,9999);
            $checkData = OrderChild::select('order_id')->whereIn('ticket_id',$ticketId)->Where('payment_token',$merchant_order_id)->first();
            if(!$checkData){
                $orderId = Order::insertGetId([
                    'order_id'=>$merchant_order_id,
                    'customer_id'=>$userId,
                    'organization_id'=>$ticketData[0]->user_id,
                    'event_id'=>$ticketData[0]->event_id,
                    'checkins_count'=>0,
                    'ticket_id'=>$ticketId,
                    'org_commission'=>$request->org_commission,
                    'coupon_id'=>$request->coupon_id > 0 ? $request->coupon_id : null,
                    'quantity'=>$totalPersons,
                    'coupon_discount'=>round($request->coupon_discount,2),
                    'ticket_date'=>Carbon::parse($data['date'])->format('Y-m-d'),
                    'ticket_slot'=>$data['time'],
                    'tax'=>round($request->total_tax,2),
                    'payment'=>$request->total_amount_pay,
                    'payment_type'=>'COD',
                    'payment_status'=>0,
                    'payment_token'=>$razorpay_payment_id,
                    'order_status'=>'Pending',
                    'org_pay_status'=>0,
                    'discount_amount'=>$request->discount,
                    'convenience_amount'=>$request->fee,
                    'is_donated'=>$request->donate_checked > 0 ? 1 : 0,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
                $devoteePersons = null;
                $userData = [
                    'prasada_name'=>$request->card_holder_name,
                    'prasada_address'=>$request->address,
                    'prasada_mobile'=>$request->number,
                    'prasada_email'=>$request->email,
                ];
                $userData = json_encode($userData);
                foreach($ticketId as $key => $item){
                    OrderChild::insert([
                        'ticket_id'=>$item,
                        'order_id'=>$orderId,
                        'customer_id'=>$userId,
                        'ticket_number'=>$ticketNumGen,
                        'prasada_address'=>$seatNumber[$key],
                        'ticket_date'=>Carbon::parse($data['date'])->format('Y-m-d'),
                        'ticket_slot'=>$data['time'],
                        'devotee_persons'=>$userData,
                        'payment_token'=>$razorpay_payment_id,
                        'donation'=>$request->donate_checked > 0 ? $request->donate_checked : 0,
                        'status'=>0,
                        'created_at'=>date("Y-m-d H:i:s"),
                        'updated_at'=>date("Y-m-d H:i:s"),
                    ]);
                }
            }else{
                $orderId = $checkData->id;
            }

            // save to whattsapp
            if(isset($data['whattsapp_subscribe'])){
                WhatsappSubscriber::insert([
                    'phone_number'=>$request->number,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }

            $inputObjB = new \stdClass();
            $inputObjB->url = url('booked-ticket-details');
            $inputObjB->params = 'order_id='.$orderId;
            $subLink = Common::encryptLink($inputObjB);

            \Session::forget('eventTicketBook');

            $mailData = ['link'=>$subLink,'email'=>$request->email];
            $whatAppDetails = ['name'=>$request->card_holder_name,'number'=>$request->number,'ticket_date'=>Carbon::parse($data['date'])->format('Y-m-d'),'ticket_slot'=>$data['time'],'event_id'=>$ticketData->event_id];
            $this->sendTicketEmail($mailData);
            $this->sendWhatsAppNotification($whatAppDetails);

            return redirect($subLink)->with('success','Ticket Booked Successfully...');
        }
    }

    public function storeBookTicketRazor(Request $request){
        $ticketId = $this->memberObj['id'];
        $userId = Auth::guard('appuser')->check() ? Auth::guard('appuser')->user()->id : 0;
        $ticketData = Ticket::select('event_id','e.user_id')->join('events as e','e.id','event_id')->find($ticketId);
        $data = \Session::get('eventTicketBook');
        $totalPersons = $data['totalSeats'];
        $extraTicketData = session('ticket');
        // dd($extraTicketData);
        $ticketNumGen = Common::generateUniqueUserTicketNumber(chr(rand(65,90)).chr(rand(65,90)).'-'.rand(9999,100000));
        if($request->payment_type==1){
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
                    // save to database;
                    // check merchant id already exists
                    $checkData = Order::select('id')->where(['ticket_id'=>$ticketId,'payment_token'=>$merchant_order_id])->first();
                    if(!$checkData){
                        $orderId = Order::insertGetId([
                            'order_id'=>$merchant_order_id,
                            'customer_id'=>$userId,
                            'organization_id'=>$ticketData->user_id,
                            'event_id'=>$ticketData->event_id,
                            'checkins_count'=>0,
                            'ticket_id'=>$ticketId,
                            'org_commission'=>$request->org_commission,
                            'coupon_id'=>$request->coupon_id > 0 ? $request->coupon_id : null,
                            'quantity'=>$totalPersons,
                            'coupon_discount'=>round($request->coupon_discount,2),
                            'ticket_date'=>Carbon::parse($data['date'])->format('Y-m-d'),
                            'ticket_slot'=>$data['time'],
                            'tax'=>round($request->total_tax,2),
                            'payment'=>$amount/100,
                            'payment_type'=>'Razorpay',
                            'payment_status'=>1,
                            'payment_token'=>$razorpay_payment_id,
                            'order_status'=>'Pending',
                            'discount_amount'=>$request->discount_amount,
                            'convenience_amount'=>$request->fee,
                            'is_donated'=>$request->donate_checked > 0 ? 1 : 0,
                            'org_pay_status'=>0,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s")
                        ]);
                        $devoteePersons = null;
                        $userData = [
                            'prasada_name'=>$request->card_holder_name,
                            'prasada_address'=>$request->address,
                            'prasada_mobile'=>$request->number,
                            'prasada_email'=>$request->email,
                        ];
                        $userData = json_encode($userData);
                        OrderChild::insert([
                            'ticket_id'=>$ticketId,
                            'order_id'=>$orderId,
                            'customer_id'=>$userId,
                            'ticket_number'=>$ticketNumGen,
                            'prasada_address'=>NULL,
                            'devotee_persons'=>$userData,
                            'donation'=>$request->donate_checked > 0 ? $request->donate_checked : 0,
                            'status'=>0,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s"),
                        ]);
                    }else{
                        $orderId = $checkData->id;
                    }

                    if(isset($data['whattsapp_subscribe'])){
                        WhatsappSubscriber::insert([
                            'phone_number'=>$request->number,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s")
                        ]);
                    }

                    $inputObjB = new \stdClass();
                    $inputObjB->url = url('booked-ticket-details');
                    $inputObjB->params = 'order_id='.$orderId;
                    $subLink = Common::encryptLink($inputObjB);
                    \Session::forget('eventTicketBook');
                    // send mail

                    $mailData = ['link'=>$subLink,'email'=>$request->email];
                    $whatAppDetails = ['name'=>$request->card_holder_name,'number'=>$request->number,'ticket_date'=>Carbon::parse($data['date'])->format('Y-m-d'),'ticket_slot'=>$data['time'],'event_id'=>$ticketData->event_id];
                    $this->sendTicketEmail($mailData);
                    $this->sendWhatsAppNotification($whatAppDetails);
                    return redirect($subLink)->with('success','Ticket Booked Successfully...');
                }else{
                    return redirect($request->merchant_furl_id);
                }
            }else{
                echo 'An error occured. Contact site administrator, please!';
            }
        }else{
            $merchant_order_id = $request->merchant_order_id;
            $razorpay_payment_id = 'cod_'.time().rand(1,9999);
            $checkData = Order::select('id')->where(['ticket_id'=>$ticketId,'payment_token'=>$merchant_order_id])->first();
            if(!$checkData){
                $orderId = Order::insertGetId([
                    'order_id'=>$merchant_order_id,
                    'customer_id'=>$userId,
                    'organization_id'=>$ticketData->user_id,
                    'event_id'=>$ticketData->event_id,
                    'checkins_count'=>0,
                    'ticket_id'=>$ticketId,
                    'coupon_id'=>$request->coupon_id > 0 ? $request->coupon_id : null,
                    'quantity'=>$totalPersons,
                    'org_commission'=>$request->org_commission,
                    'coupon_discount'=>round($request->coupon_discount,2),
                    'ticket_date'=>Carbon::parse($data['date'])->format('Y-m-d'),
                    'ticket_slot'=>$data['time'],
                    'tax'=>round($request->total_tax,2),
                    'payment'=>$request->total_amount_pay,
                    'payment_type'=>'COD',
                    'payment_status'=>0,
                    'payment_token'=>$razorpay_payment_id,
                    'order_status'=>'Pending',
                    'org_pay_status'=>0,
                    'discount_amount'=>$request->discount,
                    'convenience_amount'=>$request->fee,
                    'is_donated'=>$request->donate_checked > 0 ? 1 : 0,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
                $devoteePersons = null;
                $userData = [
                    'prasada_name'=>$request->card_holder_name,
                    'prasada_address'=>$request->address,
                    'prasada_mobile'=>$request->number,
                    'prasada_email'=>$request->email,
                ];
                $userData = json_encode($userData);
                OrderChild::insert([
                    'ticket_id'=>$ticketId,
                    'order_id'=>$orderId,
                    'customer_id'=>$userId,
                    'ticket_number'=>$ticketNumGen,
                    'prasada_address'=>NULL,
                    'devotee_persons'=>$userData,
                    'donation'=>$request->donate_checked > 0 ? $request->donate_checked : 0,
                    'status'=>0,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s"),
                ]);
            }else{
                $orderId = $checkData->id;
            }

            // save to whattsapp
            if(isset($data['whattsapp_subscribe'])){
                WhatsappSubscriber::insert([
                    'phone_number'=>$request->number,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }

            $inputObjB = new \stdClass();
            $inputObjB->url = url('booked-ticket-details');
            $inputObjB->params = 'order_id='.$orderId;
            $subLink = Common::encryptLink($inputObjB);

            \Session::forget('eventTicketBook');

            $mailData = ['link'=>$subLink,'email'=>$request->email];
            $whatAppDetails = ['name'=>$request->card_holder_name,'number'=>$request->number,'ticket_date'=>Carbon::parse($data['date'])->format('Y-m-d'),'ticket_slot'=>$data['time'],'event_id'=>$ticketData->event_id];
            $this->sendTicketEmail($mailData);
            $this->sendWhatsAppNotification($whatAppDetails);

            return redirect($subLink)->with('success','Ticket Booked Successfully...');
        }
    }

    public function razorEventBookPaymentFailed(){
        echo '<h3>PAYMENT FAILED <a href="'.url('/').'">GO TO HOMEPAGE</a></h3>';
    }

    public function bookedTicketDetails(){

        $orderId = $this->memberObj['order_id'];
        $orderData = Order::select('id','event_id','organization_id','quantity','ticket_date','ticket_slot','order_id','payment','ticket_id','payment_type','book_seats')->with('event:id,name,event_type,temple_name,address,city_name,start_time')->with('organization:id,name,last_name')->with('orderchildC:id,ticket_number,devotee_persons,prasada_address,order_id')->with('ticket:id,ticket_number')->where('id',$orderId)->first();
        // $customPaper = array(0, 0, 720, 1440);
        // $pdf = FacadePdf::loadView('frontend.book-event.booked-ticket-details', compact('orderData'))->save(public_path("ticket.pdf"))->setPaper($customPaper, $orientation = 'portrait');
        return view('frontend.book-event.booked-ticket-details',compact('orderData'));
    }

    public function allEvents(Request $request){

        $cities = City::select('city_name','id')->get();
        $date = date("Y-m-d H:i:s");

        $selectedCity = \Session::has('CURR_CITY') ? \Session::get('CURR_CITY') : 'All';

        $catArr = [];
        $cityArr = [];
        $typeArr = [];
        $from = 0;
        $to = 2000;
        $filtered = 0;
        $cityFilter = 0;
        $searchStr = '';
        $event= Event::select('events.name as name','events.id','events.image','temple_name','t.price','t.discount_type','t.discount_amount','category_id')->with('category:id,name')->where([['events.status', 1], ['events.is_deleted', 0], ['event_status', 'Pending']])->where(function($q) use($date){
            $q->where('events.end_time', '>', $date)->orWhereIn('event_type',[2,3]);
        });
        $event->leftJoin('tickets as t','t.event_id','events.id');
        if(!empty($request->category) && $request->category!='all'){
            $catArr = explode(',',$request->category);
            $event->whereIn('category_id',$catArr);
            $filtered = 1;
        }
        if(!empty($request->city) && $request->city!='all'){
            $cityArr = explode(',',$request->city);
            $selcities = City::whereIn('id',$cityArr)->pluck('city_name')->toArray();
            if($selcities){
                $event->whereIn('city_name',$selcities);
            }
            $filtered = 1;
            $cityFilter = 1;

        }
        if(!empty($request->price) && $request->price!='0-2000'){
            $price = explode('-',$request->price);
            $from = $price[0];
            $to = isset($price[1]) ? $price[1] : 2000;
            $event->join('tickets as t','t.event_id','events.id')->whereBetween('price',[$from,$to])->where([['t.is_deleted', 0], ['t.status', 1]]);
            $filtered = 1;
        }
        if(!empty($request->type) && $request->type!='all'){
            $typeArr = explode(",",$request->type);
            $event->join('category as c','c.id','category_id')->whereIn('c.type',$typeArr);
            $filtered = 1;
        }
        if($cityFilter==0 && $selectedCity!='All'){
            $event->where('city_name',$selectedCity);
            array_push($cityArr,$selectedCity);
        }

        if(!empty($request->s) && $request->s!='all'){
            $searchStr = $request->s;
            $event->where('name','like','%'.$searchStr.'%');
            $event->orWhere('temple_name','like','%'.$searchStr.'%');
        }

        $events = $event->orderBy('event_type','ASC')->orderBy('events.start_time', 'desc')->paginate(20);
        
        return view('frontend.book-event.all-events',compact('cities','events','catArr','cityArr','from','to','filtered','typeArr','searchStr'));
    }

    public function eventCity(Request $request){
        $city = $request->city;
        \Session::put('CURR_CITY',$city);
        if($request->redirect){
            return redirect($request->redirect);
        } else {
            return redirect('/');
        }
    }

    public function getTicketsDEvents(Request $request){
        $date = $request->date;
        $id = $this->memberObj['id'];
        $data = Event::select('id','event_type')->find($id);

        if($data->event_type=='Particular'){
            $setting = Common::siteGeneralSettings();
            $timezone = $setting->timezone;
            $date = Carbon::now($timezone);
            $data->ticket_data = Ticket::select('name','id','type','description','start_time','end_time','quantity','maximum_checkins','price','ticket_sold','discount_type','discount_amount')->withSum('total_orders','quantity')->where([['event_id', $data->id], ['is_deleted', 0], ['status', 1], ['end_time', '>=', $date->format('Y-m-d H:i:s')], ['start_time', '<=', $date->format('Y-m-d H:i:s')]])->orderBy('id', 'DESC')->get();
        }else{
            $data->ticket_data = Ticket::select('name','id','type','description','start_time','end_time','quantity','maximum_checkins','price','ticket_sold','discount_type','discount_amount')->withSum('total_orders','quantity')->where([['event_id', $data->id], ['is_deleted', 0], ['status', 1]])->orderBy('id', 'DESC')->get();
        }

        return view('frontend.book-event.get-tickets-d-events',compact('data'));

    }

    public function spritualVolunteer(){
        // $Maxbudget = \DB::table('spiritual_volunteers')->max('budget');
        // $Minbudget = \DB::table('spiritual_volunteers')->min('budget');
        $Destination = SpiritualVolunteers::select('location','id')->groupby('location')->where('status',1)->get();

        $buddy = SpiritualVolunteers::WHERE('status','=','1')->get();
        return view('frontend.findMyTravelBuddy',['buddys'=>$buddy,'Destinations'=>$Destination]);
    }

    public function volunteersDetails($id){
        $buddyDetail = SpiritualVolunteers::WHERE('id','=',$id)->first();
        return view('frontend.buddyDetails',['buddyDetails'=>$buddyDetail]);
    }

    public function createspritualVolunteer(){
        return view('frontend.create-my-travel-buddy');
    }

    public function insertspritualVolunteer(Request $req){
        $req->validate([
            'name'=>'required',
            'email'=>'required | email',
            'number'=>'required',
            'gender'=>'required',
            'location'=>'required',
            'profile_img'=>'required',
            'availability'=>'required',
            'interest'=>'required',
            'skills'=>'required',
            'tradition'=>'required',
            'language'=>'required'
        ]);

        $buddy = new SpiritualVolunteers;
        if(isset($req->profile_img)){

            $base64_image         = $req->profile_img;
            list($type, $data)  = explode(';', $base64_image);
            list(, $data)       = explode(',', $data);
            $data               = base64_decode($data);
            $thumb_name         = "thumb_".date('YmdHis').'.png';
            $thumb_path         = public_path("upload/buddy/" . $thumb_name);
            file_put_contents($thumb_path, $data);

            $buddy->profile_photo  = $thumb_name; 

        }

        $buddy->name =  $req->name;
        $buddy->email =  $req->email;
        $buddy->phone =  $req->number;
        $buddy->gender =  $req->gender;
        $buddy->lang =  $req->language;
        $buddy->dob = $req->dob;
        $buddy->location = $req->location;
        $buddy->availability = $req->availability;
        $buddy->areas_of_interest = $req->interest;
        $buddy->skills = $req->skills;
        $buddy->spiritual_tradition = $req->tradition;
        $buddy->experience = $req->experience;
        $buddy->refer = $req->references;
        $buddy->status = 0;
        $buddy->save();

        return redirect()->back()->with('success', 'Buddy Created Wait For Admin Confirmation!!');

    }

    public function filterspritualVolunteer(Request $req){
        $Destination = SpiritualVolunteers::select('location','id')->groupby('location')->where('status',1)->get();

        $row = [];
        if($req->my_range){
            foreach(explode(';', $req->my_range) as $rr){
                $row[] += $rr ;
            };
        }

        $filter = $req->locationcheckbox;
        $location = $req->cities;
        $tradition = $req->spritualTradition;

        $buddy = SpiritualVolunteers::WHERE('status','=','1')
        ->where(function($q) use($location){
            if($location != null){
                foreach ($location as $key)
                {
                   $q->orWhere('location','=',$key);
                }
            }
        })
        ->where(function($q) use($filter){
            if($filter != null){
                foreach ($filter as $key)
                {
                   $q->orWhere('areas_of_interest','=',$key);
                }
            }
        })
        ->where(function($q) use($tradition){
            if($tradition != null){
                foreach ($tradition as $key)
                {
                   $q->orWhere('spiritual_tradition','=',$key);
                }
            }
        })
        ->get();
        return view('frontend.findMyTravelBuddy',['buddys'=>$buddy,'Destinations'=>$Destination]);
    }


    public function postbookTicket(Request $req){

        $bookingDetails = json_encode($req->all());
        $eventId = $this->memberObj['id'];

        $event = Event::select('ticket_type')->where('id',$eventId)->where('status',1)->first();
        if($event->ticket_type == 1){
            $inputObjB = new \stdClass();
            $inputObjB->url = url('book-ticket-seat');
            $inputObjB->params = 'event_id='.$eventId.'&bookDetails='.$bookingDetails;
            $subLink = Common::encryptLink($inputObjB);
        }else{
            $inputObjB = new \stdClass();
            $inputObjB->url = url('book-ticket-slot');
            $inputObjB->params = 'event_id='.$eventId.'&bookDetails='.$bookingDetails;
            $subLink = Common::encryptLink($inputObjB);
        }
        return redirect($subLink);
    }
 

    public function bookTicketSeat(){
        $eventId = $this->memberObj['event_id'];
        $bookDetails = $this->memberObj['bookDetails'];
        $timeSlot = json_decode($bookDetails)->time_radio;
        $timeDate = \Carbon\Carbon::parse(json_decode($bookDetails)->date_radio)->format('Y-m-d');
        $event = Event::where('id',$eventId)->where('status',1)->first();
        $ticket = Ticket::Where('event_id',$eventId)->with('childOrder')->where('status',1)->where('is_deleted',0)->get();
        return view('frontend.book-event.book-seats',compact('ticket','event','bookDetails','timeSlot','timeDate'));
    }

 
    public function postbookTicketSeat(Request $req){
        
        $event_id = $this->memberObj['event_id'];
        $booking = $this->memberObj['bookDetails'];
        $bookDetails = json_decode($booking);

        $data = [
            'eventId'=>$event_id,
            'date'=>$bookDetails->date_radio,
            'time'=>$bookDetails->time_radio,
            'totalSeats'=>$bookDetails->seatcheck,
            'seatSlot'=>$req->seatChecked,
        ];

        $ticket = [];
        foreach($req->seatChecked as $key){
            $seatDetails = (json_decode($key));
            array_push($ticket,$seatDetails[2]);
        }

        session()->forget('eventTicketBook');
        session()->put('eventTicketBook', $data);

        if(\Session::has('eventTicketBook')){
            $inputObjB = new \stdClass();
            $inputObjB->url = url('confirm-ticket-book');
            $inputObjB->params = 'id='.json_encode($ticket).'&type=advance';
            // $inputObjB->params = 'event_id='.$eventId.'&bookDetails='.$bookingDetails;
            $subLink = Common::encryptLink($inputObjB);
            return redirect($subLink);
        }
        return redirect()->back()->with('error','Your Session Expired. Try Again');
    }


    // Normal
    public function bookTicketSlots(Request $req){
        $eventId = $this->memberObj['event_id'];
        $bookDetails = $this->memberObj['bookDetails'];
        $event = Event::where('id',$eventId)->where('status',1)->first();
        $ticket = Ticket::Where('event_id',$eventId)->where('status',1)->where('is_deleted',0)->get();
        return view('frontend.book-event.choose-ticket',compact('ticket','event','bookDetails'));
    }

    public function postbookTicketSlots(Request $req){
        $event_id = $this->memberObj['event_id'];
        $booking = $this->memberObj['bookDetails'];
        $bookDetails = json_decode($booking);

        $data = [
            'eventId'=>$event_id,
            'date'=>$bookDetails->date_radio,
            'time'=>$bookDetails->time_radio,
            'totalSeats'=>$bookDetails->seatcheck,
        ];

        session()->forget('eventTicketBook');
        session()->put('eventTicketBook', $data);
        if(\Session::has('eventTicketBook')){
            $inputObjB = new \stdClass();
            $inputObjB->url = url('confirm-ticket-book');
            $inputObjB->params = 'id='.$req->ticketId;
            $subLink = Common::encryptLink($inputObjB);
            return redirect($subLink);
        }
        return redirect()->back()->with('error','Your Session Expired. Try Again');

    }

    public function buyBookTicket(){
        if(\Session::has('ticketBooking')){
            // $bookingDetails = \Session::get('ticketBooking');
            // $ticketId = [];
            // foreach($bookingDetails['seatSlot'] as $items){
            //     $array = json_decode($items);
            //    dd($array);
            //     // array_push($ticketId,$ticketData[2]);
            // }
            // dd($ticketId);
            // $taxData = Tax::select('name','price','amount_type')->where('status',1)->get();
            // $ticketData = Ticket::select('id','name','price','event_id','ticket_sold','discount_amount','discount_type','price','pay_now','pay_place')->with('event')->whereIN('id',[$ticketId])->get();
            return view('frontend.book-event.buy-book-ticket');
        }


        return redirect()->back()->with('error','Your Session Expired. Try Again');

      

        // $inputObj = new \stdClass();
        // $inputObj->params = 'id='.$ticketId;
        // $inputObj->url = url('calculate-book-amount');
        // $ticketCheckLink = Common::encryptLink($inputObj);

        // $inputObjB = new \stdClass();
        // $inputObjB->url = url('store-book-ticket-razor');
        // $inputObjB->params = 'id='.$ticketId;
        // $subLink = Common::encryptLink($inputObjB);

        // return view('frontend.book-event.confirm-ticket-book',compact('ticketData','totalPersons','taxData','ticketCheckLink','subLink','data'));



    }


}
