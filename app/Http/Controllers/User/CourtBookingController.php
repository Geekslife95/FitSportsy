<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TempCourtBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use stdClass;
use Symfony\Component\HttpFoundation\Response;
class CourtBookingController extends Controller
{
    private function lastCourtBookDataByUserId(int $userId){
        return TempCourtBooking::where('created_by',$userId)->orderBy('id','desc')->first();
    }

    public function courtBooking(){
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        $tempData = [];
        if(!$courtBookData){
            $tempData['venue_name'] = '';
            $tempData['venue_area'] = '';
            $tempData['venue_address'] = '';
            $tempData['venue_city'] = '';
        }else{
            $tempData = json_decode($courtBookData->basic_information);
        }
        $data['bookData'] = is_array($tempData) ? (object) $tempData : $tempData;
        return view('user.court-booking.court-booking',$data);
    }


    public function postCourtBooking(Request $request){
        // dd($request->all());                        
        $request->validate([
            'venue_name'=>'required',
            'venue_area'=>'required',
            'venue_address'=>'required',
            'venue_city'=>'required',
        ]);
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        $data = $request->except('_token');
        if($courtBookData){
            TempCourtBooking::where('id',$courtBookData->id)->update([
                'basic_information'=>json_encode($data),
            ]);
        }else{
            $courtBookObj = new TempCourtBooking();
            $courtBookObj->basic_information = json_encode($data);
            $courtBookObj->court_information = null;
            $courtBookObj->description = null;
            $courtBookObj->created_by = Auth::id();
            $courtBookObj->save();
        }
        return redirect('user/court-information')->with('success','Basic information added successfully...');
    }

    public function courtInformation(){
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        if(!$courtBookData){
            return redirect('user/court-booking');
        }
        $tempData = [];
        if(is_null($courtBookData->court_information)){
            $tempData = [
                [''=>[
                'court_name'=>'',
                'from_date'=>'',
                'to_date'=>'',
                'from_time'=>'',
                'to_time'=>'',
                'duration'=>'',
                ]
                ]
            ];
        }else{
            $tempData = json_decode($courtBookData->court_information);
        }
        $data['bookData'] = is_array($tempData) ? (object) $tempData : $tempData;
        return view('user.court-booking.court-information',$data);
    }

    public function postCourtInformation(Request $request){
        dd($request->all());
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        $data = [];
        foreach($request->court_name as $k=>$court){
            // $data
        }
        TempCourtBooking::where('id',$courtBookData->id)->update([
            'basic_information'=>json_encode($data),
        ]);
    }
}

