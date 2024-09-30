<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\Setting;
use App\Http\Controllers\AppHelper;
use App\Models\User;
use App\Models\City;
use App\Models\AppUser;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use App\Helpers\Common;
use App\Models\EventDescription;
use App\Models\EventGallery;
use App\Models\EventParent;

class EventController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $timezone = Common::siteGeneralSettings();
        $date = Carbon::now($timezone->timezone);
        $events  = Event::with(['category:id,name']);
        if(Auth::user()->hasRole('Organizer')){
            $events->with(['scanner:id,name,last_name'])->where('user_id',Auth::user()->id);
        }else{
            $events->with(['user:id,name,last_name']);
        }

        if(!empty($request->search)){
            $search = $request->search;
            $events->where(function($q) use($search){
                $q->where('events.name','like','%'.$search.'%');
                $q->orwhere('events.temple_name','like','%'.$search.'%');
                $q->orwhere('events.address','like','%'.$search.'%');
                $q->orwhereHas('category',function($a) use($search){
                    $a->where('name', 'LIKE', '%' . $search . '%');
                });
            });
        }

        if(!empty($request->city)){
            $city = $request->city;
            $events->where('events.city_name','=',$city);
        }

        $events->where([['is_deleted', 0], ['event_status', 'Pending']]);
        $events = $events->orderBy('status','DESC')->orderBy('event_type', 'ASC')->orderBy('start_time','ASC')->withCount('ticket')->paginate(50);
        $citys = City::get();
        // dd($events);
        return view('admin.event.index', compact('events','citys'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category = Category::where('status', 1)->orderBy('id', 'DESC')->get();
        $users = [];
        if (Auth::user()->hasRole('admin')) {
            $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
            $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
        } else if (Auth::user()->hasRole('Organizer')) {
            $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        $eventsData = EventParent::where('status',1);
        if(Auth::user()->hasRole('Organizer')){
            $eventsData->where('user_id',Auth::user()->id);
        }
        $eventsData = $eventsData->get();
        $descriptionData = EventDescription::where('status',1);
        if(Auth::user()->hasRole('Organizer')){
            $descriptionData->where('user_id',Auth::user()->id);
        }
        $descriptionData = $descriptionData->get();
        return view('admin.event.create', compact('category', 'users', 'scanner','eventsData','descriptionData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_parent_id' => 'bail|required',
            'category_id' => 'bail|required',
            'status' => 'bail|required',
            'event_description_id' => 'bail|required',
        ]);

        if(empty($request->temple_name)){
            return redirect()->back()->withStatus('add one or more temples');
        }

        $mainImage = null;
        if ($request->hasFile('image')) {
            $mainImage = (new AppHelper)->saveImage($request);
            $dtImg = ['image'=>$mainImage,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")];
            EventGallery::insert($dtImg);
        }else{
            $mainImage = $request->img_name;
        }

        $bannerImage = null;
        if ($request->hasFile('banner')) {
            // (new AppHelper)->deleteFile($event->image);
            $image = $request->file('banner');
            $name = time().'-'.uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $bannerImage = $name;
        }

        $userId = $request->user_id;
        if (!Auth::user()->hasRole('admin')) {
            $userId = Auth::user()->id;
        }

        // ent parent and desc data
        $eventPData = EventParent::select('event_name')->where('id',$request->event_parent_id)->first();
        $eventDData = EventDescription::select('description')->where('id',$request->event_description_id)->first();

        $eventName = $eventPData->event_name;
        $eventDescription = $eventDData->description;

        $galleryImages = null;
        if($request->has('gallery_image')){
            $gallImage = [];
            foreach($request->file('gallery_image') as $image){
                $name = time().'-'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/upload');
                $image->move($destinationPath, $name);
                $gallImage[] = $name;
            }
            $galleryImages = implode(",",$gallImage);
        }

        $days = null;
        $slotArr = null;
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        if($request->event_type==2){
            if(!empty($request->days)){
                $days = implode(",",$request->days);
            }
            if(!empty($request->slot_start)){
                foreach($request->slot_start as $key=>$val){
                    $slotArr[] = [
                        'start_time'=>$val,
                        'end_time'=>$request->slot_end[$key],
                    ];
                }
            }

            $startTime = null;
            $endTime = null;
        }

        if($request->event_type==3){
            $startTime = null;
            $endTime = null;
            $slotArr = null;
        }



        $dataInsert = [];
        foreach($request->temple_name as $k=>$val){
            $dataInsert[] = [
                'temple_name'=>$val,
                'gallery'=>$galleryImages,
                'user_id'=>$userId,
                'name'=>$eventName,
                'type'=>null,
                'url'=>null,
                'scanner_id'=>$request->scanner_id,
                'image'=>$mainImage,
                'banner_img'=>$bannerImage,
                // 'people'=>$request->people,
                'address'=>$request->address[$k],
                'category_id'=>$request->category_id,
                'city_name'=>$request->city_name[$k],
                'start_time'=>$startTime,
                'end_time'=>$endTime,
                'recurring_days'=>$days,
                'time_slots'=>$slotArr!=null ? json_encode($slotArr) : null,
                'description'=>$eventDescription,
                'tags'=>$request->tags,
                'status'=>$request->status,
                'ticket_type'=>$request->ticket_type,
                'event_cat'=>$request->event_type_cat,
                'event_type'=>$request->event_type,
                'event_status'=>"Pending",
                'event_parent_id'=>$request->event_parent_id,
                'event_description_id'=>$request->event_description_id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s"),
            ];
        }

        $cityUniq = array_unique($request->city_name);

        $cityData = City::whereIn('city_name',$cityUniq)->pluck('city_name')->toArray();
        // if($cityData){
            \Cache::forget('event-cities');
            $insCity = [];
            foreach($cityUniq as $vl){
                if(!in_array($vl,$cityData)){
                    $insCity[] = [
                        'city_name'=>$vl,
                        'created_at'=>date("Y-m-d H:i:s"),
                        'updated_at'=>date("Y-m-d H:i:s")
                    ];
                }
            }
            if($insCity){
                City::insert($insCity);
            }
            // City::create(['city_name'=>$request->city_name,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
        // }
        Event::insert($dataInsert);
        return redirect()->route('events.index')->withStatus(__('Event has added successfully.'));
    }

    public function show($event)
    {
        $event = Event::with(['category', 'organization'])->find($event);
        $event->ticket = Ticket::where([['event_id', $event->id], ['is_deleted', 0]])->orderBy('id', 'DESC')->get();
        (new AppHelper)->eventStatusChange();
        $event->sales = Order::with(['customer:id,name', 'ticket:id,name'])->where('event_id', $event->id)->orderBy('id', 'DESC')->get();
        foreach ($event->ticket as $value) {
            $value->used_ticket = Order::where('ticket_id', $value->id)->sum('quantity');
        }
        return view('admin.event.view', compact('event'));
    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category =  Category::where('status', 1)->orderBy('id', 'DESC')->get();
        $users = [];
        if (Auth::user()->hasRole('admin')) {
            $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
            $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
        } else if (Auth::user()->hasRole('Organizer')) {
            $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        $eventsData = EventParent::where('status',1);
        if(Auth::user()->hasRole('Organizer')){
            $eventsData->where('user_id',Auth::user()->id);
        }
        $eventsData = $eventsData->get();
        $descriptionData = EventDescription::where('status',1);
        if(Auth::user()->hasRole('Organizer')){
            $descriptionData->where('user_id',Auth::user()->id);
        }
        $descriptionData = $descriptionData->get();
        // dd($event);

        return view('admin.event.edit', compact('event', 'category', 'users', 'scanner','eventsData','descriptionData'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'event_parent_id' => 'bail|required',
            'category_id' => 'bail|required',
            'status' => 'bail|required',
            'event_description_id' => 'bail|required',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            (new AppHelper)->deleteFile($event->image);
            $data['image'] = (new AppHelper)->saveImage($request);
            $dtImg = ['image'=>$data['image'],'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")];
            EventGallery::insert($dtImg);
        }

        if ($request->hasFile('banner')) {
            // (new AppHelper)->deleteFile($event->image);
            $image = $request->file('banner');
            $name = time().'-'.uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['banner_img'] = $name;
        }

        $eventPData = EventParent::select('event_name')->where('id',$request->event_parent_id)->first();
        $eventDData = EventDescription::select('description')->where('id',$request->event_description_id)->first();
        $eventName = $eventPData->event_name;
        $eventDescription = $eventDData->description;
        // $data['event_parent_id'] = $eventPData->id;
        $data['name'] = $eventName;
        $data['description'] = $eventDescription;

        $days = null;
        $slotArr = null;
        if($request->event_type==2){
            if(!empty($request->days)){
                $days = implode(",",$request->days);
            }
            if(!empty($request->slot_start)){
                foreach($request->slot_start as $key=>$val){
                    $slotArr[] = [
                        'start_time'=>$val,
                        'end_time'=>$request->slot_end[$key],
                    ];
                }
            }
        }
        // check if city exist in cities table
        $data['recurring_days'] = $days;
        $data['time_slots'] = $slotArr!=null ? json_encode($slotArr) : null;
        $cityData = City::where('city_name',$request->city_name)->first();
        if(!$cityData){
            \Cache::forget('event-cities');
            City::create(['city_name'=>$request->city_name,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
        }

        // dd($data);
        $event = Event::find($event->id)->update($data);
        return redirect()->route('events.index')->withStatus(__('Event has updated successfully.'));
    }

    public function destroy(Event $event)
    {
        try {
            Event::find($event->id)->update(['is_deleted' => 1, 'event_status' => 'Deleted']);
            $ticket = Ticket::where('event_id', $event->id)->update(['is_deleted' => 1]);
            return true;
        } catch (Throwable $th) {
            return response('Data is Connected with other Data', 400);
        }
    }

    public function getMonthEvent(Request $request)
    {
        (new AppHelper)->eventStatusChange();
        $day = Carbon::parse($request->year . '-' . $request->month . '-01')->daysInMonth;
        if (Auth::user()->hasRole('Organizer')) {
            $data = Event::whereBetween('start_time', [$request->year . "-" . $request->month . "-01 12:00",  $request->year . "-" . $request->month . "-" . $day . "  23:59"])
                ->where([['status', 1], ['is_deleted', 0], ['user_id', Auth::user()->id]])
                ->orderBy('id', 'DESC')
                ->get();
        }
        if (Auth::user()->hasRole('admin')) {
            $data = Event::whereBetween('start_time', [$request->year . "-" . $request->month . "-01 12:00",  $request->year . "-" . $request->month . "-" . $day . " 23:59"])
                ->where([['status', 1], ['is_deleted', 0]])->orderBy('id', 'DESC')->get();
        }
        foreach ($data as $value) {
            $value->tickets = Ticket::where([['event_id', $value->id], ['is_deleted', 0]])->sum('quantity');
            $value->sold_ticket = Order::where('event_id', $value->id)->sum('quantity');
            $value->day = $value->start_time->format('D');
            $value->date = $value->start_time->format('d');
            $value->average = $value->tickets == 0 ? 0 : $value->sold_ticket * 100 / $value->tickets;
        }
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function eventGallery($id)
    {
        $data  = Event::find($id);
        return view('admin.event.gallery', compact('data'));
    }

    // public function addEventGallery(Request $request)
    // {
    //     $event = array_filter(explode(',', Event::find($request->id)->gallery));
    //     if ($request->hasFile('file')) {
    //         $image = $request->file('file');
    //         $name = uniqid() . '.' . $image->getClientOriginalExtension();
    //         $destinationPath = public_path('/images/upload');
    //         $image->move($destinationPath, $name);
    //         array_push($event, $name);
    //         Event::find($request->id)->update(['gallery' => implode(',', $event)]);
    //     }
    //     return true;
    // }

    public function addEventGallery(Request $request)
    {
        $event = array_filter(explode(',', Event::find($request->id)->gallery));
        if($request->has('event_gallery')){
            $base64_image       = $request->event_gallery;
            list($type, $data)  = explode(';', $base64_image);
            list(, $data)       = explode(',', $data);
            $data               = base64_decode($data);
            $thumb_name         = "thumb_".date('YmdHis').'.png';
            $thumb_path         = public_path("/images/upload/" . $thumb_name);
            file_put_contents($thumb_path, $data);

            array_push($event, $thumb_name);
            Event::find($request->id)->update(['gallery' => implode(',', $event)]);
        }
        return redirect()->back()->with('success','Event gallery has added successfully.');
       
    }

    public function removeEventImage($image, $id)
    {
        $gallery = array_filter(explode(',', Event::find($id)->gallery));
        if (count(array_keys($gallery, $image)) > 0) {
            if (($key = array_search($image, $gallery)) !== false) {
                unset($gallery[$key]);
            }
        }
        $aa = implode(',', $gallery);
        $data = Event::find($id);
        $data->gallery = $aa;
        $data->update();
        return redirect()->back();
    }

    public function getEventGalleries(){
        $galleryData = EventGallery::select('image');
        if(Auth::user()->hasRole('Organizer')){
            $galleryData->where('user_id',Auth::user()->id);
        }
        $galleryData = $galleryData->paginate(100);
        return view('admin.event.get-event-galleries',compact('galleryData'));
    }

    public function eventsBulkUpload(){
        $category = Category::where('status', 1)->orderBy('id', 'DESC')->get();
        $users = [];
        if (Auth::user()->hasRole('admin')) {
            $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
            $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
        } else if (Auth::user()->hasRole('Organizer')) {
            $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        $eventsData = EventParent::where('status',1)->get();
        $descriptionData = EventDescription::where('status',1)->get();
        return view('admin.event.events-bulk-upload',compact('category', 'users', 'scanner','eventsData','descriptionData'));
    }

    public function storeEventBulkUpload(Request $request){
        $request->validate([
            'event_parent_id' => 'bail|required',
            'category_id' => 'bail|required',
            'event_description_id' => 'bail|required',
        ]);

        require_once app_path("Libraries/PhpSpreadsheet/autoload.php");
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if(isset($_FILES['excel_file']['name']) && in_array($_FILES['excel_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['excel_file']['name']);
            $extension = end($arr_file);
            if('csv' == $extension){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            }elseif('xls' == $extension){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['excel_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $mainImage = null;
            if ($request->hasFile('image')) {
                $mainImage = (new AppHelper)->saveImage($request);
                $dtImg = ['image'=>$mainImage,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")];
                EventGallery::insert($dtImg);
            }else{
                $mainImage = $request->img_name;
            }
            $bannerImage = null;
            if ($request->hasFile('banner')) {
                // (new AppHelper)->deleteFile($event->image);
                $image = $request->file('banner');
                $name = time().'-'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/upload');
                $image->move($destinationPath, $name);
                $bannerImage = $name;
            }

            $userId = $request->user_id;
            // ent parent and desc data
            $eventPData = EventParent::select('event_name')->where('id',$request->event_parent_id)->first();
            $eventDData = EventDescription::select('description')->where('id',$request->event_description_id)->first();
            $eventName = $eventPData->event_name;
            $eventDescription = $eventDData->description;
            $galleryImages = null;
            if($request->has('gallery_image')){
                $gallImage = [];
                foreach($request->file('gallery_image') as $image){
                    $name = time().'-'.uniqid() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/upload');
                    $image->move($destinationPath, $name);
                    $gallImage[] = $name;
                }
                $galleryImages = implode(",",$gallImage);
            }

            $days = null;
            $slotArr = null;
            $startTime = $request->start_time;
            $endTime = $request->end_time;
            if($request->event_type==2){
                if(!empty($request->days)){
                    $days = implode(",",$request->days);
                }
                if(!empty($request->slot_start)){
                    foreach($request->slot_start as $key=>$val){
                        $slotArr[] = [
                            'start_time'=>$val,
                            'end_time'=>$request->slot_end[$key],
                        ];
                    }
                }

                $startTime = null;
                $endTime = null;
            }

            if($request->event_type==3){
                $startTime = null;
                $endTime = null;
                $slotArr = null;
            }
            $dataInsert = [];
            $cities = [];
            if(isset($sheetData[1])){
                \DB::beginTransaction();
                foreach($sheetData as $key=>$val){
                    if($key > 0){
                        $dataInsert[] = [
                            'temple_name'=>$val[0],
                            'gallery'=>$galleryImages,
                            'user_id'=>$userId,
                            'banner_img'=>$bannerImage,
                            'name'=>$eventName,
                            'type'=>null,
                            'url'=>null,
                            'scanner_id'=>$request->scanner_id,
                            'image'=>$mainImage,
                            // 'people'=>100,
                            'address'=>$val[1],
                            'category_id'=>$request->category_id,
                            'city_name'=>$val[2],
                            'start_time'=>$startTime,
                            'end_time'=>$endTime,
                            'recurring_days'=>$days,
                            'time_slots'=>$slotArr!=null ? json_encode($slotArr) : null,
                            'description'=>$eventDescription,
                            'tags'=>'temples',
                            'status'=>0,
                            'ticket_type'=>$request->ticket_type,
                            'event_cat'=>$request->event_type_cat,
                            'event_type'=>$request->event_type,
                            'event_status'=>"Pending",
                            'event_parent_id'=>$request->event_parent_id,
                            'event_description_id'=>$request->event_description_id,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s"),
                        ];
                        $cities[] = $val[2];
                    }
                }
                if($dataInsert){
                    Event::insert($dataInsert);
                }

                if($cities){
                    $cityUniq = array_unique($cities);
                    $checkCData = City::whereIn('city_name',$cityUniq)->pluck('city_name')->toArray();
                    $newCity = [];
                    foreach($cityUniq as $val){
                        if(!in_array($val,$checkCData)){
                            $newCity[] = [
                                'city_name'=>$val,
                                'created_at'=>date("Y-m-d H:i:s"),
                                'updated_at'=>date("Y-m-d H:i:s"),
                            ];
                        }
                    }
                    if($newCity){
                        City::insert($newCity);
                        \Cache::forget('event-cities');
                    }

                }

                \DB::commit();
            }
            return redirect('events')->with('success','Data uploaded successfully!!');
        }
        return redirect('events-bulk-upload');

    }

    public function setULocation(Request $request){
        $lat = $request->latx;
        $long = $request->lonx;
        $latlong = "latlng=$lat,$long";
        $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?'.$latlong.'&sensor=false&key=AIzaSyCOXDqUNe7kQ1Dezz5YkHNG8JJATJ01otU');
        $output= json_decode($geocode);
        foreach($output->results[0]->address_components as $val){
            if($val->types[0]=='locality'){
                $cityName =  $val->long_name;
                // check city has any events
                $data = Event::where('city_name',$cityName)->first();
                if($data){
                    \Session::put('CURR_CITY',$cityName);
                    return response()->json(['s'=>1,'name'=>$cityName]);
                }
            }   
        }
        return response()->json(['s'=>0]);
    }

}
