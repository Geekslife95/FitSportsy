<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'customer_id',
        'organization_id',
        'event_id',
        'ticket_id',
        'coupon_id',
        'quantity',
        'coupon_discount',
        'seat_details',
        'payment',
        'tax',
        'org_commission',
        'payment_type',
        'payment_status',
        'payment_token',
        'order_status',
        'org_pay_status',
        'ticket_price',
        'ticket_date',
        'ticket_slot',
        'checkins_count'
    ];

    protected $table = 'orders';

    protected $appends = ['review'];

    public function event()
    {
        return $this->hasOne('App\Models\Event', 'id', 'event_id');
    }
    public function ticket()
    {
        return $this->hasOne('App\Models\Ticket', 'id', 'ticket_id');
    }
    public function customer()
    {
        return $this->hasOne('App\Models\AppUser', 'id', 'customer_id');
    }
    public function organization()
    {
        return $this->hasOne('App\Models\User', 'id', 'organization_id');
    }  
      public function orderchild()
    {
        return $this->hasOne('App\Models\OrderChild', 'id', 'organization_id');
    }
    public function ordertax()
    {
        return $this->hasOne('App\Models\OrderTax', 'id', 'organization_id');
    }

    public function getReviewAttribute()
    {
        return Review::where('order_id',$this->attributes['id'])->first();
    }

    public function orderchildC(){
        return $this->hasOne('App\Models\OrderChild');
    }

    public function scannerEvent(){
        $scannerId = Auth::id();
        return $this->hasOne('App\Models\Event', 'id', 'event_id')->where('scanner_id',$scannerId);
    }
   

}
