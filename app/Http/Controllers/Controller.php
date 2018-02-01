<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    function isTargetProduct($data){
        $target=array('ก01','ด01','น01','น02','ป01','ป01-1','ป02','ผ04','ย08','ส01','ห01','ห01-1');
        if(in_array($data, $target)){
            return false;
        }
        else return true;
    }
}
