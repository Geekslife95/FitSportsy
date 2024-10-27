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
        return $this->hasMany(Coach::class, 'venue_city', 'city_name')->where('is_active',Coach::ACTIVE);
    }
}
