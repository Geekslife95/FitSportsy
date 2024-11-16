<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingPackage extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    const STATUS_ACTIVE = 1;
    const STATUS_REMOVED = 2;
    const PLATFORM_FEE_ME = 1;
    const PLATFORM_FEE_BUYER = 2;
    const GATEWAY_FEE_ME = 1;
    const GATEWAY_FEE_BUYER = 2;

    public function coaching(){
        return $this->belongsTo(Coach::class, 'coach_id', 'id');
    }
}
