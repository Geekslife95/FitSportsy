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
        return $this->hasMany(Coach::class, 'city_name', 'venue_city')->where('is_active',Coach::ACTIVE);
    }
}
