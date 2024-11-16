<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AppUser;
use App\Models\CoachingPackageBooking;
use App\Models\Order;
use Session;
class AuthController extends Controller
{
    public function userLogin(){
        if(\Auth::guard('appuser')->check()==true || \Auth::check()==true){
            return redirect('/');
        }
        return view('frontend.auth.user-login');
    }

    public function organizerLogin(){
        if(\Auth::check()==true){
            return redirect('/dashboard');
        }
        return view('frontend.auth.organizer-login');
    }

    public function userRegister(){
        if(\Auth::guard('appuser')->check()==true || \Auth::check()==true){
            return redirect('/');
        }
        return view('frontend.auth.user-register');
    }

    public function postUserRegister(Request $request){
        $request->validate([
            'first_name'=>'required|max:20',
            'last_name'=>'max:20',
            'email'=>'required|email',
            'mobile_number'=>'required|numeric',
            'password'=>'required|min:5',
            // 'address_one'=>'required'
        ]);

        // dd($request->all());
        $data = $request->all();
        $data['name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['password'] = \Hash::make($request->password);
        $data['address'] = $request->address_one;
        $data['address_two'] = $request->address_two;
        $data['image'] = "defaultuser.png";
        $data['status'] = 1;
        $data['provider'] = "LOCAL";
        $data['language'] = 'English';
        $data['phone'] = $request->mobile_number;
        $data['is_verify'] = 1;
        $data['logintype'] = $request->logintype;
        if ($data['logintype'] == 2) {
            $checkEmail = User::where('email',$request->email)->count();
            if($checkEmail){
                return redirect()->back()->with('warning','Email already exist or registered with us..Please login to continue');
            }
            $user = User::create($data);
            $user->assignRole('Organizer');
            return redirect()->back()->with('success','Congratulations! Your account registration was successful. You can log in to your account')->withInput($request->input());
        } else {
            $checkEmail = AppUser::where('email',$request->email)->count();
            if($checkEmail){
                return redirect()->back()->with('warning','Email already exist or registered with us..Please login to continue')->withInput($request->input());
            }
            $user = AppUser::create($data);
            \Auth::guard('appuser')->login($user);
            return redirect('/');
        }
    }

    public function checkUserLogin(Request $request){
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);

        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
            'status'=>1
        );
        $remember = $request->get('remember_me');
        if ($request->logintype == '1') {
            if (\Auth::guard('appuser')->attempt($userdata, $remember)) {
                if(Session::has('LAST_URL_VISITED')){
                    $redirectLink = Session::get('LAST_URL_VISITED');
                    return redirect($redirectLink);
                }
                return redirect('/');
            } else {
                return \Redirect::back()->with('warning', 'Invalid Username or Password.');
            }
        }else{
            if (\Auth::attempt($userdata, $remember)) {
                return redirect('/dashboard');
            } else {
                return \Redirect::back()->with('warning', 'Invalid Username or Password.');
            }
        }
    }

    public function checkOrganizerLogin(Request $request){
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);

        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
            'status'=>1
        );
        $remember = $request->get('remember_me');
        if (\Auth::attempt($userdata, $remember)) {
            return redirect('/dashboard');
        } else {
            return \Redirect::back()->with('warning', 'Invalid Username or Password.');
        }
    }


    public function logoutUser(){
        \Auth::guard('appuser')->logout();
        \Auth::logout();
        return redirect('/');
    }

    public function myTickets(){
        $userId = \Auth::guard('appuser')->user()->id;
        $ticketData = CoachingPackageBooking::whereHas('coachingPackage')->with(['coachingPackage' => function($query){
            $query->whereHas('coaching')->with('coaching');
        }])->where(['user_id' => $userId, 'is_active' => CoachingPackageBooking::STATUS_ACTIVE])->paginate(50);
        
        return view("frontend.auth.my-tickets",compact('ticketData'));
    }

    public function myProfile(){
        return view("frontend.auth.my-profile");
    }

    public function updateProfile(Request $request){
        $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'address'=>'required',
        ]);
        $userId = \Auth::guard('appuser')->user()->id;
        AppUser::where('id',$userId)->update(
            [
                'name'=>$request->name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'address'=>$request->address,
                'address_two'=>$request->address_two,
                'phone'=>$request->phone,
            ]
        );
        return redirect()->back()->with('success','Profile details updated successfully!!');
    }

    public function accountSettings(){
        return view("frontend.auth.account-settings");
    }

    public function updateUserPassword(Request $request){
        $request->validate([
            'password'=>'required',
            'confirm_password'=>'required',
        ]);
        $userId = \Auth::guard('appuser')->user()->id;
        AppUser::where('id',$userId)->update(['password'=>\Hash::make($request->password)]);
        return redirect()->back()->with('success','Password updated successfully!!');
    }

    public function organizerRegsiter(){
        if(\Auth::check()==true){
            return redirect('/');
        }
        return view('frontend.auth.organizer-register');
    }

    public function postOrganizerRegister(Request $request){
        $request->validate([
            'first_name'=>'required|max:20',
            'last_name'=>'max:20',
            'email'=>'required|email',
            'mobile_number'=>'required|numeric',
            'password'=>'required|min:5',
            'address_one'=>'required'
        ]);

        // dd($request->all());
        $data = $request->all();
        $data['name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['password'] = \Hash::make($request->password);
        $data['address'] = $request->address_one;
        $data['address_two'] = $request->address_two;
        $data['image'] = "defaultuser.png";
        $data['status'] = 1;
        $data['provider'] = "LOCAL";
        $data['language'] = 'English';
        $data['phone'] = $request->mobile_number;
        $data['is_verify'] = 1;
        $data['logintype'] = 2;
        // if ($data['logintype'] == 2) {
            $checkEmail = User::where('email',$request->email)->count();
            if($checkEmail){
                return redirect()->back()->with('warning','Email already exist or registered with us..Please login to continue');
            }
            $user = User::create($data);
            $user->assignRole('Organizer');
            return redirect()->back()->with('success','Congratulations! Your account registration was successful. You can log in to your account')->withInput($request->input());
        // } else {
        //     $checkEmail = AppUser::where('email',$request->email)->count();
        //     if($checkEmail){
        //         return redirect()->back()->with('warning','Email already exist or registered with us..Please login to continue')->withInput($request->input());
        //     }
        //     $user = AppUser::create($data);
        //     \Auth::guard('appuser')->login($user);
        //     return redirect('/');
        // }
    }

  
}
