<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Popups;
use App\Services\HomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $selectedCity = Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'All';
        $cityName = session()->get('CURR_CITY');
        if($cityName != 'All'){
            $data['popup'] = Popups::Where('city',$cityName)->orderBy('id','DESC')->first();
        }else{
            $data['popup'] = "";
        }
        $data['blog'] = HomeService::allBlogs();
        $data['banner'] = HomeService::allHomeBanners();
        $data['products'] = HomeService::allProducts();
        $data['coachings'] = HomeService::getCoachingDataByCity($selectedCity);
        return view('home.index', $data);
    }

    public function coachingBook(int $id, string $title)
    {
        $data['coachData'] = HomeService::coachingBookDataById($id);
        $sessionDurationData = json_decode($data['coachData']->session_duration, true);
        $data['sessionDurationData'] = $sessionDurationData;
        return view('home.coaching-book', $data);
    }
}
