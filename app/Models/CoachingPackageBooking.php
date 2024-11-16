<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingPackageBooking extends Model
{
    use HasFactory;

    public function coachingPackage(){
        return $this->belongsTo(CoachingPackage::class, 'coaching_package_id', 'id');
    }
    
   
}
