<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Common;
use Illuminate\Support\Carbon;

class EventResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $inputObjT = new \stdClass();
        $inputObjT->url = url('get-tickets-d-events');
        $inputObjT->params = 'id='.$this->id;
        $this->encLink = Common::encryptLink($inputObjT);
        return [

            'ticket_link' => $this->encLink,
            'name' => $this->name,
            'temple_name' => $this->temple_name,
            'address' => $this->address,
            'event_type' => $this->event_type,
            'time_slots' => $this->time_slots,
            'start_time' => $this->start_time ? Carbon::parse($this->start_time)->format('H:i:s') : null,
            'end_time' => $this->end_time ? Carbon::parse($this->end_time)->format('H:i:s') : null,

        ];
    }
}
