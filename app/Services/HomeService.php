<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Coach;
use App\Models\CoachingPackage;
use App\Models\Product;

class HomeService
{
    public static function allBlogs()
    {
        return Blog::select('title', 'description', 'image', 'id')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->limit(10)->get();
    }

    public static function allHomeBanners()
    {
        return Banner::select('title', 'description', 'image', 'redirect_link')->where('status', 1)->get();
    }

    public static function allProducts()
    {
        return Product::select('image','product_name','product_price','rating','product_slug','quantity')
                        ->where('status',1)->inRandomOrder()->limit(10)->get();
    }

    public static function getCoachingDataByCity(string $selectedCity = 'All'){
        $coachingData = Coach::select('id','coaching_title','poster_image','venue_name')
                        ->with('coachingPackage',function($q){
                            $q->select('id','coach_id','package_price','discount_percent','session_days');
                        })->has('coachingPackage');
                        if($selectedCity != 'All'){
                            $coachingData->where('venue_city', $selectedCity);
                        }
        $coachingData = $coachingData->where('is_active', Coach::ACTIVE)->inRandomOrder()->limit(10)->get();
        return $coachingData;
    }

    
    public static function getCoachingDataByCityWithCategory(array $categoriesIds, string $selectedCity){
        $coachingData = Category::with([
            'coachings' => function ($query) use($selectedCity){
                if($selectedCity != 'All'){
                    $query->where('venue_name', $selectedCity);
                }
                $query->limit(10); // Get 10 per category
            },
            'coachings.coachingPackage' => function ($query) {
                $query->orderBy('created_at')->limit(1); // Get the first comment for each post
            }
        ])->whereIn('id', $categoriesIds)->get();
        return $coachingData;
    }



    public static function coachingBookDataById(int $id)
    {
        return Coach::select('*')->with('category',function($q){
            $q->select('id','name as category_name');
        })->where('is_active', Coach::ACTIVE)->where('id', $id)->first();
    }

    public static function getCoachingPackagesDataByCoachId(int $coachingId){
        return CoachingPackage::select('*')->where(['coach_id' => $coachingId, 'is_active' => CoachingPackage::STATUS_ACTIVE])->get();
    }

    public static function getRelateCoachingData($id, $selectedCity = 'All'){
        $coachingData = Coach::select('id','coaching_title','poster_image','venue_name')
                        ->with('coachingPackage',function($q){
                            $q->select('id','coach_id','package_price','discount_percent','session_days');
                        })->has('coachingPackage');
                        if($selectedCity != 'All'){
                            $coachingData->where('venue_city', $selectedCity);
                        }
        $coachingData = $coachingData->where('is_active', Coach::ACTIVE)->where('id', '!=', $id)->inRandomOrder()->limit(10)->get();
        return $coachingData;
    }

}

