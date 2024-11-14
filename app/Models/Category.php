<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    protected $fillable = [
        'name',
        'image',
        'status',
        'slug',
        'banner_image',
        'redirect_link',
        'type',
        'order_num',
        'benefits'
    ];

    protected $table = 'category';
    protected $appends = ['imagePath'];
    
    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }

    public function events(){
        return $this->hasMany('App\Models\Event', 'category_id', 'id');
    }

    public function events2(){
        return $this->hasMany('App\Models\Event', 'category_id', 'id');
    }

    public function coachings()
    {
        return $this->hasMany('App\Models\Coach', 'category_id', 'id')->where('is_active', Coach::ACTIVE);
    }


}
