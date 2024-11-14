<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;
    const ACTIVE = 1;
    const INACTIVE = 2;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    public function coachingPackage()
    {
        return $this->hasOne(CoachingPackage::class)->where('is_active', CoachingPackage::STATUS_ACTIVE);
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
