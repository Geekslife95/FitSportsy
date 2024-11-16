<?php
namespace App\Services;

use App\Models\CoachingPackage;

class CoachingPackageService{
    public function getAllCoachingPackagesById(int $coachingId){
        return CoachingPackage::select('id','package_name','package_price','session_days','session_start_time','session_end_time', 'description', 'package_duration')->where('coach_id',$coachingId)->where('is_active',CoachingPackage::STATUS_ACTIVE)->paginate(50);
    }

    public function getCoachingPackageById(int $packageId){
        return CoachingPackage::findorFail($packageId);
    }
}