<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Popups;
use App\Services\HomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use stdClass;

class HomeController extends Controller
{
    public function index()
    {
        $selectedCity = Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'All';
        if($selectedCity != 'All'){
            $data['popup'] = Popups::Where('city', $selectedCity)->orderBy('id','DESC')->first();
        }else{
            $data['popup'] = "";
        }
        $data['blog'] = HomeService::allBlogs();
        $data['banner'] = HomeService::allHomeBanners();
        $data['products'] = HomeService::allProducts();
        $categories = Category::whereHas('coachings', function ($query) use($selectedCity){
            if($selectedCity != 'All'){
                $query->where('venue_name', '!=' ,$selectedCity);
            }
            $query->whereHas('coachingPackage');
        })->get()->toArray();
        $categoriesIds = [0];
        if(count($categories)){
            $categoriesIds = array_column($categories, 'id');
        }
        $data['coachingsData'] = HomeService::getCoachingDataByCityWithCategory($categoriesIds, $selectedCity);
        return view('home.index', $data);
    }

    public function coachingBook(int $id, string $title)
    {
        $selectedCity = Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'All';
        $data['coachData'] = HomeService::coachingBookDataById($id);
        $sessionDurationData = json_decode($data['coachData']->session_duration, true);
        $data['sessionDurationData'] = $sessionDurationData;
        $data['relatedCoaching'] = HomeService::getRelateCoachingData($id, $selectedCity);
        $inputObj = new stdClass();
        $inputObj->params = 'coach_id='.$id;
        $inputObj->url = url('coaching-packages');
        $data['packageLink'] = Common::encryptLink($inputObj);
        return view('home.coaching-book', $data);
    }

    public function coachingPackages(){
        $coachingId = $this->memberObj['coach_id'];
        $data['coachData'] = HomeService::coachingBookDataById($coachingId);
        $data['packageData'] = HomeService::getCoachingPackagesDataByCoachId($coachingId);
        return view('home.coaching-package', $data);
    }
}
