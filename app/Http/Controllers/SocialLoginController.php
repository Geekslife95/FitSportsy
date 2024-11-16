<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Session,Auth;
use Stancer;
require app_path('Libraries/stancer/autoload.php');
class SocialLoginController extends Controller
{
    public function loginWithGoogle(){
        return Socialite::driver('google')->redirect();
    }


     public function payment(){
           $config = Stancer\Config::init(['ptest_zkVeBMdpjLlbCbWZHcvBALzn', 'stest_kKqhpWurkgQjwRb4Z1LE2ixf']);

          $config->setMode(Stancer\Config::TEST_MODE); 

            $payment = new Stancer\Payment();
            $payment->setAmount(100);
            $payment->setReturnUrl("https://bookmypujaseva.com/stancer-payment-success");
            $payment->setCurrency('eur');
            $payment->setDescription('Test Payment Company');
            $a = $payment->send();
             \Session::put('PIID',$a->id);

            return redirect("https://payment.stancer.com/ptest_zkVeBMdpjLlbCbWZHcvBALzn/".$a->id."?lang=en");

    }

    public function paymentSuccess(Request $request){
        $config = Stancer\Config::init(['ptest_zkVeBMdpjLlbCbWZHcvBALzn', 'stest_kKqhpWurkgQjwRb4Z1LE2ixf']);
        $config->setMode(Stancer\Config::TEST_MODE); 
        $payment = new Stancer\Payment(\Session::get('PIID'));
        dd($payment);
    }
    

    public function googleAuthLogin(){
        try{
            $user = Socialite::driver('google')->user();
            if($user){
                $checkUser = AppUser::select('id')->where(['social_id'=>$user->id,'login_type'=>'1'])->first();
                if($checkUser){
                    $userId = $checkUser->id;
                }else{
                    $data['name'] = $user->user['given_name'];
                    $data['last_name'] = isset($user->user['family_name']) ? $user->user['family_name'] : null;
                    $data['email'] = $user->email;
                    $data['password'] = \Hash::make('GAUTH');
                    $data['image'] = "defaultuser.png";
                    $data['status'] = 1;
                    $data['provider'] = "LOCAL";
                    $data['language'] = 'English';
                    $data['phone'] = null;
                    $data['is_verify'] = 1;
                    $data['social_id'] = $user->id;
                    $data['login_type'] = 1;
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $userId = AppUser::insertGetId($data);
                }
                Auth::guard('appuser')->loginUsingId($userId);
                if(Session::has('LAST_URL_VISITED')){
                    $redirectLink = Session::get('LAST_URL_VISITED');
                    return redirect($redirectLink);
                }
            }
            return redirect('/');
        }catch(\Exception $e){
            return "LOGIN ERROR <br> <a href='/'>GO TO HOME</a>";
        }
       
    }
}
