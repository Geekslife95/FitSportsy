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
                    $query->where('venue_city', $selectedCity);
                }
                $query->limit(10); // Get 10 per category
                $query->whereHas('coachingPackage');
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

    public static function getRelateCoachingData($id, $selectedCity = 'All', $categoryId){
        $coachingData = Coach::select('id','coaching_title','poster_image','venue_name', 'venue_area', 'venue_address', 'venue_city')
                        ->with('coachingPackage',function($q){
                            $q->select('id','coach_id','package_price','discount_percent','session_days','description');
                        })->has('coachingPackage');
                        if($selectedCity != 'All'){
                            $coachingData->where('venue_city', $selectedCity);
                        }
        $coachingData = $coachingData->where('is_active', Coach::ACTIVE)->where('id', '!=', $id)->where('category_id', $categoryId)->inRandomOrder()->limit(10)->get();
        return $coachingData;
    }

    public static function getCoachingDataByCateoryId($selectedCity, $Id){
        $categoryData = Category::find($Id);
        $coaches = Coach::has('coachingPackage')->with('coachingPackage', function($query){
                            $query->limit(1);
                        })
                        ->where('is_active', Coach::ACTIVE)
                        ->where('category_id', $Id);
                if($selectedCity != 'All'){
                    $coaches->where('venue_city', $selectedCity);
                }        
        $coaches = $coaches->paginate(50);
        return ['coachesData' => $coaches, 'categoryData' => $categoryData];
    }
    

    public static function getCoachingDataByPackage(int $packageId)
    {
        $packageData = CoachingPackage::with('coaching')->where('id', $packageId)->first();
        return $packageData;
    }

    public static function checkedIfTicketSoldOut(int $id){
        return CoachingPackage::where(['coach_id' => $id, 'is_active' => CoachingPackage::STATUS_ACTIVE, 'is_sold_out' => 0])->count();
    }

}

