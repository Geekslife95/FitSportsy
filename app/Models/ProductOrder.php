<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;

    public function order_details(){
        return $this->hasMany(ProductOrderDetail::class)->with('product:id,product_name,image');
    }

    public function user(){
        return $this->belongsTo(AppUser::class,'app_user_id','id');
    }
    
}
