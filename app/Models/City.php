<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_name'
    ];

    public function selectCity(){
        return $this->hasMany('App\Models\Event', 'city_name', 'city_name')->where('status',1)->where('is_deleted',0);
    }
    
}
