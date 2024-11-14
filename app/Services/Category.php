<?php
namespace App\Services;

use App\Helpers\Common;
use App\Models\Category as ModelsCategory;

class Category{

    public function getActiveCategories(){
        return ModelsCategory::select('id','name')->where('status',Common
        ::STATUS_ACTIVE)->get();
    }
    
}