<?php

namespace App\Http\Controllers\User;

use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoachingPackageRequest;
use App\Models\CoachingPackage;
use App\Services\CoachingPackageService;
use Illuminate\Http\Request;
use stdClass;

class CoachingPackageController extends Controller
{
    public function addCoachingPackage()
    {
        $coachingId = $this->memberObj['coaching_id'];
        $inputObj = new stdClass();
        $inputObj->params = 'coaching_id=' . $coachingId;
        $inputObj->url = url('user/store-coaching-package');
        $data['addLink'] = Common::encryptLink($inputObj);
        $data['packageFee'] = [
            'plateform_fee_me' => CoachingPackage::PLATFORM_FEE_ME,
            'plateform_fee_buyer' => CoachingPackage::PLATFORM_FEE_BUYER,
            'gateway_fee_me' => CoachingPackage::GATEWAY_FEE_ME,
            'gateway_fee_buyer' => CoachingPackage::GATEWAY_FEE_BUYER,
        ];
        return view('user.coaching-package.add-coaching-package', $data);
    }

    public function coachingPackagesList(CoachingPackageService $coachingPackageService)
    {
        $coachingId = $this->memberObj['coaching_id'];
        $inputObj = new stdClass();
        $inputObj->params = 'coaching_id=' . $coachingId;
        $inputObj->url = url('user/add-coaching-package');
        $data['addLink'] = Common::encryptLink($inputObj);
        $data['coachingData'] = $coachingPackageService->getAllCoachingPackagesById($coachingId);
        return view('user.coaching-package.coaching-packages-list', $data);
    }

    public function storeCoachingPackage(CoachingPackageRequest $request)
    {
        $coachingPackageObj  = new CoachingPackage();
        $coachingPackageObj->coach_id = $this->memberObj['coaching_id'];
        $coachingPackageObj->package_name = $request->package_name;
        $coachingPackageObj->batch_size = $request->batch_size;
        $coachingPackageObj->package_price = $request->package_price;
        $coachingPackageObj->discount_percent = $request->package_discount;
        $coachingPackageObj->platform_fee_pay_by = $request->platform_fee;
        $coachingPackageObj->gateway_fee_pay_by = $request->gateway_fee;
        $coachingPackageObj->is_pay_now = !empty($request->is_pay_now) ? 1 : 0;
        $coachingPackageObj->is_venue_pay = !empty($request->is_venue_pay) ? 1 : 0;
        $coachingPackageObj->description = $request->description;
        $coachingPackageObj->session_start_time = $request->start_time;
        $coachingPackageObj->is_sold_out = $request->is_sold_out;
        $coachingPackageObj->session_end_time = $request->end_time;
        $coachingPackageObj->session_days = json_encode($request->session_days);
        $coachingPackageObj->package_duration = $request->duration.' '.$request->duration_type;
        $coachingPackageObj->save();
        return redirect('user/coach-booking-list')->with("success", 'Package added successfully...');
    }

    public function editCoachingPackage(CoachingPackageService $coachingPackageService)
    {
        $coachingId = $this->memberObj['coaching_id'];
        $inputObj = new stdClass();
        $inputObj->params = 'coaching_id=' . $coachingId;
        $inputObj->url = url('user/update-coaching-package');
        $data['addLink'] = Common::encryptLink($inputObj);
        $data['packageFee'] = [
            'plateform_fee_me' => CoachingPackage::PLATFORM_FEE_ME,
            'plateform_fee_buyer' => CoachingPackage::PLATFORM_FEE_BUYER,
            'gateway_fee_me' => CoachingPackage::GATEWAY_FEE_ME,
            'gateway_fee_buyer' => CoachingPackage::GATEWAY_FEE_BUYER,
        ];
        $data['packageData'] = $coachingPackageService->getCoachingPackageById($coachingId);
        return view('user.coaching-package.edit-packages-package', $data);
    }

    public function updateCoachingPackage(CoachingPackageRequest $request, CoachingPackageService $coachingPackageService)
    {
        $coachingId = $this->memberObj['coaching_id'];
        $coachingPackageObj  = $coachingPackageService->getCoachingPackageById($coachingId);
        $coachingPackageObj->package_name = $request->package_name;
        $coachingPackageObj->batch_size = $request->batch_size;
        $coachingPackageObj->package_price = $request->package_price;
        $coachingPackageObj->discount_percent = $request->package_discount;
        $coachingPackageObj->platform_fee_pay_by = $request->platform_fee;
        $coachingPackageObj->gateway_fee_pay_by = $request->gateway_fee;
        $coachingPackageObj->description = $request->description;
        $coachingPackageObj->is_pay_now = !empty($request->is_pay_now) ? 1 : 0;
        $coachingPackageObj->is_venue_pay = !empty($request->is_venue_pay) ? 1 : 0;
        $coachingPackageObj->session_start_time = $request->start_time;
        $coachingPackageObj->is_sold_out = $request->is_sold_out;
        $coachingPackageObj->session_end_time = $request->end_time;
        $coachingPackageObj->session_days = json_encode($request->session_days);
        $coachingPackageObj->package_duration = $request->duration.' '.$request->duration_type;
        $coachingPackageObj->save();
        return redirect('user/coach-booking-list')->with("success", 'Package updated successfully...');
    }

    public function removeCoachingPackage()
    {
        $coachingId = $this->memberObj['coaching_id'];
        CoachingPackage::where('id', $coachingId)
            ->update([
                'is_active' => CoachingPackage::STATUS_REMOVED
            ]);
            return redirect('user/coach-booking-list')->with("success", 'Package removed successfully...');
    }
}
