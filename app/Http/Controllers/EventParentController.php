<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventParent;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eventData = EventParent::select('id','event_name')->where('status',1);
        if(Auth::user()->hasRole('Organizer')){
            $eventData->where('user_id',Auth::user()->id);
        }
        if(!empty($request->search)){
            $eventData->where('event_name','like','%'.$request->search.'%');
        }
        $eventData = $eventData->paginate(50);
        return view('admin.event-parent.index',compact('eventData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.event-parent.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->event_name)){
            $insData = [];
            foreach($request->event_name as $val){
                $insData[] = [
                    'event_name'=>$val,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s"),
                    'status'=>1,
                    'user_id'=>Auth::user()->id
                ];
            }
            EventParent::insert($insData);
        }
        return redirect('events-parent')->withStatus(__('Event Name has added successfully.'));
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
        $eventData = EventParent::select('id','event_name')->findorfail($id);
        return view('admin.event-parent.edit',compact('eventData'));
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
        EventParent::where('id',$id)->update(['event_name'=>$request->event_name,'updated_at'=>date("Y-m-d H:i:s")]);
        Event::where('event_parent_id',$id)->update(["name"=>$request->event_name]);
        return redirect('events-parent')->withStatus(__('Event Name has updated successfully.'));
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
