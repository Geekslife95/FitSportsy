<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Ticket;
use App\Models\Event;
use Auth;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use App\Helpers\Common;
class TicketController extends Controller
{
    
    public function index($id)
    {
        abort_if(Gate::denies('ticket_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = Event::select('event_type','id','temple_name','start_time','end_time','recurring_days')->find($id);
        $ticket = Ticket::where([['event_id', $id], ['is_deleted', 0]])->orderBy('id', 'DESC')->get();
        return view('admin.ticket.index', compact('ticket', 'event'));
    }

    public function create($id)
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event = Event::select('name','id','event_type','temple_name','start_time','end_time','recurring_days')->find($id);
        return view('admin.ticket.create', compact('event'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'quantity' => 'bail|required',
            'ticket_per_order' => 'bail|required',
        ]);
        $data = $request->all();
        if ($request->type == "free") {
            $data['price'] = 0;
        }
        $data['allday'] = 0;
        $ticektNum = Common::generateUniqueTicketNum(chr(rand(65, 90)) . chr(rand(65, 90)) . '-' . rand(999, 10000)); 
        $data['ticket_number'] = $ticektNum;
        $data['discount_type'] = $request->disc_type;
        $data['discount_amount'] = $request->discount;
        $data['convenience_type'] = $request->convenience_type;
        $data['convenience_amount'] = $request->convenience_fee;
        $data['pay_now'] = ($request->pay_now == null ? 0 : $request->pay_now);
        $data['pay_place'] = ($request->pay_place == null ? 0 : $request->pay_place);
        $event = Event::find($request->event_id);
        $data['user_id'] = $event->user_id;
        Ticket::create($data);
        return redirect($request->event_id . '/' . preg_replace('/\s+/', '-', $event->name) . '/tickets')->withStatus(__('Ticket has added successfully.'));
    }

    public function show(Ticket $ticket)
    {
    }

    public function edit($id)
    {
        abort_if(Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ticket = Ticket::find($id);
        $event = Event::find($ticket->event_id);

        return view('admin.ticket.edit', compact('ticket', 'event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required',
            'quantity' => 'bail|required',
            'ticket_per_order' => 'bail|required',
            'price' =>  'bail|required_if:type,paid',
        ]);
        $data = $request->all();
        if ($request->type == "free") {
            $data['price'] = 0;
        }
        $data['allday'] = 0;
        $data['discount_type'] = $request->disc_type;
        $data['discount_amount'] = $request->discount;
        $data['convenience_type'] = $request->convenience_type;
        $data['convenience_amount'] = $request->convenience_fee;
        $data['pay_now'] = ($request->pay_now == null ? 0 : $request->pay_now);
        $data['pay_place'] = ($request->pay_place == null ? 0 : $request->pay_place);
        $event = Event::find($request->event_id);
        Ticket::find($id)->update($data);
        return redirect($request->event_id . '/' . preg_replace('/\s+/', '-', $event->name) . '/tickets')->withStatus(__('Ticket has updated successfully.'));
    }

    public function destroy(Ticket $ticket)
    {
    }

    public function deleteTickets($id)
    {
        try {
            $ticket = Ticket::find($id)->update(['is_deleted' => 1]);
            return true;
        } catch (Throwable $th) {
            return response('Data is Connected with other Data', 400);
        }
    }
}
