<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Session,Auth;

class SocialLoginController extends Controller
{
    public function loginWithGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function googleAuthLogin(){
        $user = Socialite::driver('google')->user();
        if($user){
            $checkUser = AppUser::select('id')->where(['social_id'=>$user->id,'login_type'=>'1'])->first();
            if($checkUser){
                $userId = $checkUser->id;
            }else{
                $data['name'] = $user->user['given_name'];
                $data['last_name'] = $user->user['family_name'];
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
    }
}
