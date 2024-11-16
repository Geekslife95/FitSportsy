<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingPackageBooking extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_REMOVE = 2;

    public function coachingPackage(){
        return $this->belongsTo(CoachingPackage::class, 'coaching_package_id', 'id');
    }
    
   
}
