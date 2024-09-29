<?php

namespace App\Helpers;
use App\Models\Category;
class Common
{
  public static function encryptLink($inputObj){
    $params = isset($inputObj->params) ? $inputObj->params : '';
    $url = url($inputObj->url);
    if($params!=''){
      $link = $url.'?eq='.urlencode(\Crypt::encrypt($inputObj->params));
      return $link;
    }
    return $url;
  }

  public static function decryptLink($input){
    $decrString = urldecode(\Crypt::decrypt($input));
    $reqArr = [];
    if(strpos($decrString,"=")!==false){
      $keyVal = explode("&",$decrString);
      if(count($keyVal) > 0){
        foreach($keyVal as $v):
          $kvarr = explode("=",$v);
          if(count($kvarr)>0){
            $reqArr[$kvarr[0]] = $kvarr[1];
          }
        endforeach;
      }
    }
    return $reqArr;
  }

//   public static function razorpayCredential(){
//     return [
//       'key'=>'rzp_test_Hz6WNQ7Mmd23f3',
//       'secret_id'=>'uzS1BmibeaZrMQHqjoYjrH5z',
//       'account_number'=>'2323230076407708'
//     ];
//   }

  public static function siteGeneralSettings(){
    $settingData = \Cache::rememberForever('site-general-settings',function(){
      return \App\Models\Setting::select('app_name','email','logo','favicon','footer_copyright','currency','currency_sybmol','timezone','Facebook','Twitter','Instagram')->find(1);
    });
    return $settingData;
  }

  public static function daysArr(){
    return ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
  }

  public static function generateUniqueTicketNum($ticket){
    $checkData = \App\Models\Ticket::where('ticket_number',$ticket)->count();
    return $ticket.($checkData+1);
  }

  public static function allEventCategories(){
    $catData = \Cache::rememberForever('event-categories',function(){
      return \App\Models\Category::select('id','name','slug')->orderBy('order_num','ASC')->where('status',1)->get();
    });
    return $catData;
  }

  
  public static function allEventCities(){
    $catData = \Cache::rememberForever('event-cities',function(){
      return \App\Models\City::select('city_name','id')->groupBy('city_name')->has('selectCity')->get();
    });
    return $catData;
  }

  public static function nextTwoWeeks(){
    $days   = [];
    $period = new \DatePeriod(new \DateTime(), new \DateInterval('P1D'),  14);
    foreach ($period as $day)
    {
        $days[] = $day->format('d M Y');
    }
    return $days;
  }

  public static function generateUniqueCouponNum($ticket){
    $checkData = \App\Models\Coupon::where('coupon_code',$ticket)->count();
    return $ticket.($checkData+1);
  }

  public static function generateUniqueUserTicketNumber($ticket){
    $checkData = \App\Models\OrderChild::where('ticket_number',$ticket)->count();
    return $ticket.($checkData+1);
  }

  public static function abhisheka(){
    $selectedCity = \Session::has('CURR_CITY') ? \Session::get('CURR_CITY') : 'All';
    $date = date("Y-m-d H:i:s");
    $category = Category::select('id','name','slug','image','banner_image','redirect_link')->with(['events'=>function($query) use($date,$selectedCity){
      $query->select('events.name as name','events.id','category_id','events.image','temple_name','t.price','t.discount_type','t.discount_amount')->where([['events.status', 1], ['events.is_deleted', 0], ['event_status', 'Pending']])->where(function($q) use($date){
          $q->where('events.end_time', '>', $date)->orWhereIn('event_type',[2,3]);
      });
      if($selectedCity!='All'){
          $query->where('city_name',$selectedCity);
      }
      $query->leftJoin('tickets as t','t.event_id','events.id');
      $query->orderBy('event_type','ASC')->orderBy('events.start_time', 'desc')->groupBy('events.id')->take(20);
    }])->where('status', 1)->orderBy('order_num', 'ASC')->get();
    // dd($category);
    return $category;

  }

  public static function paymentKeysAll(){
    $settingData = \Cache::rememberForever('payment-keys-all',function(){
      return \App\Models\PaymentSetting::select('razorPublishKey','razorSecretKey')->find(1);
    });
    return $settingData;
  }

  public static function randomMerchantId($userId){
    return substr(str_shuffle($userId.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,3).time().rand(111,999);
  }

  public static function encryptId($string){
    $privateKey 	= 'NXYvSqE96kxiF5rJPn'; // user define key
    $secretKey 		= 'OcXifC2PjV5wf'; // user define secret key
    $encryptMethod  = "AES-256-CBC";
    $string 		= $string; // user define value

    $key = hash('sha256', $privateKey);
    $ivalue = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
    $result = openssl_encrypt($string, $encryptMethod, $key, 0, $ivalue);
    return base64_encode($result);  // output is a encripted value
} 

public static function decryptId($stringEncrypt){
    $privateKey 	= 'NXYvSqE96kxiF5rJPn'; // user define key
    $secretKey 		= 'OcXifC2PjV5wf'; // user define secret key
    $encryptMethod      = "AES-256-CBC";
    $key    = hash('sha256', $privateKey);
    $ivalue = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
    return  openssl_decrypt(base64_decode($stringEncrypt), $encryptMethod, $key, 0, $ivalue);
} 

public static function shippingCharge(){
  return 100;
}

public static function statesAll(){
  $cityData = \Cache::rememberForever('states-all',function(){
    return \DB::table('states')->select('state_title')->where('status','ACTIVE')->get();
  });
  return $cityData;
}

public static function sportAgeGroups($key=null){
  $arr =  [
    1=>'Kids',2=>'Teens',3=>'Adults',4=>'Open For All'
  ];
  if(!is_null($key)){
    return isset($arr[$key]) ? $arr[$key] : '-';
  }
  return $arr;
}



}