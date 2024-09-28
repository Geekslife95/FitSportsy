<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'user_id',
        'ticket_number',
        'name',
        'type',
        'quantity',
        'ticket_per_order',
        'start_time',
        'end_time',
        'price',
        'description',
        'status',
        'is_deleted',
        'allday',
        'maximum_checkins',
        'ticket_sold',
        'discount_type',
        'discount_amount',
        'convenience_type',
        'convenience_amount',
        'pay_now',
        'pay_place'
    ];

    protected $table = 'tickets';
    protected $dates = ['start_time','end_time'];

    public function total_orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function event(){
        return $this->belongsTo('App\Models\Event')->select('events.id','gallery','events.name','address','temple_name','event_type','c.name as cat_name','recurring_days','time_slots')->join('category as c','c.id','category_id');
    }

    public function events(){
        return $this->belongsTo('App\Models\Event','event_id','id');
    }

}
