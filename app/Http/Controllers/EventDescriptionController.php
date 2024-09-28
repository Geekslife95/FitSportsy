<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventDescription;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eventData = EventDescription::select('id','title','description')->where('status',1);
        if(Auth::user()->hasRole('Organizer')){
            $eventData->where('user_id',Auth::user()->id);
        }
        if(!empty($request->search)){
            $eventData->where('title','like','%'.$request->search.'%');
        }
        $eventData = $eventData->paginate(50);
        return view('admin.event-description.index',compact('eventData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.event-description.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>"required",
            'description'=>'required'
        ]);
        $user = Auth::user()->id;
        $data = $request->all();
        $data['status'] = 1;
        $data['user_id'] = $user;
        EventDescription::create($data);
        return redirect('eventss-description')->withStatus(__('Event Description has added successfully.'));
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
        $eventData = EventDescription::select('id','title','description')->findorfail($id);
        return view('admin.event-description.edit',compact('eventData'));
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
        EventDescription::where('id',$id)->update(['description'=>$request->description,'title'=>$request->title,'updated_at'=>date("Y-m-d H:i:s")]);
        Event::where('event_description_id',$id)->update(["description"=>$request->description]);
        return redirect('eventss-description')->withStatus(__('Event Name has updated successfully.'));
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
