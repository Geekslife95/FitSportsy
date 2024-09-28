<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $memberObj;
    public function __construct(){
        $this->memberObj = [];
        if(isset($_GET['eq'])){
            $headEq = $_GET['eq'];
            try{
                $arr = \Common::decryptLink($headEq);
                foreach($arr as $key=>$val):
                    $this->memberObj[$key] = $val;
                endforeach;
            }catch(\Exception $e){
                return abort(404);
            }
        }
    }
}
